<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Reverse_data extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->model('Reverse_data_model' , 'produk');
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    

    public function index_get(){
        $id_produk = $this->get('id_produk');

        if($id_produk === null)
        {
            $produk = $this->produk->getProduk();
        } else{
            $produk = $this->produk->getProduk($id_produk);
        }
        
        if($produk){
            $this->response([
                'status' => TRUE,
                'data' => $produk
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function log_get(){
        $id_produk = $this->get('id_produk');

        if($id_produk === null)
        {
            $produk = $this->produk->getLogProduk();
        } else{
            $produk = $this->produk->getProduk($id_produk);
        }
        
        if($produk){
            $this->response([
                'status' => TRUE,
                'data' => $produk
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ditemukan!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }
    
    public function delete_post(){
      $id = $this->post('id_produk');
      $data = [
        'delete_at' => date('Y-m-d H:i:s'),
        'aktor' => $this->post('aktor'),
      ];

      $query = $this->db->get_where('produk',['id_produk'=> $id]);

    foreach ($query->result() as $row)
    {
        $cek = $row->delete_at;
    }

      if($cek === null){
        if($this->produk->deleteProduk($data, $id) > 0) {
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
        $id = $this->delete('id_produk');
        $data = [
            'foto' => $this->_deleteImage($id)
        ];

        if($id === null){
            $this->response([
                'status' => false,
                'message' => 'id produk yang ingin dihapus tidak ditemukan!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else{
            if( $this->produk->hardDelete($id) > 0){
                //OKE
                $this->response([
                    'status' => true,
                    'id_produk' => $id,
                    'message' => 'produk sudah terhapus!'
                ], REST_Controller::HTTP_OK); 
            } else{
                $this->response([
                    'status' => true,  
                    'message' => 'id tidak ditemukan!'
                ], REST_Controller::HTTP_NOT_FOUND); 
            }
        }
    }

    public function index_post(){
        $data = [
            'nama' => $this->post('nama'),
            'unit' => $this->post('unit'),
            'stok' => $this->post('stok'),
            'min_stok' => $this->post('min_stok'),
            'harga' => $this->post('harga'),
            'aktor' => $this->post('aktor'),
            'update_at' => null,
            'delete_at' => null
        ];

        if($this->produk->createProduk($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'produk sudah terinput!'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal menambahkan produk!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function index_put(){

        $id_produk = $this->put('id_produk');

        $data = [
            'stok' => $this->put('stok'),
            'delete_at' => null
        ];

        if($this->produk->updateProduk($data,$id_produk) > 0){
            $this->response([
                'status' => true,
                'message' => 'produk sudah terupdate!'
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,  
                'message' => 'Gagal update produk!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }

    public function foto_post(){
        $id_produk = $this->post('id_produk');
        $data = [
            'foto' => $this->image_upload($id_produk)
        ];
  
        $query = $this->db->get_where('produk',['id_produk'=> $id_produk]);
        
        $cek = 'default.jpg';
        foreach ($query->result() as $row)
        {
            $cek = $row->foto;
        }
  
        if($cek != null){
            if($this->produk->fotoProduk($data,$id_produk) > 0){
                $this->response([
                    'status' => true,
                    'message' => 'foto sudah terupdate!'
                ], REST_Controller::HTTP_OK); 
            }else {
                $this->response([
                    'status' => true,
                    'message' => 'foto sudah ditambahkan!'
                ], REST_Controller::HTTP_OK); 
            }
        }else{
          $this->response([
              'status' => false,
              'message' => 'Foto null!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
  
      }

    private function image_upload($id)
	{
        $config['file_name']            = $id;
		$config['upload_path']          = './upload/produk/';
        $config['allowed_types']        = 'gif|jpg|png|JPG|PNG|jpeg';
        $config['encrypt_name']			= FALSE;
        $config['overwrite']			= TRUE;

		$this->load->library('upload', $config);
        
        $this->db->get_where('produk',['id_produk'=> $id]);
        //hapus foto default 
        $data = [
            'foto' => $this->_deleteImage($id)
        ];
        //KASIH FOTO BARU (UPDATE)
		if ($this->upload->do_upload("foto")) {
            $data = array('upload_data' => $this->upload->data());
			return $data['upload_data']['file_name']; 
        }
        else{
            return 'default.jpg';
        }
		print_r($this->upload->display_errors());
    }

    private function _deleteImage($id)
    {
        $query = $this->db->get_where('produk',['id_produk'=> $id]);

        $cek = 'default.jpg';
        foreach ($query->result() as $row)
        {
            $cek = $row->foto;
        }
        if($cek != "default.jpg"){
            $filename = explode(".", $cek)[0];
            return array_map('unlink', glob(FCPATH."upload/produk/$filename.*"));
        }
    }
}