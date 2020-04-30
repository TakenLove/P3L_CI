<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Transaksi_layanan extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct();
        $this->load->model('Transaksi_layanan_model' , 'transaksi_layanan');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    public function index_get(){
        $id_transaksi_layanan = $this->get('id_transaksi_layanan');

        if($id_transaksi_layanan === null)
        {
            $transaksi_layanan = $this->transaksi_layanan->getTransaksi_layanan();
        } else{
            $transaksi_layanan = $this->transaksi_layanan->getTransaksi_layanan($id_transaksi_layanan);
        }
        
        if($transaksi_layanan){
            $this->response([
                'status' => TRUE,
                'data' => $transaksi_layanan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function log_get(){
        $id = $this->get('id_transaksi_layanan');

        if($id === null)
        {
            $transaksi_layanan = $this->transaksi_layanan->getLog();
        } else{
            $transaksi_layanan = $this->transaksi_layanan->getTransaksi_layanan($id);
        }
        
        if($transaksi_layanan){
            $this->response([
                'status' => TRUE,
                'data' => $transaksi_layanan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function delete_post(){
        $id = $this->post('id_transaksi_layanan');
        $data = [
          'delete_at' => date('Y-m-d H:i:s')
        ];
  
        $query = $this->db->get_where('transaksi_layanan',['id_transaksi_layanan'=> $id]);
  
        foreach ($query->result() as $row)
        {
            $cek = $row->delete_at;
        }
  
        if($cek === null){
          if($this->transaksi_layanan->hardDelete($id) > 0) {
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
        $id_transaksi_layanan = $this->delete('id_transaksi_layanan');

        if($id_transaksi_layanan === null){
            $this->response([
                'status' => false,
                'message' => 'id transaksi_layanan yang ingin dihapus tidak ditemukan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else{
            if( $this->transaksi_layanan->hardDelete($id_transaksi_layanan) > 0){
                //OKE
                $this->response([
                    'status' => FALSE,
                    'id_transaksi_layanan' => $id_transaksi_layanan,
                    'message' => 'transaksi_layanan sudah terhapus!'
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
            'id_member' => $this->post('id_member'),
            'id_hewan' => $this->post('id_hewan'),
            'diskon' => 0,
            'total_harga' => 0,
            'sub_total' => null,
            'status_layanan' => $this->post('status_layanan'),
            'status_pembayaran' => $this->post('status_pembayaran'),
            'tgl_selesai' => null,
            'id_pegawai_cs' => 0,
            'id_pegawai_kasir' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'delete_at' => null,
            'aktor' => $this->post('aktor'),
        ];

        if($this->transaksi_layanan->createTransaksi_layanan($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'transaksi_layanan sudah terinput!'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal menambahkan transaksi_layanan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function index_put(){

        $id_transaksi_layanan = $this->put('id_transaksi_layanan');

        $data = [
            'id_member' => $this->put('id_member'),
            'diskon' => 0,
            'total_harga' => 0,
            'sub_total' => $this->put('sub_total'),
            'id_pegawai_cs' => $this->put('id_pegawai_cs')
        ];

        if($this->transaksi_layanan->updateTransaksi_layanan($data,$id_transaksi_layanan) > 0){
            $this->response([
                'status' => true,
                'message' => 'transaksi_layanan sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update transaksi_layanan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }

    public function service_put(){

        $id_transaksi_layanan = $this->put('id_transaksi_layanan');

        $data = [
            'status_layanan' => $this->put('status_layanan')
        ];

        if($this->transaksi_layanan->updateTransaksi_layanan($data,$id_transaksi_layanan) > 0){
            $this->response([
                'status' => true,
                'message' => 'transaksi layanan sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update transaksi layanan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }

    public function pesan_put(){

        $id_transaksi_layanan = $this->put('id_transaksi_layanan');

        $data = [
            'sub_total' => $this->put('sub_total'),
            'id_pegawai_cs' => $this->put('id_pegawai_cs')
        ];

        if($this->transaksi_produk->updateTransaksi_layanan($data,$id_transaksi_layanan) > 0){
            $this->response([
                'status' => true,
                'message' => 'transaksi layanan sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update transaksi layanan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }
}