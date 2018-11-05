<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan_po_model extends MY_Model
{
    public $table = 'penerimaan_po';
    public $primary_key = 'id';
    public $column_order = array(null, 'id','tanggal','kode_po','kode_penerimaan','kode_supplier','nama_supplier',null);
    public $column_search = array('id','tanggal','kode_po','kode_supplier','nama_supplier','kode_penerimaan');
    public $order = array('penerimaan_po.kode_penerimaan_po' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        
        $this->db->select("
        detail_penerimaan_po.id,
        penerimaan_po.kode_penerimaan_po as kode_penerimaan_po,
        penerimaan_po.tanggal,
        detail_penerimaan_po.kode_barang as kode_barang,
        penerimaan_po.kode_supplier,        
        penerimaan_po.nama_supplier,
        detail_penerimaan_po.nama_barang as nama_barang,
        detail_penerimaan_po.qty_terima as qty_terima, kode_po
        ");
        
         $this->db->join('detail_penerimaan_po','detail_penerimaan_po.kode_penerimaan_po = penerimaan_po.kode_penerimaan_po');

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

    public function total_terima_perbulan_tahun($bulan,$tahun){
        $total_terima = array();
        $filter = "$bulan"."/".$tahun;
        $this->db->select("
            max(abs(substring_index(kode_penerimaan_po, '/', 1))) as total_terima
        ");
        $this->db->where(" kode_penerimaan_po like '%$filter' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_terima = $atributy->total_terima ;
                
            }

        }
        return $total_terima;

    }

    public function get_kode_by_kode_terima($po, $tanggal){
        $kode_penerimaan_po = array();
        $this->db->select("
            kode_penerimaan_po
        ");
        $this->db->where("kode_po",$po);
        $this->db->where("tanggal",$tanggal);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $kode_penerimaan_po = $atributy->kode_penerimaan_po ;
                
            }

        }
        return $kode_penerimaan_po;
    }

    public function get_by_id_detail($id)
    {

         $this->db->select("
        detail_penerimaan_po.id,
       detail_penerimaan_po.kode_penerimaan_po as kode_penerimaan_po,
        penerimaan_po.tanggal,
        penerimaan_po.kode_po,
        penerimaan_po.nama_supplier,
        kode_barang,
        kode_supplier,
        nama_barang,
        qty_terima,
        qty_return
        ");

        $this->db->join('detail_penerimaan_po','penerimaan_po.kode_penerimaan_po = detail_penerimaan_po.kode_penerimaan_po');
        $this->db->from($this->table);
        $this->db->where('detail_penerimaan_po.id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_by_jatuh_tempo($tanggal, $top)
    {
        $hasil = array();
         $this->db->select("
            DATE_ADD('$tanggal', INTERVAL $top DAY) as hasil
        ");
        $query = $this->db->get($this->table);
        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $hasil = $atributy->hasil ;
                
            }

        }

        return $hasil;
    }


   public function total_qty_terima_perbulan_tahun_barang($bulan,$tahun, $barang){
        $total_terima = array();
        $filter = "$bulan"."/".$tahun;
        $this->db->select("
            sum(qty_terima) as total_terima
        ");
        $this->db->where(" kode_penerimaan_po like '%$filter' ");
        $this->db->where("kode_barang",$barang);
        $query = $this->db->get('penerimaan_po');

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_terima = $atributy->total_terima ;
                
            }

        }
        return $total_terima;

    }

    public function total_kode_po( $kodepo){
        $total_masuk = array();
        $this->db->select("
            sum(qty_terima) as qty 
        ");
        $this->db->where("kode_po",$kodepo);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $qty = $atributy->qty ;
                
            }

        }
        return $qty;

    }



}