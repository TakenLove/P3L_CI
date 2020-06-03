<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller.php';

class Laporan extends REST_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct();
        $this->load->model('Laporan_model' , 'laporan');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }
//===================================================================
    public function LayananTerlaris_get(){
        $tahun = $this->get('tahun');

        $laporan = $this->laporan->getLaporanJasaLayananTerlarisTahun($tahun);
        
        if($laporan){
            $this->response([
                'status' => TRUE,
                'data' => $laporan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'tahun!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }
//===================================================================
    public function ProdukTerlaris_get(){
        $tahun = $this->get('tahun');

        $laporan = $this->laporan->getLaporanProdukTerlaris($tahun);
        
        if($laporan){
            $this->response([
                'status' => TRUE,
                'data' => $laporan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'tahun!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }
//===================================================================
    public function PendapatanLayananTahun_get(){
        $tahun = $this->get('tahun');

        $laporan = $this->laporan->getLaporanPendapatanLayananTahun($tahun);
        
        if($laporan){
            $this->response([
                'status' => TRUE,
                'data' => $laporan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'tahun!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function PendapatanProdukTahun_get(){
        $tahun = $this->get('tahun');

        $laporan = $this->laporan->getLaporanPendapatanProdukTahun($tahun);
        
        if($laporan){
            $this->response([
                'status' => TRUE,
                'data' => $laporan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'tahun!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }
//===================================================================
    public function PendapatanLayananBulan_get(){
        $tahun = $this->get('tahun');
        $bulan = $this->get('bulan');

        $laporan = $this->laporan->getLaporanPendapatanLayananBulan($tahun,$bulan);
        
        if($laporan){
            $this->response([
                'status' => TRUE,
                'data' => $laporan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'tahun!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function PendapatanProdukBulan_get(){

        $tahun = $this->get('tahun');
        $bulan = $this->get('bulan');

        $laporan = $this->laporan->getLaporanPendapatanProdukBulan($tahun,$bulan);
        if($laporan){
            $this->response([
                'status' => TRUE,
                'data' => $laporan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'tahun!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

//===================================================================
    public function PengadaanProdukTahun_get(){

        $tahun = $this->get('tahun');

        $laporan = $this->laporan->getLaporanPengadaanProdukTahun($tahun);
        if($laporan){
            $this->response([
                'status' => TRUE,
                'data' => $laporan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'tahun!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

//===================================================================
    public function PengadaanProdukBulan_get(){

        $tahun = $this->get('tahun');
        $bulan = $this->get('bulan');

        $laporan = $this->laporan->getLaporanPengadaanProdukBulan($tahun,$bulan);
        if($laporan){
            $this->response([
                'status' => TRUE,
                'data' => $laporan
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'tahun!'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

}
