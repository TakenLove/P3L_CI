<?php

class Laporan_model extends CI_Model{

//===================================================================
    public function getLaporanJasaLayananTerlarisTahun($tahun){
        return $this->db->query("SELECT
        b.id_bulan,
        b.nama_bulan as 'nama_bulan',
        COALESCE(tp.nama_layanan , '-') as 'nama_layanan',
        COALESCE(tp.jumlah,0) as 'jumlah_layanan'
        FROM (SELECT 'January' as nama_bulan, 1 as id_bulan
            UNION
            SELECT 'February', 2
            UNION
            SELECT 'March', 3
            UNION
            SELECT 'April', 4
            UNION
            SELECT 'May', 5
            UNION
            SELECT 'June', 6
            UNION
            SELECT 'July', 7
            UNION
            SELECT 'August', 8
            UNION
            SELECT 'September', 9
            UNION
            SELECT 'October', 10
            UNION
            SELECT 'November', 11
            UNION
            SELECT 'December', 12) b
        LEFT JOIN  (
            SELECT data.bulan, data.jumlah , data.nama_layanan
        FROM (SELECT bulan , nama_layanan, MAX(jumlah_layanan) as jumlah , tahun
        FROM (SELECT month(transaksi_layanan.created_at) as 'bulan' , 
            YEAR(transaksi_layanan.created_at) as 'tahun' ,
            CONCAT(layanan.nama ,' ',
            jenis_hewan.jenis ,' ',
            ukuran_hewan.ukuran ) as 'nama_layanan',    
            SUM(detail_transaksi_layanan.jumlah) as 'jumlah_layanan'
            FROM detail_transaksi_layanan JOIN layanan USING (id_layanan) JOIN 
            transaksi_layanan USING (id_transaksi_layanan) JOIN ukuran_hewan USING(id_ukuran)
            JOIN jenis_hewan USING (id_jenis) GROUP BY nama_layanan) as ll
        ) as data WHERE tahun = '$tahun' GROUP BY bulan
        ) as tp ON (b.id_bulan = tp.bulan)
        ORDER BY
            b.id_bulan ASC")->result_array();
    }
//===================================================================
    public function getLaporanProdukTerlaris($tahun){
        return $this->db->query("SELECT
        b.id_bulan,
        b.nama_bulan,
        COALESCE(tp.nama_produk,'-') as'nama_produk',
        COALESCE(tp.jumlah,0) as 'jumlah_produk'
        FROM (SELECT 'January' as nama_bulan, 1 as id_bulan
            UNION
            SELECT 'February', 2
            UNION
            SELECT 'March', 3
            UNION
            SELECT 'April', 4
            UNION
            SELECT 'May', 5
            UNION
            SELECT 'June', 6
            UNION
            SELECT 'July', 7
            UNION
            SELECT 'August', 8
            UNION
            SELECT 'September', 9
            UNION
            SELECT 'October', 10
            UNION
            SELECT 'November', 11
            UNION
            SELECT 'December', 12) b
        LEFT JOIN  (
            SELECT data.bulan, data.jumlah , data.nama_produk
        FROM (SELECT bulan , nama_produk , MAX(jumlah_produk) as jumlah 
                FROM (SELECT month(transaksi_produk.created_at) AS bulan , 
                produk.nama AS nama_produk , 
                SUM(detail_transaksi_produk.jumlah) AS jumlah_produk 
                FROM detail_transaksi_produk JOIN produk USING (id_produk) 
                JOIN transaksi_produk USING (id_transaksi_produk) GROUP BY produk.id_produk ) as dd
        ) as data GROUP BY bulan
        ) as tp ON (b.id_bulan = tp.bulan)
        ORDER BY
        b.id_bulan ASC")->result_array();
    }
//===================================================================
    public function getLaporanPendapatanLayananTahun($tahun){
        return $this->db->query("SELECT
        b.id_bulan,
        b.nama_bulan,
        COALESCE(ptl.jasa_layanan,'0') AS 'jasa_layanan'
        FROM (SELECT 'January' as nama_bulan, 1 as id_bulan
            UNION
            SELECT 'February', 2
            UNION
            SELECT 'March', 3
            UNION
            SELECT 'April', 4
            UNION
            SELECT 'May', 5
            UNION
            SELECT 'June', 6
            UNION
            SELECT 'July', 7
            UNION
            SELECT 'August', 8
            UNION
            SELECT 'September', 9
            UNION
            SELECT 'October', 10
            UNION
            SELECT 'November', 11
            UNION
            SELECT 'December', 12) b
        LEFT JOIN  (
            SELECT data.jasa_layanan , data.bulan
        FROM (SELECT bulan , jasa_layanan ,tahun
            FROM (SELECT month(transaksi_layanan.created_at) as bulan, 
            YEAR(transaksi_layanan.created_at) as tahun, 
            SUM(detail_transaksi_layanan.sub_harga) as 'jasa_layanan'  
            FROM detail_transaksi_layanan JOIN transaksi_layanan USING (id_transaksi_layanan) GROUP BY bulan) AS jl
        ) as data WHERE tahun = '$tahun'
        ) as ptl ON (b.id_bulan = ptl.bulan)
        ORDER BY
        b.id_bulan ASC")->result_array();
    }

    public function getLaporanPendapatanProdukTahun($tahun){
        return $this->db->query("SELECT
        b.id_bulan,
        b.nama_bulan,
        COALESCE(ptl.produk,0) as produk
        FROM (SELECT 'January' as nama_bulan, 1 as id_bulan
            UNION
            SELECT 'February', 2
            UNION
            SELECT 'March', 3
            UNION
            SELECT 'April', 4
            UNION
            SELECT 'May', 5
            UNION
            SELECT 'June', 6
            UNION
            SELECT 'July', 7
            UNION
            SELECT 'August', 8
            UNION
            SELECT 'September', 9
            UNION
            SELECT 'October', 10
            UNION
            SELECT 'November', 11
            UNION
            SELECT 'December', 12) b
            LEFT JOIN  (
            SELECT data.produk , data.bulan
            FROM (SELECT bulan , produk , tahun
            FROM (SELECT month(transaksi_produk.created_at) as bulan, 
            YEAR(transaksi_produk.created_at) as tahun,
            SUM(detail_transaksi_produk.sub_harga) as 'produk'  
            FROM detail_transaksi_produk JOIN transaksi_produk USING (id_transaksi_produk) GROUP BY bulan) AS pr
        ) as data WHERE tahun = '$tahun'
        ) as ptl ON (b.id_bulan = ptl.bulan)
        ORDER BY
        b.id_bulan ASC")->result_array();
    }
//===================================================================
    public function getLaporanPendapatanLayananBulan($tahun,$bulan){
        return $this->db->query("SELECT data.nama_jasa_layanan , data.harga 
        FROM (SELECT CONCAT (l.nama ,' ',j.jenis ,' ', u.ukuran) as 'nama_jasa_layanan', SUM(dl.sub_harga) as 'harga' , MONTH(tl.created_at) as 'bulan', YEAR(tl.created_at) as 'tahun'
            FROM detail_transaksi_layanan dl JOIN transaksi_layanan tl ON (dl.id_transaksi_layanan=tl.id_transaksi_layanan) 
            JOIN layanan l ON (dl.id_layanan=l.id_layanan) JOIN ukuran_hewan u ON (dl.id_ukuran=u.id_ukuran) JOIN jenis_hewan j ON (dl.id_jenis=j.id_jenis) GROUP BY nama_jasa_layanan , bulan) as data WHERE bulan = '$bulan' AND tahun = '$tahun'")->result_array();
    }

    public function getLaporanPendapatanProdukBulan($tahun,$bulan){
        return $this->db->query("SELECT data.nama_produk , data.harga 
        FROM (SELECT p.nama as 'nama_produk', SUM(dp.sub_harga) as 'harga' , MONTH(tp.created_at) as 'bulan', YEAR(tp.created_at) as 'tahun'
            FROM detail_transaksi_produk dp JOIN transaksi_produk tp ON (dp.id_transaksi_produk=tp.id_transaksi_produk) 
            JOIN produk p ON (dp.id_produk=p.id_produk) GROUP BY dp.id_produk , bulan) as data WHERE bulan = '$bulan' AND tahun = '$tahun'")->result_array();
    }

//===================================================================
    public function getLaporanPengadaanProdukTahun($tahun){
        return $this->db->query("SELECT
        month_index.month_name,
        IFNULL(pengadaan.jumlah,0) as 'jumlah'
        FROM (
            SELECT 'January' as month_name, 1 as month_number
            UNION
            SELECT 'February', 2
            UNION
            SELECT 'March', 3
            UNION
            SELECT 'April', 4
            UNION
            SELECT 'May', 5
            UNION
            SELECT 'June', 6
            UNION
            SELECT 'July', 7
            UNION
            SELECT 'August', 8
            UNION
            SELECT 'September', 9
            UNION
            SELECT 'October', 10
            UNION
            SELECT 'November', 11
            UNION
            SELECT 'December', 12
        ) as month_index
        
        LEFT JOIN (
            SELECT data.bulan, data.jumlah
        FROM (SELECT YEAR(p.printed_at) as tahun, MONTHNAME(p.printed_at) as bulan,
            SUM(d.sub_harga) as jumlah FROM detail_pengadaan_produk d JOIN pengadaan_produk p ON (d.id_pengadaan = p.id_pengadaan) WHERE p.printed_at IS NOT NULL  
            GROUP BY bulan) as data WHERE
            tahun= '$tahun' GROUP BY bulan
        ) as pengadaan ON (month_index.month_name = pengadaan.bulan)
        ORDER BY
            month_index.month_number ASC")->result_array();
    }

//===================================================================
    public function getLaporanPengadaanProdukBulan($tahun,$bulan){
        return $this->db->query("SELECT data.nama_produk , data.jumlah_pengeluaran
        FROM (SELECT p.nama as 'nama_produk' , SUM(d.sub_harga) as 'jumlah_pengeluaran' , d.id_produk , YEAR(pp.printed_at ) as 'tahun' , month(pp.printed_at) as 'bulan' FROM detail_pengadaan_produk d JOIN produk p ON (d.id_produk=p.id_produk) JOIN pengadaan_produk pp ON (d.id_pengadaan=pp.id_pengadaan) GROUP BY d.id_produk , bulan) as data WHERE tahun = '$tahun' AND bulan = '$bulan'")->result_array();
    }
    
}