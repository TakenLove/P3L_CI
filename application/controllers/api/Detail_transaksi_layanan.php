<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Detail_transaksi_layanan extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct();
        $this->load->model('Detail_transaksi_layanan_model' , 'detail_transaksi_layanan');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    public function index_get(){
        $id_detail_layanan = $this->get('id_detail_layanan');

        if($id_detail_layanan === null)
        {
            $detail_transaksi_layanan = $this->detail_transaksi_layanan->getDetail_transaksi_layanan();
        } else{
            $detail_transaksi_layanan = $this->detail_transaksi_layanan->getDetail_transaksi_layanan($id_detail_layanan);
        }
        
        if($detail_transaksi_layanan){
            $this->response([
                'status' => TRUE,
                'data' => $detail_transaksi_layanan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function log_get(){
        $id = $this->get('id_detail_layanan');

        if($id === null)
        {
            $detail_transaksi_layanan = $this->detail_transaksi_layanan->getLog();
        } else{
            $detail_transaksi_layanan = $this->detail_transaksi_layanan->getDetail_transaksi_layanan($id);
        }
        
        if($detail_transaksi_layanan){
            $this->response([
                'status' => TRUE,
                'data' => $detail_transaksi_layanan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function delete_post(){
        $id = $this->post('id_detail_layanan');
  
        $query = $this->db->get_where('detail_transaksi_layanan',['id_detail_layanan'=> $id]);
  
        foreach ($query->result() as $row)
        {
            $cek = $row->delete_at;
        }
  
        if($cek === null){
          if($this->detail_transaksi_layanan->hardDelete($id) > 0) {
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
        $id_detail_layanan = $this->delete('id_detail_layanan');

        if($id_detail_layanan === null){
            $this->response([
                'status' => false,
                'message' => 'id detail_transaksi_layanan yang ingin dihapus tidak ditemukan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else{
            if( $this->detail_transaksi_layanan->hardDelete($id_detail_layanan) > 0){
                //OKE
                $this->response([
                    'status' => FALSE,
                    'id_detail_layanan' => $id_detail_layanan,
                    'message' => 'detail_transaksi_layanan sudah terhapus!'
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
            'id_transaksi_layanan' => $this->post('id_transaksi_layanan'),
            'id_layanan' => $this->post('id_layanan'),
            'id_ukuran' => $this->post('id_ukuran'),
            'id_jenis' => $this->post('id_jenis'),
            'sub_harga' => $this->post('sub_harga'),
            'jumlah' => $this->post('jumlah')
        ];

        if($this->detail_transaksi_layanan->createDetail_transaksi_layanan($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'detail_transaksi_layanan sudah terinput!'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal menambahkan detail_transaksi_layanan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function index_put(){

        $id_detail_layanan = $this->put('id_detail_layanan');

        $data = [
            'id_transaksi_layanan' => $this->put('id_transaksi_layanan'),
            'id_layanan' => $this->put('id_layanan'),
            'id_ukuran' => $this->put('id_ukuran'),
            'id_jenis' => $this->put('id_jenis'),
            'sub_harga' => $this->put('sub_harga'),
            'jumlah' => $this->put('jumlah')
        ];

        if($this->detail_transaksi_layanan->updateDetail_transaksi_layanan($data,$id_detail_layanan) > 0){
            $this->response([
                'status' => true,
                'message' => 'detail_transaksi_layanan sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update detail_transaksi_layanan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }
}