<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Detail_pengadaan_produk extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct();
        $this->load->model('Detail_pengadaan_produk_model' , 'detail_pengadaan_produk');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    public function index_get(){
        $id_detail_produk = $this->get('id_detail_produk');

        if($id_detail_produk === null)
        {
            $detail_pengadaan_produk = $this->detail_pengadaan_produk->getDetail_pengadaan_produk();
        } else{
            $detail_pengadaan_produk = $this->detail_pengadaan_produk->getDetail_pengadaan_produk($id_detail_produk);
        }
        
        if($detail_pengadaan_produk){
            $this->response([
                'status' => TRUE,
                'data' => $detail_pengadaan_produk
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function log_get(){
        $id = $this->get('id_detail_produk');

        if($id === null)
        {
            $detail_pengadaan_produk = $this->detail_pengadaan_produk->getLog();
        } else{
            $detail_pengadaan_produk = $this->detail_pengadaan_produk->getDetail_pengadaan_produk($id);
        }
        
        if($detail_pengadaan_produk){
            $this->response([
                'status' => TRUE,
                'data' => $detail_pengadaan_produk
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function delete_post(){
        $id = $this->post('id_detail_produk');
        $data = [
          'delete_at' => date('Y-m-d H:i:s')
        ];
  
        $query = $this->db->get_where('detail_pengadaan_produk',['id_detail_produk'=> $id]);
  
        foreach ($query->result() as $row)
        {
            $cek = $row->delete_at;
        }
  
        if($cek === null){
          if($this->detail_pengadaan_produk->hardDelete($id) > 0) {
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
        $id_detail_produk = $this->delete('id_detail_produk');

        if($id_detail_produk === null){
            $this->response([
                'status' => false,
                'message' => 'id detail_pengadaan_produk yang ingin dihapus tidak ditemukan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else{
            if( $this->detail_pengadaan_produk->hardDelete($id_detail_produk) > 0){
                //OKE
                $this->response([
                    'status' => FALSE,
                    'id_detail_produk' => $id_detail_produk,
                    'message' => 'detail_pengadaan_produk sudah terhapus!'
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
            'id_pengadaan' => $this->post('id_pengadaan'),
            'id_produk' => $this->post('id_produk'),
            'jumlah' => $this->post('jumlah')
        ];

        if($this->detail_pengadaan_produk->createDetail_pengadaan_produk($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'detail_pengadaan_produk sudah terinput!'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal menambahkan detail_pengadaan_produk!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function index_put(){

        $id_detail_produk = $this->put('id_detail_produk');

        $data = [
            'id_pengadaan' => $this->put('id_pengadaan'),
            'id_produk' => $this->put('id_produk'),
            'jumlah' => $this->put('jumlah'),
            'delete_at' => null
        ];

        if($this->detail_pengadaan_produk->updateDetail_pengadaan_produk($data,$id_detail_produk) > 0){
            $this->response([
                'status' => true,
                'message' => 'detail_pengadaan_produk sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update detail_pengadaan_produk!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }
}