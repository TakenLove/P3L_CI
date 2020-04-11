<?php

class Jenis_hewan_model extends CI_Model{

    //untuk tampil semua data
    public function getLogJenis_hewan($id_jenis = null){
        if($id_jenis === null){
            return $this->db->query("SELECT j.id_jenis ,j.jenis ,j.harga, j.created_at, j.update_at, j.delete_at, p.nama as aktor
            from jenis_hewan j JOIN pegawai p ON (j.aktor = p.id_pegawai)")->result_array();
        } else{
            return $this->db->get_where('jenis_hewan', ['id_jenis' => $id_jenis]) ->result_array();
        }
        
    }

    //tidak menampilkan yang ter soft delete
    public function getJenis_hewan($id_jenis = null){
        if($id_jenis === null){
            return $this->db->query("SELECT j.id_jenis ,j.jenis ,j.harga, j.created_at, j.update_at, j.delete_at, p.nama as aktor
            from jenis_hewan j JOIN pegawai p ON (j.aktor = p.id_pegawai) where j.delete_at is null")->result_array();
        } else{
            return $this->db->get_where('jenis_hewan', ['id_jenis' => $id_jenis]) ->result_array();
        }   
    }

    public function deleteJenis_hewan($data,$id_jenis){
        $this->db->update('jenis_hewan' , $data , ['id_jenis' => $id_jenis]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_jenis){
        $this->db->delete('jenis_hewan' , ['id_jenis' => $id_jenis]);
        return $this->db->affected_rows();
    }

    public function createJenis_hewan($data){
        $this->db->insert('jenis_hewan', $data);
        return $this->db->affected_rows();
    }

    public function updateJenis_hewan($data,$id_jenis){
        $this->db->update('jenis_hewan' , $data , ['id_jenis' => $id_jenis]);
        return $this->db->affected_rows();
    }
}