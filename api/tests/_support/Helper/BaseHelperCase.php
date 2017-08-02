<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/27
 * Time: 下午5:37
 */

namespace Helper;

use lengbin\helper\mysql\PdoMysqlHelper;
use Symfony\Component\Yaml\Yaml;

class BaseHelperCase
{

    private static $_instance = [];

    private $_log = [];

    protected $db;

    public function __construct($id)
    {
        $base64 = base64_encode($id);
        self::$_instance[$base64] = $this;
    }

    public static function getInstance($id)
    {
        $base64 = base64_encode($id);
        if (!isset(self::$_instance[$base64]) || empty(self::$_instance[$base64])) {
            new BaseHelperCase($id);
        }
        return self::$_instance[$base64];
    }

    public function setLog($k, $v)
    {
        $this->_log[$k] = $v;
    }

    public function getLog()
    {
        return $this->_log;
    }

    protected function getDb()
    {
        if (empty($this->db)) {
            $file = __DIR__ . '/db.yml';
            $params = Yaml::parse(file_get_contents($file));
            $db = isset($params['db']) ? $params['db'] : [];
            $host = isset($db['host']) ? $db['host'] : '';
            $database = isset($db['database']) ? $db['database'] : '';
            $user = isset($db['user']) ? $db['user'] : '';
            $pass = isset($db['pass']) ? $db['pass'] : '';
            $this->db = PdoMysqlHelper::getInstance($host, $database, $user, $pass);
        }
        return $this->db;
    }

    public function batchAddLog()
    {
        $tableName = 'test_log';
        $this->getDb()->truncate($tableName);
        return $this->getDb()->batchInsert($tableName, [
            'test_case_id',
            'name',
            'status',
            'type',
            'url',
            'created_at',
            'updated_at',
        ], $this->_log);
    }


}