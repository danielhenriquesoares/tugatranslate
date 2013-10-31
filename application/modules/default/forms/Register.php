<?php

class Default_Form_Register extends Zend_Form
{
    private $font = /*'/usr/share/fonts/truetype/ttf-xfree86-nonfree/luximbi.ttf'*/'/usr/share/fonts/truetype/msttcorefonts/times.ttf';
    private $imageCaptchaDir = '/../public/captcha';
    private $imageUrl = '/captcha';

    // '/usr/share/fonts/truetype/ttf-xfree86-nonfree/luximbi.ttf'
    // APPLICATION_PATH.'/../public/captcha'
    // Zend_Controller_Front::getInstance()->getBaseUrl().'/captcha'
    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id','register_form');

        $usernameregister = new Zend_Form_Element_Text('usernameregister');
        $usernameregister->setRequired(true)
            ->setFilters(array('StringTrim','StripTags','StringToLower'))
            ->setAttribs(array('class'=>'form-control','placeholder'=>'Username'))
            ->setDecorators(array('ViewHelper'));

        $passwordregister = new Zend_Form_Element_Password('passwordregister');
        $passwordregister->setRequired(true)
            ->setFilters(array('StringTrim','StripTags','StringToLower'))
            ->setAttribs(array('class'=>'form-control','placeholder'=>'Password'))
            ->setDecorators(array('ViewHelper'));

        $passwordretype = new Zend_Form_Element_Password('passwordretype');
        $passwordretype->setRequired(true)
            ->setFilters(array('StringTrim','StripTags','StringToLower'))
            ->setAttribs(array('class'=>'form-control','placeholder'=>'Password Retype'))
            ->setDecorators(array('ViewHelper'));

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

        $registercsrf = new Zend_Form_Element_Hash('registercsrf');
        $registercsrf->setIgnore(true)
                     ->setDecorators(array('ViewHelper')); // Remove the zend framework default decorators

        $this->addElements(array($usernameregister, $passwordregister, $passwordretype, $registercsrf, $captcha));

        // Add a captcha
        /*$this->addElement('captcha', 'captcha',
            array(
                'required'   => true,
                'placeholder' => 'Please enter the above code',
                'captcha'    => array(
                    'captcha' => 'Image',
                    'font' => $this->font,
                    'fontSize' => '24',
                    'height' => '50',
                    'width' => '200',
                    'imgDir' => APPLICATION_PATH . $this->imageCaptchaDir,
                    'imgUrl' => Zend_Controller_Front::getInstance()->getBaseUrl().$this->imageUrl,
                    'dotNoiseLevel' => 50,
                    'lineNoiseLevel' => 5

            )
        ));

        $this->addElement($submitRegister);*/
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

