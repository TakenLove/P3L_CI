<?php

class Transaksi_produk_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id = null){
        if($id === null){
            return $this->db->query("SELECT tp.id_transaksi_produk, tp.total_harga, tp.diskon, tp.sub_total, tp.id_member, tp.created_at, tp.update_at, tp.delete_at, m.nama as member, p.nama as aktor
            from transaksi_produk tp JOIN pegawai p ON (tp.aktor = p.id_pegawai) JOIN member m ON (tp.id_member = m.id_member) ")->result_array();
        } else{
            return $this->db->get_where('transaksi_produk', ['id_transaksi_produk' => $id]) ->result_array();
        }
        
    }

    public function getID($id = null){
        if($id === null){
            return $this->db->query("SELECT id_transaksi_produk, total_harga, diskon, sub_total, created_at, update_at, delete_at, aktor
            from transaksi_produk where id_pegawai_cs = '0'")->result_array();
        } else{
            return $this->db->get_where('transaksi_produk', ['id_transaksi_produk' => $id]) ->result_array();
        }
    }

    //tidak menampilkan yang ter soft delete  
    public function getTransaksi_produk($id_transaksi_produk = null){
        if($id_transaksi_produk === null){
            return $this->db->query("SELECT tp.id_transaksi_produk, tp.total_harga, tp.diskon, tp.sub_total, tp.id_member, tp.created_at, tp.update_at, tp.delete_at, tp.id_pegawai_cs, tp.aktor, m.nama as member, p.nama as aktors
            from transaksi_produk tp JOIN pegawai p ON (tp.aktor = p.id_pegawai) JOIN member m ON (tp.id_member = m.id_member) where tp.delete_at IS NULL and tp.id_pegawai_cs = '0'")->result_array(); 
        } else{
            return $this->db->get_where('transaksi_produk', ['id_transaksi_produk' => $id_transaksi_produk]) ->result_array();
        }
        
    }

    public function deleteTransaksi_produk($data,$id_transaksi_produk){
        $this->db->update('transaksi_produk' , $data , ['id_transaksi_produk' => $id_transaksi_produk]);
        return $this->db->affected_rows();
    }
    
    public function hardDelete($id_transaksi_produk){
        $this->db->delete('transaksi_produk' , ['id_transaksi_produk' => $id_transaksi_produk]);
        return $this->db->affected_rows();
    }

    public function createTransaksi_produk($data){
        $this->db->insert('transaksi_produk', $data);
        return $this->db->affected_rows();
    }

    public function updateTransaksi_produk($data,$id_transaksi_produk){
        $this->db->update('transaksi_produk' , $data , ['id_transaksi_produk' => $id_transaksi_produk]);
        return $this->db->affected_rows();
    }
}