<?php

class Detail_pengadaan_produk_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id_detail_produk = null){
        if($id_detail_produk === null){
            return $this->db->get('detail_pengadaan_produk')->result_array();
        } else{
            return $this->db->get_where('detail_pengadaan_produk', ['id_detail_produk' => $id_detail_produk]) ->result_array();
        }
    }

    //tidak menampilkan yang ter soft delete    
    public function getDetail_pengadaan_produk($id_detail_produk = null){
        if($id_detail_produk === null){
            return $this->db->query("SELECT dpe.id_detail_produk, dpe.id_pengadaan, dpe.id_produk, p.nama as nama, dpe.jumlah, dpe.sub_harga from detail_pengadaan_produk dpe JOIN produk p ON (dpe.id_produk = p.id_produk)")->result_array();
        } else{
            return $this->db->query("SELECT dpe.id_detail_produk, dpe.id_pengadaan, dpe.id_produk, p.nama as nama, dpe.jumlah, p.unit as unit from detail_pengadaan_produk dpe JOIN produk p ON (dpe.id_produk = p.id_produk) where dpe.id_pengadaan='$id'")->result_array();
        }
        
    }

    public function getDetail_pengadaan_struck($id_pengadaan){
        return $this->db->query("SELECT dpe.id_detail_produk, dpe.id_pengadaan, dpe.id_produk, p.nama as nama, dpe.jumlah, p.unit as unit from detail_pengadaan_produk dpe JOIN produk p ON (dpe.id_produk = p.id_produk) where dpe.id_pengadaan='$id_pengadaan'")->result_array();
    }

    public function deleteDetail_pengadaan_produk($data,$id_detail_produk){
        $this->db->update('detail_pengadaan_produk' , $data , ['id_detail_produk' => $id_detail_produk]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_detail_produk){
        $this->db->delete('detail_pengadaan_produk' , ['id_detail_produk' => $id_detail_produk]);
        return $this->db->affected_rows();
    }

    public function createDetail_pengadaan_produk($data){
        $this->db->insert('detail_pengadaan_produk', $data);
        return $this->db->affected_rows();
    }

    public function updateDetail_pengadaan_produk($data,$id_detail_produk){
        $this->db->update('detail_pengadaan_produk' , $data , ['id_detail_produk' => $id_detail_produk]);
        return $this->db->affected_rows();
    }
}