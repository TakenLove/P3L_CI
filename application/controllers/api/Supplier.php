<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Supplier extends REST_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('Supplier_model' , 'supplier');
    }

    public function index_get(){
        $id_supplier = $this->get('id_supplier');

        if($id_supplier === null)
        {
            $supplier = $this->supplier->getSupplier();
        } else{
            $supplier = $this->supplier->getSupplier($id_supplier);
        }
        
        if($supplier){
            $this->response([
                'status' => TRUE,
                'data' => $supplier
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }
    public function log_get(){
        $id = $this->get('id_supplier');

        if($id === null)
        {
            $supplier = $this->supplier->getLog();
        } else{
            $supplier = $this->supplier->getSupplier($id);
        }
        
        if($supplier){
            $this->response([
                'status' => TRUE,
                'data' => $supplier
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function delete_post(){
        $id = $this->post('id_supplier');
        $data = [
          'delete_at' => date('Y-m-d H:i:s')
        ];
  
        $query = $this->db->get_where('supplier',['id_supplier'=> $id]);
  
      foreach ($query->result() as $row)
      {
          $cek = $row->delete_at;
      }
  
        if($cek === null){
          if($this->supplier->deleteSupplier($data, $id) > 0) {
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
        $id_supplier = $this->delete('id_supplier');

        if($id_supplier === null){
            $this->response([
                'status' => false,
                'message' => 'id supplier yang ingin dihapus tidak ditemukan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else{
            if( $this->supplier->hardDelete($id_supplier) > 0){
                //OKE
                $this->response([
                    'status' => FALSE,
                    'id_supplier' => $id_supplier,
                    'message' => 'supplier sudah terhapus!'
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
            'no_telp' => $this->post('no_telp'),
            'alamat' => $this->post('alamat')
        ];

        if($this->supplier->createSupplier($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'supplier sudah terinput!'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal menambahkan supplier!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function index_put(){

        $id_supplier = $this->put('id_supplier');

        $data = [
            'nama' => $this->put('nama'),
            'no_telp' => $this->put('no_telp'),
            'alamat' => $this->put('alamat')
        ];

        if($this->supplier->updateSupplier($data,$id_supplier) > 0){
            $this->response([
                'status' => true,
                'message' => 'supplier sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update supplier!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }
}