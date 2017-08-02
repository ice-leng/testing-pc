<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/31
 * Time: 下午5:56
 */

namespace console\models;


use Codeception\Util\Template;
use lengbin\helper\directory\FileHelper;
use lengbin\helper\pinyin\PinyinHelper;

class CreatePhpFile
{

    protected $beforeContent = '';
    protected $caseContent = '';
    protected $type;
    protected $phpFile;
    protected $fileName;
    protected $name;

    protected function conversionName($name)
    {
        if (empty($name)) {
            return $name;
        }
        return PinyinHelper::pinyin($name);
    }

    protected function conversionVariable($name)
    {
        return '$' . $name;
    }

    public function head($workflow)
    {
        $this->name = $name = isset($workflow['name']) ? $workflow['name'] : '';
        $this->fileName = $this->conversionName($name) . 'Cest';
        $this->phpFile = <<<EDF
<?php 
    
class {$this->fileName}
{    
    protected {$this->conversionVariable('imagePath')};
    
    public function __construct()
    {
        {$this->conversionVariable('path')} = \Yii::getAlias('@api');
        {$this->conversionVariable('this')}->imagePath = str_replace({$this->conversionVariable('path')} . '/web', '', codecept_output_dir());
    }
    {{before}}
    
    {{case}}
}   
?>
EDF;

    }

    public function setBefore(array $beforeCases)
    {

    }

    public function setType($type)
    {
        $this->type = $type;
    }

    protected function setSuccessCaseLogContent($case, $name)
    {
        $testCaseId = isset($case['test_item_id']) ? $case['test_item_id'] : 0;
        $time = time();
        $content = <<<EDF
{$this->conversionVariable('key')} = '{$this->name}-{$this->conversionName($name)}';
            {$this->conversionVariable('log')} = ['{$testCaseId}', '{$name}', 1, 1, '', {$time}, {$time}];
            \Helper\BaseHelperCase::getInstance(codecept_output_dir())->setLog({$this->conversionVariable('key')}, {$this->conversionVariable('log')});
EDF;
        return $content;
    }

    protected function setFailCaseLogContent($name)
    {
        $content = <<<EDF
{$this->conversionVariable('log')}[2] = 2;
            {$this->conversionVariable('log')}[4] = '{$this->fileName}.{$name}.fail.png';
            \Helper\BaseHelperCase::getInstance(codecept_output_dir())->setLog({$this->conversionVariable('key')}, {$this->conversionVariable('log')});
EDF;
        return $content;
    }

    /*
            $I->wantTo('xx');
            $I->amOnPage('/');
            $I->fillField('username','davert');
            $I->fillField('password','qwerty');
            $I->click('/html[1]/body[1]/div[1]/div[1]/div[2]');
            $I->wait(2);
            $I->see('账号不存在');
     */


    protected function step($case)
    {
        $count = <<<EDf



EDf;
        return $count;
    }

    protected function accept($case)
    {
        $count = <<<EDf



EDf;
        return $count;
    }

    protected function acceptanceCase($case)
    {
        $name = isset($case['name']) ? $case['name'] : '';
        $cName = $this->conversionName($name);
        $successCaseLogContent = $this->setSuccessCaseLogContent($case, $name);
        $failCaseLogContent    = $this->setFailCaseLogContent($cName);
        $step = $this->step($case);
        $accept = $this->accept($case);
        $content = <<<EDf
public function {$cName}(AcceptanceTester {$this->conversionVariable('I')})
    {
        try{
            {$successCaseLogContent}
            {$step}
            {$accept}
        }catch (Exception {$this->conversionVariable('e')}){
            {$failCaseLogContent}
            throw {$this->conversionVariable('e')};
        }
    }
    
    
EDf;
        $this->caseContent .= $content;
    }

    protected function apiCase($case)
    {

    }

    public function setCase($case)
    {
        $fn = $this->type . 'Case';
        $this->$fn($case);
    }

    protected function clear()
    {
        $this->caseContent = '';
        $this->type = '';
        $this->phpFile = '';
        $this->fileName = '';
        $this->beforeContent = '';
        $this->name = '';
    }

    public function generateFile($dir)
    {
        $content = (new Template($this->phpFile))
            ->place('before', $this->beforeContent)
            ->place('case', $this->caseContent)
            ->produce();
        $path = $dir . '/' . $this->type . '/' . $this->fileName . '.php';
        FileHelper::putFile($path, $content);
        $this->clear();
    }


}