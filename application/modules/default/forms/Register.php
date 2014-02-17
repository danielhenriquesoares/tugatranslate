<?php

class Default_Form_Register extends Zend_Form
{
    private $font = '/usr/share/fonts/truetype/msttcorefonts/times.ttf';
    private $imageCaptchaDir = '/../public/captcha';
    private $imageUrl = '/captcha';

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id','register_form');

        $name = new Zend_Form_Element_Text('username');
        $name->setRequired(true)
            ->setFilters(array('StringTrim','StripTags','StringToLower'))
            ->setAttribs(array('class'=>'form-control','placeholder'=>'Name'))
            ->setDecorators(array('ViewHelper'))
            ->setValidators(array(
                    'NotEmpty',
                    array('StringLength', false, array(6))
                ))
            ->removeDecorator('Errors');

        $email = new Zend_Form_Element_Text('useremail');
        $email->setRequired(true)
            ->setFilters(array('StringTrim','StripTags','StringToLower'))
            ->setValidators(array(
                    'EmailAddress'
                ))
            ->setAttribs(array('class'=>'form-control','placeholder'=>'Email'))
            ->setDecorators(array('ViewHelper'))
            ->removeDecorator('Errors');

        $usernameregister = new Zend_Form_Element_Text('usernameregister');
        $usernameregister->setRequired(true)
            ->setFilters(array('StringTrim','StripTags','StringToLower'))
            ->setAttribs(array('class'=>'form-control','placeholder'=>'Username'))
            ->setDecorators(array('ViewHelper'))
            ->setValidators(array(
                    'NotEmpty',
                    array('StringLength', false, array(6))
                ))
            ->removeDecorator('Errors');

        $passwordregister = new Zend_Form_Element_Password('passwordregister');
        $passwordregister->setRequired(true)
            ->setFilters(array('StringTrim','StripTags','StringToLower'))
            ->setAttribs(array('class'=>'form-control','placeholder'=>'Password'))
            ->setDecorators(array('ViewHelper'))
            ->setValidators(array(
                    'NotEmpty',
                    array('StringLength', false, array(6))
                ))
            ->removeDecorator('Errors');

        $passwordretype = new Zend_Form_Element_Password('passwordretype');
        $passwordretype->setRequired(true)
            ->setFilters(array('StringTrim','StripTags','StringToLower'))
            ->setValidators(array(
                    array('identical', false, array('token' => 'passwordregister')),
                    'NotEmpty',
                    array('StringLength', false, array(6))
                ))
            ->setAttribs(array('class'=>'form-control','placeholder'=>'Password Retype'))
            ->setDecorators(array('ViewHelper'))
            ->removeDecorator('Errors');

        $captcha = new Zend_Form_Element_Captcha('captcha',array(
            'placeholder' => 'Please enter the above code',
            'class' => 'form-control captcha-style',
            'captcha'    => array(
                'required'   => true,
                'captcha' => 'Image',
                'font' => $this->font,
                'fontSize' => '24',
                'height' => '50',
                'width' => '200',
                'imgDir' => APPLICATION_PATH . $this->imageCaptchaDir,
                'imgUrl' => Zend_Controller_Front::getInstance()->getBaseUrl().$this->imageUrl,
                'imgAlt' => 'Captcha Image',
                'dotNoiseLevel' => 50,
                'lineNoiseLevel' => 5,
                'gcFreq' => '5'
            ))
        );
        $captcha->setDecorators(array('ViewHelper'));
        $captcha->removeDecorator('viewhelper');
        $captcha->setValidators(
                    array(
                          'NotEmpty',
                          array('StringLength', false, array(6))
                    )
        )
                ->removeDecorator('Errors');

        $registercsrf = new Zend_Form_Element_Hash('registercsrf');
        $registercsrf->setIgnore(true)
                     ->setDecorators(array('ViewHelper')); // Remove the zend framework default decorators

        $this->addElements(array($name, $email, $usernameregister, $passwordregister, $passwordretype, $registercsrf, $captcha));

    }

    /**
     * Load a specific view for the register form
     *
     * @return void|Zend_Form
     */
    public function loadDefaultDecorators()
    {
        $this->setDecorators(
            array(
                array('ViewScript',
                    array('viewScript' => 'index/forms/_reg.phtml')
                )
            )
        );
    }

}

