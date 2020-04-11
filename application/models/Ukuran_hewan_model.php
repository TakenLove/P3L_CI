<?php

class Ukuran_hewan_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id = null){
        if($id === null){
            return $this->db->query("SELECT u.id_ukuran ,u.ukuran ,u.harga, u.created_at, u.update_at, u.delete_at, p.nama as aktor
            from ukuran_hewan u JOIN pegawai p ON (u.aktor = p.id_pegawai)")->result_array();
        } else{
            return $this->db->get_where('ukuran_hewan', ['id_ukuran' => $id]) ->result_array();
        }
        
    }

    //tidak menampilkan yang ter soft delete    
    public function getUkuran_hewan($id_ukuran = null){
        if($id_ukuran === null){
            return $this->db->query("SELECT u.id_ukuran ,u.ukuran ,u.harga, u.created_at, u.update_at, u.delete_at, p.nama as aktor
            from ukuran_hewan u JOIN pegawai p ON (u.aktor = p.id_pegawai) where u.delete_at is null")->result_array();
        } else{
            return $this->db->get_where('ukuran_hewan', ['id_ukuran' => $id_ukuran]) ->result_array();
        }
        
    }

    public function deleteUkuran_hewan($data,$id_ukuran){
        $this->db->update('ukuran_hewan' , $data , ['id_ukuran' => $id_ukuran]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_ukuran){
        $this->db->delete('ukuran_hewan' , ['id_ukuran' => $id_ukuran]);
        return $this->db->affected_rows();
    }

    public function createUkuran_hewan($data){
        $this->db->insert('ukuran_hewan', $data);
        return $this->db->affected_rows();
    }

    public function updateUkuran_hewan($data,$id_ukuran){
        $this->db->update('ukuran_hewan' , $data , ['id_ukuran' => $id_ukuran]);
        return $this->db->affected_rows();
    }
}