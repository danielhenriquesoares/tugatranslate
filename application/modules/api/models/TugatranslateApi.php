<?php

class Api_Model_TugatranslateApi extends Api_Model_GeneralApi
{
    public function __construct(Zend_Controller_Request_Abstract $request)
    {
        parent::__construct($request);
    }

    public function getTestData(array $cenas)
    {
        $test = array(
            'nome' => 'Daniel',
            'idade' => 32,
            'morada' => 'Felgueiras'
        );

        return $test;
    }
}

