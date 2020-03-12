<?php

class Jenis_hewan_model extends CI_Model{

    public function getJenis_hewan($id_jenis = null){
        if($id_jenis === null){
            return $this->db->get('jenis_hewan')->result_array();
        } else{
            return $this->db->get_where('jenis_hewan', ['id_jenis' => $id_jenis]) ->result_array();
        }
        
    }

    public function deleteJenis_hewan($id_jenis){
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