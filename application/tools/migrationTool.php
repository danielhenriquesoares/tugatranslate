<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daniel-soares
 * Date: 8/30/13
 * Time: 6:50 PM
 * To change this template use File | Settings | File Templates.
 */





class MigrationTool{

    // default values
    private $libraryLocation = '/library/Zend/';
    private $configType = 'Config/';
    private $configuration = '/configs';
    private $migrationsFolderName = 'migrations/';

    private $_user = null;
    private $_password = null;
    private $_dbName = null;
    private $_dbCon = null;

    public function __construct(){
        defined('APPLICATION_LIBRARY') || define('APPLICATION_LIBRARY',realpath(dirname(__FILE__).'/../..').$this->getLibraryLocation());
        defined('APPLICATION_INI_CONFIG') || define('APPLICATION_INI_CONFIG',APPLICATION_LIBRARY.$this->getConfigType());
        defined('APPLICATION_CONFIGURATION') || define('APPLICATION_CONFIGURATION',realpath(dirname(__FILE__).'/..').$this->configuration.'/application.ini');
        defined('APPLICATION_MIGRATIONS') || define('APPLICATION_MIGRATIONS',realpath(dirname(__FILE__).'/..').$this->configuration.'/migrations.php');
        defined('APPLICATION_ROOT') || define('APPLICATION_ROOT',realpath(dirname(__FILE__).'/..').'/modules/');
    }

    public function setLibraryLocation($libraryLocation){
        $this->libraryLocation = $libraryLocation;
    }

    public function getLibraryLocation(){
        return $this->libraryLocation;
    }

    public function setConfigType($configType = null){

        if ($configType !== null){
            $this->configType = $this->configType . $configType;
        }else{
            $this->configType = $this->configType . 'Ini.php';
        }
    }

    public function getMigrationFolderName(){
        return $this->migrationsFolderName;
    }

    public function getConfigType(){

        $this->setConfigType();

        return $this->configType;
    }

    public function setUser($user){

        $this->_user = $user;
    }

    public function setPassword($password){

        $this->_password = $password;
    }

    public function setDbName($dbName){
        $this->_dbName = $dbName;
    }

    public function getUser(){

        return $this->_user;
    }

    public function getPassword(){

        return $this->_password;
    }

    public function getDbName(){

        return $this->_dbName;
    }

    private function _getDbConnection(){

        try{

            $this->_setDbParams();

            if ($this->_dbCon === null){

                $dsn = 'mysql:dbname='.$this->getDbName().';host=127.0.0.1:3306';
                $user = $this->getUser();
                $password = $this->getPassword();
                $this->_dbCon = new PDO($dsn, $user, $password);


            }

            return $this->_dbCon;

        }catch(PDOException $ex){
            echo 'Error accessing database: ' . $ex;
        }


    }

    private function _setDbParams(){

        include_once APPLICATION_INI_CONFIG;

        $config = new Zend_Config_Ini(APPLICATION_CONFIGURATION,'development');

        $developmentConfigs = $config->toArray();

        $dbParams = $developmentConfigs['resources']['db']['params'];

        $this->setUser($dbParams['username']);
        $this->setPassword($dbParams['password']);
        $this->setDbName($dbParams['dbname']);

    }

    private function _fetchData($query){

        $connection = $this->_getDbConnection();

        $sql = $query;

        $data = $connection->query($sql);

        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    private function _insertData(array $data){

        $connection = $this->_getDbConnection();
        $sql = "INSERT INTO migrations (identifier,file,module,content) VALUES ("
            .addslashes($data['identifier']).
            ",".addslashes($data['file']).
            ",".addslashes($data['module']).
            ",".addslashes($data['content'])."')";
        $connection->exec($sql);

    }

    /**
     * Get migrations from migrations file
     *
     * @return array
     * @throws Exception
     */
    private function _getMigrations(){

        if (!file_exists(APPLICATION_MIGRATIONS)){
            throw new Exception('File not found exception: ' . APPLICATION_MIGRATIONS);
        }

        $migrations = null;
        include APPLICATION_MIGRATIONS;

        if (!is_array($migrations) || $migrations === null ){
            throw new Exception('Invalid variavel type defined in: ' . APPLICATION_MIGRATIONS);
        }

        return $migrations;

    }


    public function run(){


        try{

            $db = $this->_getDbConnection();

            $migrations = $this->_getMigrations();
            $executedMigrations = $this->_fetchData('SELECT * FROM migrations');

            foreach ($migrations as $k => $v){
                $found = false;
                $query = '';
                echo "================================================================================================";
                echo "|                       $k ----------".$v['file']."                                            |";
                echo "================================================================================================";
                for($i = 0; $i < count($executedMigrations) && $found == false; $i++){

                   if ($executedMigrations[$i]['identifier'] == $k){
                       $found = true;
                    }

                }

                if ($found == false){

                    echo "Migration not found execute and add to migrations table\n";

                    //echo APPLICATION_ROOT.$v['module'].$this->getMigrationFolderName().$v['file']."\n";die;

                    $query = file_get_contents(APPLICATION_ROOT.$v['module'].$this->getMigrationFolderName().$v['file']);
                    $query = preg_replace('/\s+/',' ',trim($query));

                    // descomentar para testar
                    $db->exec($query);
                    $data = array(
                        'identifier' => $k,
                        'file' => $v['file'],
                        'module' => $v['module'],
                        'content' => $query
                    );

                    /*$data = array(
                        'identifier' => '1.0001',
                        'file' => 'cenas.php',
                        'module' => 'default/',
                        'content' => 'sdsdfsdfsdf'
                    );*/

                    /*$test="INSERT INTO migrations (identifier,file,module,content) VALUES (".
                    $data['identifier'].
                    ",'".$data['file']."'".
                    ",'".$data['module']."'".
                    ",'".$data['content']."')";*/


                    //$db->exec($test);

                    //var_dump($query);die;
                    // Descomentar para testar
                    $this->_insertData($data);

                }

                echo "\n\n";

            }

        }catch(Exception $ex){
            echo 'Error found: ' . $ex;
        }


    }
}

$migrationTool = new MigrationTool();
$migrationTool->run();


