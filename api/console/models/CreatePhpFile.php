<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/31
 * Time: 下午5:56
 */

namespace console\models;


use Codeception\Util\Template;
use common\helpers\ConstantHelper;
use lengbin\helper\directory\FileHelper;
use lengbin\helper\pinyin\PinyinHelper;

class CreatePhpFile
{

    protected $caseContent = '';
    protected $phpFile;
    protected $fileName;
    protected $name;
    protected $testCase = [];
    protected $rootUrl = '';

    protected $items = [];
    protected $projects = [];
    protected $rightCase = [];
    protected $testAccept = [];

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

    public function body($workflow)
    {
        $project = isset($this->projects[$workflow['project_id']]) ? $this->projects[$workflow['project_id']] : [];
        $this->rootUrl = isset($project['url']) ? $project['url'] : '';
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
    
    {{case}}
}   
?>
EDF;

    }


    protected function setSuccessCaseLogContent($testItemId, $name)
    {
        $time = time();
        $content = <<<EDF
{$this->conversionVariable('key')} = '{$this->name}-{$this->conversionName($name)}';
            {$this->conversionVariable('log')} = ['{$testItemId}', '{$name}', 1, 1, '', {$time}, {$time}];
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

    protected function setBefore($beforeCases)
    {
        $count = '';
        $itemIds = explode(',', $beforeCases);
        foreach ($itemIds as $key => $itemId) {
            $rightCase = isset($this->rightCase[$itemId]) ? $this->rightCase[$itemId] : [];
            $count .= $this->head($rightCase, $key === 0);
            $count .= $this->step($rightCase);
            $count .= $this->accept($itemId);
        }
        return $count;
    }

    private function _getTestItemByCase($case)
    {
        $itemId = isset($case['test_item_id']) ? $case['test_item_id'] : 0;
        return isset($this->items[$itemId]) ? $this->items[$itemId] : [];
    }

    private function _name($case)
    {
        $name = isset($case['name']) ? $case['name'] : '';
        $content = <<<EDf
{$this->conversionVariable('I')}->wantTo('{$name}');
EDf;
        return $content;
    }

    private function _caseWait($time)
    {
        return "{$this->conversionVariable('I')}->wait('{$time}');";
    }

    private function _caseEvent($case)
    {
        $type = isset($case['event_type']) ? $case['event_type'] : 0;
        $element = isset($case['element']) ? $case['element'] : '';
        $params = isset($case['element_params']) ? $case['element_params'] : '';
        switch ($type) {
            case ConstantHelper::TEST_CASE_EVENT_TYPE_INPUT:
                $content = "{$this->conversionVariable('I')}->fillField('{$element}','{$params}');";
                break;
            case ConstantHelper::TEST_CASE_EVENT_TYPE_CLIENT:
                $content = "{$this->conversionVariable('I')}->click('{$element}');";
                break;
            case ConstantHelper::TEST_CASE_EVENT_TYPE_SELECT:
                $content = "{$this->conversionVariable('I')}->checkOption('{$element}');";
                break;
            case ConstantHelper::TEST_CASE_EVENT_TYPE_CHECKBOX:
                $content = "{$this->conversionVariable('I')}->selectOption('{$element}', '{$params}');";
                break;
            case ConstantHelper::TEST_CASE_EVENT_TYPE_FILE:
                $content = "{$this->conversionVariable('I')}->attachFile('{$element}','{$params}');";
                break;
            case ConstantHelper::TEST_CASE_EVENT_TYPE_WAIT:
                $content = $this->_caseWait($params);
                break;
            default:
                $content = '';
                break;
        }
        return $content;
    }

    private function _getAccept($testItemId)
    {
        $count = '';
        $accepts = isset($this->testAccept[$testItemId]) ? $this->testAccept[$testItemId] : [];
        foreach ($accepts as $accept) {
            $count .= $this->_caseAccept($accept);
        }
        return $count;
    }

    private function _caseAccept($accept)
    {
        $type = isset($accept['accept_type']) ? $accept['accept_type'] : 0;
        $element = isset($accept['element']) ? $accept['element'] : '';
        $params = isset($accept['accept_params']) ? $accept['accept_params'] : '';
        switch ($type) {
            case ConstantHelper::TEST_ACCEPT_TYPE_STRING_SEE:
                $content = "{$this->conversionVariable('I')}->see('{$element}','{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_STRING_NOT_SEE:
                $content = "{$this->conversionVariable('I')}->dontSee('{$element}','{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_CHECK_CHECKED:
                $content = "{$this->conversionVariable('I')}->seeCheckboxIsChecked('{$element}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_CHECK_NOT_CHECKED:
                $content = "{$this->conversionVariable('I')}->dontSeeCheckboxIsChecked('{$element}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_SELECT_SELECTED:
                $content = "{$this->conversionVariable('I')}->seeOptionIsSelected('{$element}','{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_SELECT_NOT_SELECTED:
                $content = "{$this->conversionVariable('I')}->dontSeeOptionIsSelected('{$element}','{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_COOKIE_SEE:
                $content = "{$this->conversionVariable('I')}->seeCookie('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_COOKIE_NOT_SEE:
                $content = "{$this->conversionVariable('I')}->dontSeeCookie('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_URL_EQUAL:
                $content = "{$this->conversionVariable('I')}->seeCurrentUrlEquals('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_URL_NOT_EQUAL:
                $content = "{$this->conversionVariable('I')}->dontSeeCurrentUrlEquals('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_URL_MATCH:
                $content = "{$this->conversionVariable('I')}->seeCurrentUrlMatches('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_URL_NOT_MATCH:
                $content = "{$this->conversionVariable('I')}->dontSeeCurrentUrlMatches('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_CURRENT_URL_IN:
                $content = "{$this->conversionVariable('I')}->seeInCurrentUrl('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_CURRENT_URL_NOT_IN:
                $content = "{$this->conversionVariable('I')}->dontSeeInCurrentUrl('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_ELEMENT_SEE:
                $content = "{$this->conversionVariable('I')}->seeInCurrentUrl('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_ELEMENT_NOT_SEE:
                $content = "{$this->conversionVariable('I')}->dontSeeInCurrentUrl('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_SOURCE_IN:
                $content = "{$this->conversionVariable('I')}->seeInSource('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_SOURCE_NOT_IN:
                $content = "{$this->conversionVariable('I')}->dontSeeInSource('{$params}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_LINK_SEE:
                $content = "{$this->conversionVariable('I')}->seeLink('{$element}');";
                break;
            case ConstantHelper::TEST_ACCEPT_TYPE_LINK_NOT_SEE:
                $content = "{$this->conversionVariable('I')}->dontSeeLink('{$element}');";
                break;
            default:
                $content = '';
                break;
        }
        return $content;


    }

    protected function head($case, $isFirst = false)
    {
        $item = $this->_getTestItemByCase($case);
        $type = isset($item['type']) ? $item['type'] : 0;
        $url = '';
        if ($type === ConstantHelper::TEST_ITEM_TYPE_HREF) {
            $url = isset($item['url']) ? $item['url'] : '';
        }
        if ($url === '' && $isFirst) {
            $url = $this->rootUrl;
        }
        $content = $this->_name($case);
        if (!empty($url)) {
            $content = <<<EDf
{$content}
            {$this->conversionVariable('I')}->amOnUrl('{$url}');
EDf;
        }
        return $content;
    }

    protected function step($case)
    {
        $data = $this->_caseEvent($case);
        $content = <<<EDf
{$data}

EDf;
        return $content;
    }

    protected function accept($testItemId)
    {
        $data = $this->_getAccept($testItemId);
        $content = <<<EDf
{$data}

EDf;
        return $content;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function setProjects(array $projects)
    {
        $this->projects = $projects;
    }

    public function setRightCase(array $case)
    {
        $this->rightCase = $case;
    }

    public function setTestAccepts(array $accepts)
    {
        $this->testAccept = $accepts;
    }

    public function setCase($case)
    {
        $testItemId = isset($case['test_item_id']) ? $case['test_item_id'] : 0;
        if (!isset($this->testCase["step{$testItemId}"]) || empty($this->testCase["step{$testItemId}"])) {
            $name = isset($case['name']) ? $case['name'] : '';
            $cName = $this->conversionName($name);
            $successCaseLogContent = $this->setSuccessCaseLogContent($testItemId, $name);
            $failCaseLogContent = $this->setFailCaseLogContent($cName);
            $content = <<<EDf
public function {$cName}(AcceptanceTester {$this->conversionVariable('I')})
    {
        try{
            {$successCaseLogContent}
            {{step{$testItemId}}}
            {{accept{$testItemId}}}
        }catch (Exception {$this->conversionVariable('e')}){
            {$failCaseLogContent}
            throw {$this->conversionVariable('e')};
        }
    }
    
    
EDf;
            $this->caseContent .= $content;
            if (isset($case['before_item']) && !empty($case['before_item'])) {
                $this->testCase["step{$testItemId}"] = $this->setBefore($case['before_item']);
            } else {
                $this->testCase["step{$testItemId}"] = $this->head($case, true);
            }
        }

        $this->testCase["step{$testItemId}"] .= $this->step($case);

        if (isset($this->testCase["accept{$testItemId}"])) {
            $this->testCase["accept{$testItemId}"] .= $this->accept($testItemId);
        } else {
            $this->testCase["accept{$testItemId}"] = $this->accept($testItemId);
        }
    }

    protected function clear()
    {
        $this->caseContent = '';
        $this->phpFile = '';
        $this->fileName = '';
        $this->name = '';
        $this->testCase = [];
    }

    public function generateFile($dir)
    {
        $t = (new Template($this->caseContent));
        foreach ($this->testCase as $key => $value) {
            $t->place($key, $value);
        }
        $stepContent = $t->produce();
        $content = (new Template($this->phpFile))
            ->place('case', $stepContent)
            ->produce();
        $path = $dir . '/acceptance/' . $this->fileName . '.php';
        FileHelper::putFile($path, $content);
        $this->clear();
        return true;
    }


}