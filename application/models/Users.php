<?php

class Application_Model_Users
{
    protected $_id_users;
    protected $_name;
    protected $_username;
    protected $_email;
    protected $_password;
    protected $_role;

    public function __construct(array $options = null){

        if (is_array($options)){
            $this->setOptions($options);
        }
    }

    public function __set($name,$value){

        $method = 'set' . ucfirst($name);

        if ($name === 'mapper' || !method_exists($this,$method)){
            throw new Exception('Invalid method name provided');
        }

        $this->$method($value);
    }

    public function __get($name){

        $method = 'get' . ucfirst($name);

        if ($name === 'mapper' || !method_exists($this,$method)){
            throw new Exception('Invalid method name provided');
        }

        return $this->$method();

    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $id_users
     */
    public function setIdUsers($id_users)
    {
        $this->_id_users = $id_users;
    }

    /**
     * @return mixed
     */
    public function getIdUsers()
    {
        return $this->_id_users;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->_role = $role;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    public function setOptions(array $options){

        $methods = get_class_methods($this);

        foreach ($options as $key => $value){
            $method = 'set' . ucfirst($key);

            if (in_array($method,$methods)){

                $this->$method($value);
            }
        }

    }

}

