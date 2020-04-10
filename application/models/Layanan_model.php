<?php

class Layanan_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id = null){
        if($id === null){
            return $this->db->query("SELECT l.id_layanan, l.nama, l.harga, l.created_at, l.update_at, l.delete_at, p.nama as aktor
            from layanan l JOIN pegawai p ON (l.aktor = p.id_pegawai)")->result_array();
        } else{
            return $this->db->get_where('layanan', ['id_layanan' => $id]) ->result_array();
        }
        
    }

    //tidak menampilkan yang ter soft delete    
    public function getLayanan($id_layanan = null){
        if($id_layanan === null){
            return $this->db->query("SELECT l.id_layanan, l.nama, l.harga, l.created_at, l.update_at, l.delete_at, p.nama as aktor
            from layanan l JOIN pegawai p ON (l.aktor = p.id_pegawai) where l.delete_at is null")->result_array();
        } else{
            return $this->db->get_where('layanan', ['id_layanan' => $id_layanan]) ->result_array();
        }
        
    }

    public function deleteLayanan($data,$id_layanan){
        $this->db->update('layanan' , $data , ['id_layanan' => $id_layanan]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_layanan){
        $this->db->delete('layanan' , ['id_layanan' => $id_layanan]);
        return $this->db->affected_rows();
    }

    public function createLayanan($data){
        $this->db->insert('layanan', $data);
        return $this->db->affected_rows();
    }

    public function updateLayanan($data,$id_layanan){
        $this->db->update('layanan' , $data , ['id_layanan' => $id_layanan]);
        return $this->db->affected_rows();
    }
}