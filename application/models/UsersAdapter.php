<?php

class Application_Model_UsersAdapter
{
    protected $_dbTable;

    /**
     * @param mixed $dbTable
     */
    public function setDbTable($dbTable)
    {
        $dbTableInstance = null;

        if (is_string($dbTable)){

            $dbTableInstance = new $dbTable();
        }

        if (!$dbTableInstance instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table gateway provided.');
        }

        $this->_dbTable =  $dbTableInstance;
    }

    /**
     * @return mixed
     */
    public function getDbTable()
    {

        if ($this->_dbTable == null){
            $this->setDbTable('Application_Model_DbTable_Users');
        }

        return $this->_dbTable;
    }

    public function save(Application_Model_Users $user){

        $data = array(
            'name' => $user->getName(),
            'username' => $user->getUsername(),
            'password' => sha1($user->getPassword()),
            'email' => $user->getEmail(),
            'role' => $user->getRole()
        );

        if (($id = $user->getIdUsers()) === null){
            unset($data['id_users']);
            $this->getDbTable()->insert($data);
        }else{
            $this->getDbTable()->update($data,array('id_users = ?' => $id));
        }

    }

    public function getNumOfUsers(){

        return count($this->getDbTable()->fetchAll());

    }



}

