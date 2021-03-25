<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_biaya_model extends MY_Model
{
    public $table = 'transaksi_biaya';
    public $primary_key = 'id';
    public $column_order = array(null, 'transaksi_biaya.id','nama_biaya','tanggal','nominal','status','kode_referensi',null);
    public $column_search = array('transaksi_biaya.id','nama_biaya','tanggal','nominal','status','kode_referensi');
    public $order = array('tanggal' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('transaksi_biaya.id, nama_biaya, tanggal, nominal, status, kode_referensi');
        $this->db->join('jenis_biaya','jenis_biaya.id = transaksi_biaya.id_jenis_biaya');
        $this->db->where('jenis_biaya.is_harian != ','1');
       $this->db->from($this->table);
          $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->select($this->primary_key);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where($this->primary_key,$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_by_id($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
    }

    
    //untuk detail laba rugi
    public function select_insert_biaya_perbulan_tahun($bulan,$tahun,$idlabarugi){
        
        /*
        $this->db->select("kode_referensi as kode_so, nominal, tanggal as tgl_trans");
        $this->db->where(" month(tanggal)='$bulan' and year(tanggal) = '$tahun' and status='Lunas' ");
        $query = $this->db->get($this->table);
        */
        
        $this->db->select("
            sum(c.`nominal`) as nominal, now() as `tgl_trans`, d.nama_biaya as jenis_trans
            
        ");
        //$this->db->join("piutang b","b.kode_referensi = a.kode_piutang");
        $this->db->join("transaksi_biaya c","c.kode_referensi = a.kode_piutang");
        $this->db->join("jenis_biaya d","d.id = c.id_jenis_biaya");
        $this->db->where(" month(a.tanggal)='$bulan' and year(a.tanggal) = '$tahun'  ");
        $this->db->where("d.id not in ('f09925751b7988434bdfa883b370bd44', '69ea49d4740ef0b03d818f055de99b1f','5e07f1f86d4fc32542a2df57d8339a2d','aa083acc31d09e74122a742aae63e4b1')");
        $this->db->group_by('d.nama_biaya');
        $query = $this->db->get('pembayaran_piutang a');
        
        $hasil = $query->result_array();
        $i=1;
        foreach($hasil as $row){
            $row['id_detail_laba_rugi']=$id=md5($bulan.'/'.$tahun.'/biaya/'.$i);
            $row['created_at']=date('Y-m-d H:i:s');
            $row['id_laba_rugi']=$idlabarugi;
            //$row['jenis_trans']='biaya';
            $insert = $this->db->insert('detail_laba_rugi', $row);
            $i++;
        }
        return $insert;
    }

    public function select_insert_biaya_bank_perbulan_tahun($bulan,$tahun,$idlabarugi){
        
        $this->db->select("
            ifnull(sum(2.5 / 100 * harga * qty ),0) as nominal , now() as `tgl_trans`
            from pembayaran_piutang a
            join detail_so b on b.kode_so = a.kode_piutang
        ");
        $this->db->where(" month(a.tanggal)='$bulan' and year(a.tanggal) = '$tahun'");

        $query = $this->db->get();
        
        $hasil = $query->result_array();
        $i=1;
        foreach($hasil as $row){
            $row['id_detail_laba_rugi']=$id=md5($bulan.'/'.$tahun.'/biayaBank/'.$i);
            $row['created_at']=date('Y-m-d H:i:s');
            $row['id_laba_rugi']=$idlabarugi;
            $row['jenis_trans']='Bunga Bank';
            $insert = $this->db->insert('detail_laba_rugi', $row);
            $i++;
        }
        return $insert;
    }

    public function select_insert_biaya_cold_perbulan_tahun($bulan,$tahun,$idlabarugi){
        
        $this->db->select("
            ifnull(sum(900 * qty ),0) as nominal , now() as `tgl_trans`
            from pembayaran_piutang a
            join detail_so b on b.kode_so = a.kode_piutang
        ");
        $this->db->where(" month(a.tanggal)='$bulan' and year(a.tanggal) = '$tahun'");

        $query = $this->db->get();
        
        $hasil = $query->result_array();
        $i=1;
        foreach($hasil as $row){
            $row['id_detail_laba_rugi']=$id=md5($bulan.'/'.$tahun.'/codStorage/'.$i);
            $row['created_at']=date('Y-m-d H:i:s');
            $row['id_laba_rugi']=$idlabarugi;
            $row['jenis_trans']='Cold Storage';
            $insert = $this->db->insert('detail_laba_rugi', $row);
            $i++;
        }
        return $insert;
    }

    public function select_insert_biaya_perbulan_tahun_komisi_sales($bulan,$tahun,$idlabarugi){
        
        $query = $this->db->query("SELECT kode_pegawai, (c.harga * 1.5 / 100 * c.qty) as nominal, d.kode_so, c.nama_barang, c.qty FROM `sales_order` `d` 
JOIN `detail_so` `c` ON `c`.`kode_so` = `d`.`kode_so` 
-- JOIN `pengiriman_so` `f` ON `f`.`kode_so` = `d`.`kode_so` and c.kode_barang = f.kode_barang
JOIN `pegawai` `e` ON `e`.`kode_pegawai` = `d`.`kode_sales` 
JOIN `barang` `g` ON `g`.`kode` = `c`.`kode_barang` 
join (select * from pembayaran_piutang where month(tanggal) = '$bulan' and year(tanggal) = '$tahun' group by kode_piutang) b on b.kode_piutang = c.kode_so WHERE  `e`.`jabatan` != 'owner' ");
       /* 
        $this->db->select(" kode_pegawai, (c.harga * 1.5 / 100) as nominal, d.kode_so, c.nama_barang, c.qty
        ");
        $this->db->join("piutang b","a.kode_piutang = b.kode_referensi");
        $this->db->join("detail_so c","c.kode_so = b.kode_referensi");
        $this->db->join("sales_order d","d.kode_so = c.kode_so");
        $this->db->join("pegawai e","e.kode_pegawai = d.kode_sales");

        $this->db->where(" month(d.tanggal)='$bulan' and year(d.tanggal) = '$tahun' and e.jabatan != 'owner' ");
        //$this->db->group_by("d.kode_so");
        $query = $this->db->get('pembayaran_piutangx a');
        */
        
        $hasil = $query->result_array();
        $i=1;
        foreach($hasil as $row){
            $row['id']=$id=md5($bulan.'/'.$tahun.'/penjualan/'.$i.date('Y-m-d H:i:s'));
            $row['created_at']=date('Y-m-d H:i:s');
            $row['id_laba_rugi']=$idlabarugi;
            $row['jenis_komisi']= 'Sales';
            //$row['jenis_trans']='biaya';
            $insert = $this->db->insert('komisi', $row);
            $i++;
        }
        return $insert;
    }

    public function total_biaya_perbulan_tahun_komisi_sales($bulan,$tahun){
        
        $query = $this->db->query("SELECT kode_pegawai, (c.harga * 1.5 / 100 * c.qty) as nominal, d.kode_so, c.nama_barang, c.qty FROM `sales_order` `d` 
JOIN `detail_so` `c` ON `c`.`kode_so` = `d`.`kode_so` 
-- JOIN `pengiriman_so` `f` ON `f`.`kode_so` = `d`.`kode_so` and c.kode_barang = f.kode_barang
JOIN `pegawai` `e` ON `e`.`kode_pegawai` = `d`.`kode_sales` 
JOIN `barang` `g` ON `g`.`kode` = `c`.`kode_barang` 
join (select * from pembayaran_piutang where month(tanggal) = '$bulan' and year(tanggal) = '$tahun' group by kode_piutang) b on b.kode_piutang = c.kode_so WHERE  `e`.`jabatan` != 'owner' ");
       /* 
        $this->db->select(" kode_pegawai, (c.harga * 1.5 / 100) as nominal, d.kode_so, c.nama_barang, c.qty
        ");
        $this->db->join("piutang b","a.kode_piutang = b.kode_referensi");
        $this->db->join("detail_so c","c.kode_so = b.kode_referensi");
        $this->db->join("sales_order d","d.kode_so = c.kode_so");
        $this->db->join("pegawai e","e.kode_pegawai = d.kode_sales");

        $this->db->where(" month(d.tanggal)='$bulan' and year(d.tanggal) = '$tahun' and e.jabatan != 'owner' ");
        //$this->db->group_by("d.kode_so");
        $query = $this->db->get('pembayaran_piutangx a');
        */
        
        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total = $atributy->total ;
                
            }

        }
        return $total;

    }

    public function select_insert_biaya_perbulan_tahun_komisi_pengiriman($bulan,$tahun,$idlabarugi){
        
        /*
        $this->db->select("kode_referensi as kode_so, nominal, tanggal as tgl_trans");
        $this->db->where(" month(tanggal)='$bulan' and year(tanggal) = '$tahun' and status='Lunas' ");
        $query = $this->db->get($this->table);
        */
        //$this->db->_protect_identifiers=false;

        $query = $this->db->query("SELECT `kode_pegawai`, if(g.satuan = 'pcs', if(g.kode = 'ayj',f.qty * 200 *  0.6, f.qty * 200 *  0.25), if(g.kode = 'ff',f.qty * 200 *  2.5, f.qty * 200)) as nominal, 
`d`.`kode_so`, `f`.`nama_barang`, `f`.`qty` FROM `sales_order` `d` 
JOIN `detail_so` `c` ON `c`.`kode_so` = `d`.`kode_so` 
JOIN `pengiriman_so` `f` ON `f`.`kode_so` = `d`.`kode_so` and c.kode_barang = f.kode_barang
JOIN `pegawai` `e` ON `e`.`kode_pegawai` = `f`.`kode_kurir` 
JOIN `barang` `g` ON `g`.`kode` = `c`.`kode_barang` WHERE month(d.tanggal) = '$bulan' 
and year(d.tanggal) = '$tahun' and `e`.`jabatan` != 'owner' ");
        /*
        $this->db->select(" kode_pegawai, if(g.satuan = 'pcs',f.qty*200*25/100,f.qty*200)   as nominal, d.kode_so, f.nama_barang, f.qty
        ");
        //$this->db->join("piutang b","a.kode_piutang = b.kode_referensi");
        $this->db->join("detail_so c","c.kode_so = d.kode_so");
        //$this->db->join("sales_order d","d.kode_so = c.kode_so");
        $this->db->join("pengiriman_so f","f.kode_so = d.kode_so");
        $this->db->join("pegawai e","e.kode_pegawai = f.kode_kurir");
        $this->db->join("barang g","g.kode = c.kode_barang");
        $this->db->where(" month(d.tanggal)='$bulan' and year(d.tanggal) = '$tahun' and e.jabatan != 'owner' ");
        //$this->db->group_by("d.kode_so");
        $query = $this->db->get('sales_order d');
        */

        //$query = $this->db->get();

        $hasil = $query->result_array();
        $i=1;
        foreach($hasil as $row){
            $row['id']=$id=md5($bulan.'/'.$tahun.'/pengiriman/'.$i.$idlabarugi);
            $row['created_at']=date('Y-m-d H:i:s');
            $row['id_laba_rugi']=$idlabarugi;
            $row['jenis_komisi']= 'Pengiriman';
            //$row['jenis_trans']='biaya';
            $insert = $this->db->insert('komisi', $row);
            $i++;
        }
        return $insert;
    }

    public function total_biaya_perbulan_tahun_komisi_pengiriman($bulan,$tahun){
        
        /*
        $this->db->select("kode_referensi as kode_so, nominal, tanggal as tgl_trans");
        $this->db->where(" month(tanggal)='$bulan' and year(tanggal) = '$tahun' and status='Lunas' ");
        $query = $this->db->get($this->table);
        */
        //$this->db->_protect_identifiers=false;

        $query = $this->db->query("SELECT `kode_pegawai`, if(g.satuan = 'pcs', if(g.kode = 'ayj',f.qty * 200 *  0.6, f.qty * 200 *  0.25), if(g.kode = 'ff',f.qty * 200 *  2.5, f.qty * 200)) as nominal, 
`d`.`kode_so`, `f`.`nama_barang`, `f`.`qty` FROM `sales_order` `d` 
JOIN `detail_so` `c` ON `c`.`kode_so` = `d`.`kode_so` 
JOIN `pengiriman_so` `f` ON `f`.`kode_so` = `d`.`kode_so` and c.kode_barang = f.kode_barang
JOIN `pegawai` `e` ON `e`.`kode_pegawai` = `f`.`kode_kurir` 
JOIN `barang` `g` ON `g`.`kode` = `c`.`kode_barang` WHERE month(d.tanggal) = '$bulan' 
and year(d.tanggal) = '$tahun' and `e`.`jabatan` != 'owner' ");
        /*
        $this->db->select(" kode_pegawai, if(g.satuan = 'pcs',f.qty*200*25/100,f.qty*200)   as nominal, d.kode_so, f.nama_barang, f.qty
        ");
        //$this->db->join("piutang b","a.kode_piutang = b.kode_referensi");
        $this->db->join("detail_so c","c.kode_so = d.kode_so");
        //$this->db->join("sales_order d","d.kode_so = c.kode_so");
        $this->db->join("pengiriman_so f","f.kode_so = d.kode_so");
        $this->db->join("pegawai e","e.kode_pegawai = f.kode_kurir");
        $this->db->join("barang g","g.kode = c.kode_barang");
        $this->db->where(" month(d.tanggal)='$bulan' and year(d.tanggal) = '$tahun' and e.jabatan != 'owner' ");
        //$this->db->group_by("d.kode_so");
        $query = $this->db->get('sales_order d');
        */

        //$query = $this->db->get();


        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total = $atributy->total ;
                
            }

        }
        return $total;

    }

  

    public function insert_biaya_perbulan_tahun_komisi_sales($idlabarugi){
        
        $this->db->select("sum(pp.nominal) as nominal");
        $this->db->where("id_laba_rugi = '$idlabarugi'");
        $this->db->where("jenis_komisi = 'Sales'");
        $this->db->from('komisi'.' pp');

        $query = $this->db->get();
        $hasil = $query->result_array();
        $i=1;
        foreach($hasil as $row){
            $row['id_detail_laba_rugi']=$id=md5($bulan.'/'.$tahun.'/sales/'.$i.$idlabarugi);
            $row['created_at']=date('Y-m-d H:i:s');
            $row['tgl_trans']=date('Y-m-d H:i:s');
            $row['id_laba_rugi']=$idlabarugi;
            $row['jenis_trans']='Sales';
            $insert = $this->db->insert('detail_laba_rugi', $row);
            $i++;
        }
        return $insert;
    }

    public function insert_biaya_perbulan_tahun_komisi_pengiriman($idlabarugi){
        
        $this->db->select("sum(pp.nominal) as nominal");
        $this->db->where("id_laba_rugi = '$idlabarugi'");
        $this->db->where("jenis_komisi = 'Pengiriman'");
        $this->db->from('komisi'.' pp');

        $query = $this->db->get();
        $hasil = $query->result_array();
        $i=1;
        foreach($hasil as $row){
            $row['id_detail_laba_rugi']=$id=md5($bulan.'/'.$tahun.'/Pengiriman/'.$i.$idlabarugi);
            $row['created_at']=date('Y-m-d H:i:s');
            $row['tgl_trans']=date('Y-m-d H:i:s');
            $row['id_laba_rugi']=$idlabarugi;
            $row['jenis_trans']='Pengiriman';
            $insert = $this->db->insert('detail_laba_rugi', $row);
            $i++;
        }
        return $insert;
    }
}