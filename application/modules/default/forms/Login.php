<?php

class Default_Form_Login extends Zend_Form /*Plugins_Twitter_Form*/
{
    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id','login_form');
        /*$this->setAttrib('horizontal', true);*/

        $username = new Zend_Form_Element_Text('username');
        $username->setRequired(true)
                 ->setFilters(array('StringTrim','StripTags','StringToLower'))
                 ->setAttribs(array('class'=>'form-control','placeholder'=>'Username'))
                 ->setDecorators(array('ViewHelper')); // permite-me remover os decorators por defeito da zend

        $password = new Zend_Form_Element_Password('password');
        $password->setRequired(true)
                 ->setFilters(array('StringTrim','StripTags','StringToLower'))
                 ->setAttribs(array('class'=>'form-control','placeholder'=>'Password'))
                 ->setDecorators(array('ViewHelper'));

        $logincsrf = new Zend_Form_Element_Hash('logincsrf');
        $logincsrf->setIgnore(true)
                  ->setDecorators(array('ViewHelper'));
//var_dump($logincsrf);die;
        $this->addElements(array($username,$password,$logincsrf));
    }

    /**
     * Load a specific form view for this form
     *
     * @return void|Zend_Form
     */
    public function loadDefaultDecorators()
    {
        $this->setDecorators(
            array(
                array('ViewScript',
                    array('viewScript' => 'index/forms/_login.phtml')
                )
            )
        );
    }


}

