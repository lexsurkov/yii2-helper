<?php

namespace lexsurkov\helper\migrations;

use lexsurkov\helper\migrations\traits\TextTypesTrait;

class Migration extends \yii\db\Migration
{
    use TextTypesTrait;
    /**
     * @var string
     */
    protected $tableOptions;
    //protected $engine = 'MyISAM';
    protected $engine = 'InnoDB';
    protected $restrict = 'RESTRICT';
    protected $cascade = 'CASCADE';
    protected $dbType;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        switch ($this->db->driverName) {
            case 'mysql':
                $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE='.$this->engine;
                $this->dbType = 'mysql';
                break;
            case 'pgsql':
                $this->tableOptions = null;
                $this->dbType = 'pgsql';
                break;
            case 'dblib':
            case 'mssql':
            case 'sqlsrv':
                $this->restrict = 'NO ACTION';
                $this->tableOptions = null;
                $this->dbType = 'sqlsrv';
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');
        }
    }

    public function up()
    {
        try {
            $this->safeUp();
        } catch (\Exception $e) {
            return $this->migrateContinue('Exception: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n");
        }
        return null;
    }

    protected function migrateContinue($textError=null){
        echo PHP_EOL . $textError;
        $answer = readline('Произошли ошибки выполнения, желаете продолжить? (yes|no) [no]: ');
        while (!isset($answer) && !in_array($answer, ["yes", "no"])){
            $answer = readline('Произошли ошибки выполнения, желаете продолжить? (yes|no) [no]: ');
        }
        if ($answer == "yes")
            return true;
        return false;
    }
}
