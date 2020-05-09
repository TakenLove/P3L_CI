<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Transaksi_produk extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct();
        $this->load->model('Transaksi_produk_model' , 'transaksi_produk');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    public function index_get(){
        $id_transaksi_produk = $this->get('id_transaksi_produk');

        if($id_transaksi_produk === null)
        {
            $transaksi_produk = $this->transaksi_produk->getTransaksi_produk();
        } else{
            $transaksi_produk = $this->transaksi_produk->getTransaksi_produk($id_transaksi_produk);
        }
        
        if($transaksi_produk){
            $this->response([
                'status' => TRUE,
                'data' => $transaksi_produk
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function log_get(){
        $id = $this->get('id_transaksi_produk');

        if($id === null)
        {
            $transaksi_produk = $this->transaksi_produk->getLog();
        } else{
            $transaksi_produk = $this->transaksi_produk->getTransaksi_produk($id);
        }
        
        if($transaksi_produk){
            $this->response([
                'status' => TRUE,
                'data' => $transaksi_produk
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function id_get(){
        $id = $this->get('id_transaksi_produk');

        if($id === null)
        {
            $transaksi_produk = $this->transaksi_produk->getID();
        } else{
            $transaksi_produk = $this->transaksi_produk->getTransaksi_produk($id);
        }
        
        if($transaksi_produk){
            $this->response([
                'status' => TRUE,
                'data' => $transaksi_produk
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function delete_post(){
        $id = $this->post('id_transaksi_produk');
        $data = [
          'delete_at' => date('Y-m-d H:i:s'),
          'aktor' => $this->post('aktor')
        ];
  
        $query = $this->db->get_where('transaksi_produk',['id_transaksi_produk'=> $id]);
  
      foreach ($query->result() as $row)
      {
          $cek = $row->delete_at;
      }
  
        if($cek === null){
          if($this->transaksi_produk->hardDelete($id) > 0) {
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
        $id_transaksi_produk = $this->delete('id_transaksi_produk');

        if($id_transaksi_produk === null){
            $this->response([
                'status' => false,
                'message' => 'id transaksi_produk yang ingin dihapus tidak ditemukan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else{
            if( $this->transaksi_produk->hardDelete($id_transaksi_produk) > 0){
                //OKE
                $this->response([
                    'status' => FALSE,
                    'id_transaksi_produk' => $id_transaksi_produk,
                    'message' => 'transaksi_produk sudah terhapus!'
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
        $toNumbID = $this->db->count_all('transaksi_produk');
        $count = str_pad($toNumbID+1,2,0, STR_PAD_LEFT);
        $id = "PR"."-";
        $d = date('d');
        $mnth = date("m");
        $yrs = date("y")."-";
        $id_transaksi_produk = $id.$d.$mnth.$yrs.$count;
        $data = [
            'id_transaksi_produk' => $id_transaksi_produk,
            'id_member' => 0,
            'total_harga' => 0,
            'diskon' => 0,
            'sub_total' => 0,
            'id_pegawai_cs' => 0,
            'id_pegawai_kasir' => 0,
            'update_at' => null,
            'delete_at' => null,
            'aktor' => $this->post('aktor')
        ];

        if($this->transaksi_produk->createTransaksi_produk($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'transaksi_produk sudah terinput!'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal menambahkan transaksi_produk!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function index_put(){

        $id_transaksi_produk = $this->put('id_transaksi_produk');
        
        $data = [
            'id_member' => $this->put('id_member'),
            'sub_total' => $this->put('sub_total'),
            'id_pegawai_cs' => $this->put('id_pegawai_cs')
        ];

        if($this->transaksi_produk->updateTransaksi_produk($data,$id_transaksi_produk) > 0){
            $this->response([
                'status' => true,
                'message' => 'transaksi_produk sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update transaksi_produk!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }

    public function pesan_put(){

        $id_transaksi_produk = $this->put('id_transaksi_produk');

        $data = [
            'sub_total' => $this->put('sub_total'),
            'id_pegawai_cs' => $this->put('id_pegawai_cs')
        ];

        if($this->transaksi_produk->updateTransaksi_produk($data,$id_transaksi_produk) > 0){
            $this->response([
                'status' => true,
                'message' => 'transaksi_produk sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update transaksi_produk!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }
}