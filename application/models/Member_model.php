<?php

class Member_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id = null){
        if($id === null){
            return $this->db->query("SELECT m.nama, m.no_telp, m.tgl_lhr, m.alamat, m.created_at, m.update_at, m.delete_at, m.status, p.nama as aktor
            from member m JOIN pegawai p ON (m.aktor = p.id_pegawai)")->result_array();
        } else{
            return $this->db->get_where('member', ['id_member' => $id]) ->result_array();
        }
        
    }

    //tidak menampilkan yang ter soft delete 
    public function getMember($id_member = null){
        if($id_member === null){
            return $this->db->query("SELECT m.nama, m.no_telp, m.tgl_lhr, m.alamat, m.created_at, m.update_at, m.delete_at, m.status, p.nama as aktor
            from member m JOIN pegawai p ON (m.aktor = p.id_pegawai) where m.delete_at IS NULL")->result_array();
        } else{
            return $this->db->get_where('member', ['id_member' => $id_member]) ->result_array();
        }
        
    }

    public function deleteMember($data,$id_member){
        $this->db->update('member' , $data , ['id_member' => $id_member]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_member){
        $this->db->delete('member' , ['id_member' => $id_member]);
        return $this->db->affected_rows();
    }

    public function createMember($data){
        $this->db->insert('member', $data);
        return $this->db->affected_rows();
    }

    public function updateMember($data,$id_member){
        $this->db->update('member' , $data , ['id_member' => $id_member]);
        return $this->db->affected_rows();
    }
}