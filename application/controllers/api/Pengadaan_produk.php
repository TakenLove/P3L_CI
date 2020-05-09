<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Pengadaan_produk extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct();
        $this->load->model('Pengadaan_produk_model' , 'pengadaan_produk');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    public function index_get(){
        $id_pengadaan = $this->get('id_pengadaan');

        if($id_pengadaan === null)
        {
            $pengadaan_produk = $this->pengadaan_produk->getPengadaan_produk();
        } else{
            $pengadaan_produk = $this->pengadaan_produk->getPengadaan_produk($id_pengadaan);
        }
        
        if($pengadaan_produk){
            $this->response([
                'status' => TRUE,
                'data' => $pengadaan_produk
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function log_get(){
        $id = $this->get('id_pengadaan');

        if($id === null)
        {
            $pengadaan_produk = $this->pengadaan_produk->getLog();
        } else{
            $pengadaan_produk = $this->pengadaan_produk->getPengadaan_produk($id);
        }
        
        if($pengadaan_produk){
            $this->response([
                'status' => TRUE,
                'data' => $pengadaan_produk
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function destroy_post(){
        $id = $this->post('id_pengadaan');
        $data = [
          'delete_at' => date('Y-m-d H:i:s')
        ];
  
        $query = $this->db->get_where('pengadaan_produk',['id_pengadaan'=> $id]);

        foreach ($query->result() as $row)
        {
            $cek = $row->delete_at;
        }
  
        if($cek === null){
          if($this->pengadaan_produk->hardDelete($id) > 0) {
              $this->response([
                'status' => true,
                'id' => $id,
                'message' => 'berhasil soft delete :)'
              ],  REST_Controller::HTTP_OK);
            } else {
              $this->response([
                'status' => false,
                'message' => 'ga ketemu'
              ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
          $this->response([
              'status' => false,
              'message' => 'ga kena'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
      }

    public function delete_post(){
        $id = $this->post('id_pengadaan');
        $data = [
          'delete_at' => date('Y-m-d H:i:s')
        ];
  
        $query = $this->db->get_where('pengadaan_produk',['id_pengadaan'=> $id]);

        foreach ($query->result() as $row)
        {
            $cek = $row->delete_at;
        }
  
        if($cek === null){
          if($this->pengadaan_produk->deletePengadaan_produk($data, $id) > 0) {
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
        $id_pengadaan = $this->delete('id_pengadaan');

        if($id_pengadaan === null){
            $this->response([
                'status' => false,
                'message' => 'id pengadaan_produk yang ingin dihapus tidak ditemukan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else{
            if( $this->pengadaan_produk->hardDelete($id_pengadaan) > 0){
                //OKE
                $this->response([
                    'status' => FALSE,
                    'id_pengadaan' => $id_pengadaan,
                    'message' => 'pengadaan_produk sudah terhapus!'
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
        $toNumbID = $this->db->count_all('pengadaan_produk');
        $count = str_pad($toNumbID+1,2,0, STR_PAD_LEFT);
        $id = "PO"."-";
        $d = date('d');
        $mnth = date("m");
        $yrs = date("y")."-";
        $id_pengadaan = $id.$d.$mnth.$yrs.$count;

        $data = [
            'id_pengadaan' => $id_pengadaan,
            'status' => 'belum selesai',
            'id_supplier' => 4,
            'delete_at' => null,
            'update_at' => null,
            'printed_at' => null,
            'pengeluaran' => 0
        ];

        if($this->pengadaan_produk->createPengadaan_produk($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'pengadaan_produk sudah terinput!'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal menambahkan pengadaan_produk!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function index_put(){

        $id_pengadaan = $this->put('id_pengadaan');

        $data = [
            'id_supplier' => $this->put('id_supplier'),
            'pengeluaran' => $this->put('pengeluaran'),
            'update_at' => date('Y-m-d H:i:s'),
            'delete_at' => null
        ];

        if($this->pengadaan_produk->updatePengadaan_produk($data,$id_pengadaan) > 0){
            $this->response([
                'status' => true,
                'message' => 'pengadaan_produk sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update pengadaan_produk!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function status_put(){
        
        $id_pengadaan = $this->put('id_pengadaan');

        $data = [
            'status' => 'selesai',
            'update_at' => date('Y-m-d H:i:s'),
            'delete_at' => null,
            'printed_at' => null
        ];

        if($this->pengadaan_produk->updatePengadaan_produk($data, $id_pengadaan) > 0){
            $this->response([
                'status' => true,
                'message' => 'status sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update status!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function print_put(){
        
        $id_pengadaan = $this->put('id_pengadaan');

        $data = [
            'delete_at' => null,
            'printed_at' => date('Y-m-d')
        ];

        if($this->pengadaan_produk->updatePengadaan_produk($data, $id_pengadaan) > 0){
            $this->response([
                'status' => true,
                'message' => 'status sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update status!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }
}