<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order_model extends MY_Model
{
    public $table = 'purchase_order';
    public $primary_key = 'id';
    public $column_order = array(null, 'id','tanggal','kode_po','kode_supplier','nama_supplier',null);
    public $column_search = array('tanggal','purchase_order.kode_po','kode_supplier','nama_supplier');
    public $order = array('purchase_order.created_at' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        /*
        $this->db->select("
        purchase_order.id as id, detail_po.kode_po as kode_po, nama_supplier, kode_supplier, nama_barang, kode_barang, tanggal, qty, harga, status, detail_po.id as id_detail, concat(ifnull(top,0),' Hari') as top
        ");

        $this->db->join('detail_po','detail_po.kode_po=purchase_order.kode_po');
        */
      //  $this->db->order_by('tanggal','desc');
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

    public function get_by_id_detail($id)
    {

         $this->db->select("
            purchase_order.id as id_po,
        detail_po.id,
        purchase_order.tanggal,
        purchase_order.kode_po,
        purchase_order.nama_supplier,
        kode_barang,
        kode_supplier,
        nama_barang,
        qty, harga, top, bottom_retail, bottom_supplier
        ");

        $this->db->join('detail_po','purchase_order.kode_po = detail_po.kode_po');
        $this->db->from($this->table);
        $this->db->where('detail_po.id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_by_id_po($idPO)
    {

        $this->db->from($this->table);
        $this->db->where('id',$idPO);
        $query = $this->db->get();

        return $query->row();
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

    public function total_po_perbulan_tahun($bulan,$tahun){
        $total_masuk = array();
        $filter = "$bulan"."/".$tahun;
        $this->db->select("
            max(abs(substring_index(kode_po, '/', 1))) as total_po
        ");
        $this->db->where(" kode_po like '%$filter' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_po = $atributy->total_po ;
                
            }

        }
        return $total_po;

    }

    public function update_by_kode_barang($kode_po, $kode_barang, $data)
    {
        $this->db->where('kode_po',$kode_po);
        $this->db->where('kode_barang',$kode_barang);
        $this->db->update('detail_po', $data);
        return $this->db->affected_rows();
        //$this->db->update($this->table,array("upload_rate"=>0,"download_rate"=>0));
    }

    public function update_by_kode_po($kode_po, $data)
    {
        $this->db->where('kode_po',$kode_po);
        $this->db->update('purchase_order', $data);
        return $this->db->affected_rows();
        //$this->db->update($this->table,array("upload_rate"=>0,"download_rate"=>0));
    }




}