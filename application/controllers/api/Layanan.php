<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Layanan extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->model('Layanan_model' , 'layanan');
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        
    }

    public function index_get(){
        $id_layanan = $this->get('id_layanan');

        if($id_layanan === null)
        {
            $layanan = $this->layanan->getLayanan();
        } else{
            $layanan = $this->layanan->getLayanan($id_layanan);
        }
        
        if($layanan){
            $this->response([
                'status' => TRUE,
                'data' => $layanan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function log_get(){
        $id = $this->get('id_layanan');

        if($id === null)
        {
            $layanan = $this->layanan->getLog();
        } else{
            $layanan = $this->layanan->getLayanan($id);
        }
        
        if($layanan){
            $this->response([
                'status' => TRUE,
                'data' => $layanan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function delete_post(){
        $id = $this->post('id_layanan');
        $data = [
          'delete_at' => date('Y-m-d H:i:s'),
          'aktor' => $this->post('aktor')
        ];
  
        $query = $this->db->get_where('layanan',['id_layanan'=> $id]);
  
      foreach ($query->result() as $row)
      {
          $cek = $row->delete_at;
      }
  
        if($cek === null){
          if($this->layanan->deleteLayanan($data, $id) > 0) {
              $this->response([
                'status' => true,
                'id' => $id,
                'message' => 'berhasil soft delete :)'
              ],  REST_Controller::HTTP_OK);
            } else {
              $this->response([
                'status' => false,
                'message' => 'gagal soft delete'
              ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
          $this->response([
              'status' => false,
              'message' => 'data sudah di soft delete sebelumnya'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
  
      }

    public function index_delete(){
        $id_layanan = $this->delete('id_layanan');

        if($id_layanan === null){
            $this->response([
                'status' => false,
                'message' => 'id layanan yang ingin dihapus tidak ditemukan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else{
            if( $this->layanan->hardDelete($id_layanan) > 0){
                //OKE
                $this->response([
                    'status' => FALSE,
                    'id_layanan' => $id_layanan,
                    'message' => 'layanan sudah terhapus!'
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
            'nama' => $this->post('nama'),
            'harga' => $this->post('harga'),
            'aktor' => $this->post('aktor'),
            'update_at' => null,
            'delete_at' => null
        ];

        if($this->layanan->createLayanan($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'layanan sudah terinput!'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal menambahkan layanan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function index_put(){

        $id_layanan = $this->put('id_layanan');

        $data = [
            'nama' => $this->put('nama'),
            'harga' => $this->put('harga'),
            'aktor' => $this->put('aktor'),
            'update_at' => date('Y-m-d H:i:s'),
            'delete_at' => null
        ];

        if($this->layanan->updateLayanan($data,$id_layanan) > 0){
            $this->response([
                'status' => true,
                'message' => 'layanan sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update layanan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }
}