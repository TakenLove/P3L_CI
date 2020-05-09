<?php

class Pengadaan_produk_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id_pengadaan = null){
        if($id_pengadaan === null){
            return $this->db->query("SELECT pp.id_pengadaan, pp.status, pp.id_supplier, s.nama as nama, pp.pengeluaran, pp.created_at, pp.update_at, pp.delete_at, pp.printed_at from pengadaan_produk pp JOIN supplier s ON (pp.id_supplier = s.id_supplier)")->result_array();
        } else{
            return $this->db->get_where('pengadaan_produk', ['id_pengadaan' => $id_pengadaan]) ->result_array();
        }
    }

    //tidak menampilkan yang ter soft delete 
    public function getPengadaan_produk($id_pengadaan = null){
        if($id_pengadaan === null){
            return $this->db->query("SELECT pp.id_pengadaan, pp.status, pp.id_supplier, s.nama as nama, pp.pengeluaran, pp.created_at, pp.update_at, pp.delete_at, pp.printed_at from pengadaan_produk pp JOIN supplier s ON (pp.id_supplier = s.id_supplier) where pp.delete_at IS NULL AND pp.printed_at IS NULL")->result_array();
        } else{
            return $this->db->get_where('pengadaan_produk', ['id_pengadaan' => $id_pengadaan]) ->result_array();
        }
    }

    public function deletePengadaan_produk($data,$id_pengadaan){
        $this->db->update('pengadaan_produk' , $data , ['id_pengadaan' => $id_pengadaan]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_pengadaan){
        $this->db->delete('pengadaan_produk' , ['id_pengadaan' => $id_pengadaan]);
        return $this->db->affected_rows();
    }

    public function createPengadaan_produk($data){
        $this->db->insert('pengadaan_produk', $data);
        return $this->db->affected_rows();
    }

    public function updatePengadaan_produk($data,$id_pengadaan){
        $this->db->update('pengadaan_produk' , $data , ['id_pengadaan' => $id_pengadaan]);
        return $this->db->affected_rows();
    }
}