<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';

class User_Api extends API_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function simple_api()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig([
            'methods' => ['POST', 'GET'], // Request Execute Only POST and GET Method
        ]);
    }


    public function api_limit()
    {
      

        $this->_APIConfig([
            'methods' => ['POST'],

            'limit' => [15, 'ip', 'everyday'] 
        ]);
    }

  
    public function api_key()
    {
  

        $this->_APIConfig([
            'methods' => ['POST'],
            'key' => ['header'],

            'data' => [
                'is_login' => false,
            ],
        ]);

        // Data
        $data = array(
            'status' => 'OK',
            'data' => [
                'user_id' => 12,
            ]
        );

    
        if (!empty($data)) {

            $this->api_return($data, '200');
        } else {
            
            $this->api_return(['statu' => false, 'error' => 'Invalid Data'], '404');
        }
    }


    public function login()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig([
            'methods' => ['POST'],
        ]);

        $payload = [
            'npm' => "1731075",
            'nama' => "Jimmy Chandra"
        ];

        $this->load->library('authorization_token');

        $token = $this->authorization_token->generateToken($payload);

        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'token' => $token,
                ],
                
            ],
        200);
    }

    public function view()
    {
        header("Access-Control-Allow-Origin: *");
        
        // API Configuration [Return Array: User Token Data]
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);
        
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'user_data' => $user_data['token_data']
                ],
            ],
        200);
    }
}