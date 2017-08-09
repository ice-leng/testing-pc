<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/23
 * Time: 下午12:50
 */

namespace Codeception\Extension;

use Codeception\Event\TestEvent;
use Codeception\Test\Descriptor;
use Codeception\Util\Template;
use lengbin\helper\directory\DirHelper;
use lengbin\helper\directory\FileHelper;


class Recorders extends \Codeception\Extension\Recorder
{
    public function before(TestEvent $e)
    {
        if (!$this->webDriverModule) {
            return;
        }
        $this->dir = null;
        $this->stepNum = 0;
        $this->slides = [];
        $testName = preg_replace('~\W~', '_', Descriptor::getTestAsString($e->getTest()));
//        $api = \Yii::getAlias('@api');
//        $this->dir = $api . '/web/tests/' . date('Ymd') . '/record_' . date('Him') . '/' . $testName;
        $this->dir = codecept_output_dir() . "../record/"."record_{$this->seed}_$testName";
        DirHelper::pathExists($this->dir);
    }

    public function afterSuite()
    {
        if (!$this->webDriverModule or !$this->dir) {
            return;
        }
        $links = '';
        foreach ($this->recordedTests as $link => $url) {
            $links .= "<li><a href='$url'>$link</a></li>\n";
        }
        $indexHTML = (new Template($this->indexTemplate))
            ->place('seed', date('YmdHim'))
            ->place('records', $links)
            ->produce();
        $dir = dirname($this->dir);
        FileHelper::putFile($dir . '/index.htm', $indexHTML);
        $this->writeln("⏺ Records saved into: <info>file://" . $dir . 'index.html</info>');
    }

    public function persist(TestEvent $e)
    {
        if (!$this->webDriverModule or !$this->dir) {
            return;
        }
        $indicatorHtml = '';
        $slideHtml = '';
        foreach ($this->slides as $i => $step) {
            $indicatorHtml .= (new Template($this->indicatorTemplate))
                ->place('step', (int)$i)
                ->place('isActive', (int)$i ? '' : 'class="active"')
                ->produce();

            $slideHtml .= (new Template($this->slidesTemplate))
                ->place('image', $i)
                ->place('caption', $step->getHtml('#3498db'))
                ->place('isActive', (int)$i ? '' : 'active')
                ->place('isError', $step->hasFailed() ? 'error' : '')
                ->produce();
        }

        $html = (new Template($this->template))
            ->place('indicators', $indicatorHtml)
            ->place('slides', $slideHtml)
            ->place('feature', $e->getTest()->getFeature())
            ->place('test', Descriptor::getTestSignature($e->getTest()))
            ->place('carousel_class', $this->config['animate_slides'] ? ' slide' : '')
            ->produce();

        $indexFile = $this->dir . DIRECTORY_SEPARATOR . 'index.html';
        file_put_contents($indexFile, $html);
        $testName = Descriptor::getTestSignature($e->getTest()) . ' - ' . $e->getTest()->getFeature();
        $dir = codecept_output_dir() . '/../record';
        $this->recordedTests[$testName] = substr($indexFile, strlen($dir));
    }

}