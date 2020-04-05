<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Jenis_hewan extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->model('Jenis_hewan_model' , 'jenis_hewan');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        
    }

    public function index_get(){
        $id_jenis = $this->get('id_jenis');

        if($id_jenis === null)
        {
            $jenis_hewan = $this->jenis_hewan->getJenis_hewan();
        } else{
            $jenis_hewan = $this->jenis_hewan->getJenis_hewan($id_jenis);
        }
        
        if($jenis_hewan){
            $this->response([
                'status' => TRUE,
                'data' => $jenis_hewan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function log_get(){
        $id_jenis = $this->get('id_jenis');

        if($id_jenis === null)
        {
            $jenis_hewan = $this->jenis_hewan->getLogJenis_hewan();
        } else{
            $jenis_hewan = $this->jenis_hewan->getJenis_hewan($id_jenis);
        }
        
        if($jenis_hewan){
            $this->response([
                'status' => TRUE,
                'data' => $jenis_hewan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function delete_post(){
        $id = $this->post('id_jenis');
        $data = [
          'delete_at' => date('Y-m-d H:i:s')
        ];
  
        $query = $this->db->get_where('jenis_hewan',['id_jenis'=> $id]);
  
      foreach ($query->result() as $row)
      {
          $cek = $row->delete_at;
      }
  
        if($cek === null){
          if($this->jenis_hewan->deleteJenis_hewan($data, $id) > 0) {
              $this->response([
                'status' => true,
                'id' => $id,
                'message' => 'berhasil soft delete :)'
              ],  REST_Controller::HTTP_OK);
            } else {
              $this->response([
                'status' => false,
                'message' => 'deleted'
              ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
          $this->response([
              'status' => false,
              'message' => 'deleted'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
  
      }

    public function index_delete(){
        $id_jenis = $this->delete('id_jenis');

        if($id_jenis === null){
            $this->response([
                'status' => false,
                'message' => 'id ukuran hewan yang ingin dihapus tidak ditemukan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else{
            if( $this->jenis_hewan->deleteJenis_hewan($id_jenis) > 0){
                //OKE
                $this->response([
                    'status' => FALSE,
                    'id_jenis' => $id_jenis,
                    'message' => 'jenis_hewan sudah terhapus!'
                ], REST_Controller::HTTP_OK); 
            } else{
                $this->response([
                    'status' => false,  
                    'message' => 'id tidak ditemukan!'
                ], REST_Controller::HTTP_NOT_FOUND); 
            }
        }
    }

    public function index_post(){
        $data = [
            'jenis' => $this->post('jenis'),
            'harga' => $this->post('harga')
        ];

        if($this->jenis_hewan->createJenis_hewan($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'ukuran hewan sudah terinput!'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal menambahkan ukuran hewan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function index_put(){

        $id_jenis = $this->put('id_jenis');

        $data = [
            'jenis' => $this->put('jenis'),
            'harga' => $this->put('harga')
        ];

        if($this->jenis_hewan->updateJenis_hewan($data,$id_jenis) > 0){
            $this->response([
                'status' => true,
                'message' => 'jenis_hewan sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update jenis_hewan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }
}