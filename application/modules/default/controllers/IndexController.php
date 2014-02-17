<?php

class Default_IndexController extends Zend_Controller_Action
{

    private $_loginForm = null;

    private $_usersDbTable = null;

    private $_userAdapter = null;

    private $_session = null;

    private $_registerForm = null;

    protected function getLoginForm()
    {

        if ($this->_loginForm === null){
            $this->_loginForm = new Default_Form_Login();
            $this->_loginForm->setAction('default/index/login');
        }

        return $this->_loginForm;
    }

    protected function getUsersDbTable()
    {

        if ($this->_usersDbTable === null){
            $this->_usersDbTable = new Application_Model_DbTable_Users();
        }

        return $this->_usersDbTable;
    }

    protected function getUsersAdapter()
    {

        if ($this->_userAdapter === null){

            $this->_userAdapter = new Application_Model_UsersAdapter();
        }

        return $this->_userAdapter;

    }

    protected function getSession()
    {

        if ($this->_session === null){
            $this->_session = new Zend_Auth_Storage_Session();
        }

        return $this->_session;
    }

    protected function getRegisterForm()
    {
        if ($this->_registerForm === null){
            $this->_registerForm = new Default_Form_Register();
            $this->_registerForm->setAction('/default/index/register');
        }

        return $this->_registerForm;
    }

    public function indexAction()
    {
        $this->_helper->layout()->loginform = $this->getLoginForm();
    }

    public function loginAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        // O formulário de login foi submetido
        if ($this->getRequest()->isPost()){

            // Verificar se a tabela tem registos
            if (!$this->getUsersAdapter()->getNumOfUsers()){
                $this->redirect('index/register');
            }

            if ($this->getLoginForm()->isValid($this->_request->getPost())){

                $data = $this->_loginForm->getValues();

                $auth = Zend_Auth::getInstance();

                $authAdapter = new Zend_Auth_Adapter_DbTable($this->getUsersDbTable()->getAdapter(),'users');
                $authAdapter->setIdentityColumn('username')
                    ->setCredentialColumn('password');

                $encryptedPassword = sha1($data['password'].Zend_Registry::getInstance()->constants->salt);

                $authAdapter->setIdentity($data['username'])
                    ->setCredential($encryptedPassword);

                if ($auth->authenticate($authAdapter)->isValid()){

                    $authAdapterOject = $authAdapter->getResultRowObject();

                    $this->getSession()->write($authAdapterOject);

                    $this->redirect('admin/index');
                }
            }else{

                // Form apresenta erros, redireccionar para a página com o login form e com os erros

            }
        }
    }

    public function registerAction()
    {
        if ($this->getRequest()->isPost()){

            if ($this->getRegisterForm()->isValid($this->_request->getPost())){
                $data = $this->getRegisterForm()->getValues();

            }else{

            }
        }

        $this->_helper->layout()->loginform = $this->getLoginForm();
        $this->view->registerForm = $this->getRegisterForm();
    }


}





