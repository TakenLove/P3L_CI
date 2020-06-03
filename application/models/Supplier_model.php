<?php

class Supplier_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id = null){
        if($id === null){
            return $this->db->query("SELECT s.id_supplier ,s.nama ,s.no_telp, s.alamat, s.created_at, s.update_at, s.delete_at, p.nama as aktor
            from supplier s JOIN pegawai p ON (s.aktor = p.id_pegawai)")->result_array();
        } else{
            return $this->db->get_where('supplier', ['id_supplier' => $id]) ->result_array();
        }
        
    }

    //tidak menampilkan yang ter soft delete    
    public function getSupplier($id_supplier = null){
        if($id_supplier === null){
            return $this->db->query("SELECT s.id_supplier ,s.nama ,s.no_telp, s.alamat, s.created_at, s.update_at, s.delete_at, p.nama as aktor
            from supplier s JOIN pegawai p ON (s.aktor = p.id_pegawai) where s.delete_at is null")->result_array();
        } else{
            return $this->db->get_where('supplier', ['id_supplier' => $id_supplier]) ->result();
        }
        
    }

    public function getSupplierData($nama){
        return $this->db->query("SELECT s.id_supplier ,s.nama ,s.no_telp, s.alamat, s.created_at, s.update_at, s.delete_at, p.nama as aktor
        from supplier s JOIN pegawai p ON (s.aktor = p.id_pegawai) where s.nama='$nama'")->result_array();
        
    }

    public function deleteSupplier($data,$id_supplier){
        $this->db->update('supplier' , $data , ['id_supplier' => $id_supplier]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_supplier){
        $this->db->delete('supplier' , ['id_supplier' => $id_supplier]);
        return $this->db->affected_rows();
    }

    public function createSupplier($data){
        $this->db->insert('supplier', $data);
        return $this->db->affected_rows();
    }

    public function updateSupplier($data,$id_supplier){
        $this->db->update('supplier' , $data , ['id_supplier' => $id_supplier]);
        return $this->db->affected_rows();
    }
}