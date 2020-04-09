<?php

class Data_hewan_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id = null){
        if($id === null){
            return $this->db->query("SELECT DH.id_hewan, DH.id_jenis, DH.id_ukuran, DH.nama, DH.tgl_lhr, DH.created_at, DH.update_at, DH.delete_at, DH.id_pegawai_cs, DH.id_pegawai_kasir, DH.id_member, DH.created_by, DH.deleted_by ,J.jenis , U.ukuran , M.nama AS nama_member , P1.nama AS nama_cs , P2.nama AS nama_kasir , P3.nama AS nama_created_by , P4.nama AS nama_deleted_by
            FROM data_hewan DH JOIN jenis_hewan J ON (DH.id_jenis = J.id_jenis) JOIN ukuran_hewan U ON (DH.id_ukuran = U.id_ukuran) JOIN member M ON (DH.id_member = M.id_member) JOIN pegawai P1 ON (DH.id_pegawai_cs = P1.id_pegawai) JOIN pegawai P2 ON (DH.id_pegawai_kasir = P2.id_pegawai) JOIN pegawai P3 ON (DH.created_by = P3.id_pegawai) JOIN pegawai P4 ON (DH.deleted_by = P4.id_pegawai)")->result_array();
        } else{
            return $this->db->get_where('data_hewan', ['id_hewan' => $id]) ->result_array();
        }
        
    }

    //tidak menampilkan yang ter soft delete  
    public function getData_hewan($id_hewan = null){
        if($id_hewan === null){
            return $this->db->query("SELECT DH.id_hewan, DH.id_jenis, DH.id_ukuran, DH.nama, DH.tgl_lhr, DH.created_at, DH.update_at, DH.delete_at, DH.id_pegawai_cs, DH.id_pegawai_kasir, DH.id_member, DH.created_by, DH.deleted_by ,J.jenis , U.ukuran , M.nama AS nama_member , P1.nama AS nama_cs , P2.nama AS nama_kasir , P3.nama AS nama_created_by , P4.nama AS nama_deleted_by
            FROM data_hewan DH JOIN jenis_hewan J ON (DH.id_jenis = J.id_jenis) JOIN ukuran_hewan U ON (DH.id_ukuran = U.id_ukuran) JOIN member M ON (DH.id_member = M.id_member) JOIN pegawai P1 ON (DH.id_pegawai_cs = P1.id_pegawai) JOIN pegawai P2 ON (DH.id_pegawai_kasir = P2.id_pegawai) JOIN pegawai P3 ON (DH.created_by = P3.id_pegawai) JOIN pegawai P4 ON (DH.deleted_by = P4.id_pegawai) WHERE DH.delete_at IS NULL")->result_array();
        } else{
            return $this->db->get_where('data_hewan', ['id_hewan' => $id_hewan]) ->result_array();
        }
        
    }

    public function deleteData_hewan($data,$id_hewan){
        $this->db->update('data_hewan' , $data , ['id_hewan' => $id_hewan]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_hewan){
        $this->db->delete('data_hewan' , ['id_hewan' => $id_hewan]);
        return $this->db->affected_rows();
    }

    public function createData_hewan($data){
        $this->db->insert('data_hewan', $data);
        return $this->db->affected_rows();
    }

    public function updateData_hewan($data,$id_hewan){
        $this->db->update('data_hewan' , $data , ['id_hewan' => $id_hewan]);
        return $this->db->affected_rows();
    }
}