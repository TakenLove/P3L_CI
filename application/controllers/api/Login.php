<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Login extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->model('Pegawai_model' , 'pegawai');
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        
    }

    public function index_post()
    {
		$username = $this->post('username');
		$password = $this->post('password');
		
		$pegawai = $this->pegawai->login($username,$password,"OWNER");
		$message = "OWNER";
		if(count($pegawai) < 1){
			$pegawai = $this->pegawai->login($username,$password,"CS");
			$message = "CS";
        }

        if(count($pegawai) < 1){
            $pegawai = $this->pegawai->login($username,$password,"KASIR");
            $message = "KASIR";
        }

		if($pegawai){
            $token = srand(100);
            $this->response([
                'status' => TRUE,
                'token' => $token,
				'message' => $message,
                'data' => $pegawai
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
				'status' => false,
                'message' => 'Gagal Login ! id tidak ditemukan! --HANYA OWNER ATAU CS!--'
            ], REST_Controller::HTTP_BAD_GATEWAY); 
        }
    } 

}