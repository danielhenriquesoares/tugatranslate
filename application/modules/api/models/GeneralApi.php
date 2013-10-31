<?php

/**
 * General class that allows to process a request to the API
 * Typical request would be something like /endpoint/verb/arg0/arg1.....
 *
 * Class Api_Model_GeneralApi
 */
abstract class Api_Model_GeneralApi
{
    /**
     * One of the HTTP methods (GET, POST, DELETE, PUT)
     * @var string
     */
    protected $method = '';

    /**
     * The endpoint to be used
     * @var string
     */
    protected $endpoint = '';

    /**
     * A optional verb to represent a request that is not mapped by one of the tipical HTTP methods
     * @var string
     */
    protected $verb = '';

    /**
     * Optional parameters
     * @var array
     */
    protected $args = array();

    /**
     * Input for PUT request
     * @var null
     */
    protected $file = null;

    /**
     * Allow for CORS (Cross-Origin Resource Sharing)
     * @param array $params
     */
    public function __construct(Zend_Controller_Request_Abstract $request)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        // Change this to also allow xml
        header('Content-Type: application/json');
        $this->args = $this->processRequest($request->getParams());

        // Waiting for a request in the type endpoint/nome_endpoint/verb[optional]/verbo/arg0/valor_arg0/arg1/valor_arg1......

        $this->endpoint = array_shift($this->args);

        if (!empty($this->args) && array_key_exists('verb',$this->args))
        {
            $this->verb = array_shift($this->args);
        }

        $this->method = $_SERVER['REQUEST_METHOD'];

        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD',$_SERVER)){
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE'){
                $this->method = 'DELETE';
            }else if($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT'){
                $this->method = 'PUT';
            }else{
                throw new Exception('Invalid Header supplied');
            }
        }

        /*switch($this->method){
            case 'DELETE':
            case 'POST':
            case 'PUT':
            case 'GET':
            default:
                $this->_response('Invalid Method', 405);

        }*/

    }

    public function processApi($object){

        if (method_exists($object,$this->endpoint)){
            return $this->_response($this->{$this->endpoint}($this->args));
        }

        return $this->_response('', 400);

    }

    protected function processRequest(array $params)
    {
        // Remove module, controller and action
        array_shift($params);
        array_shift($params);
        array_shift($params);

        return $params;
    }

    private function _response($data, $status = 200){
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);

    }

    private function _requestStatus($code)
    {
        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'Ok',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return ($status[$code]) ? $status[$code] : $status[500];
    }
}

