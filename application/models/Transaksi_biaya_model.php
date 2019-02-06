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
        
        $this->db->select("kode_referensi as kode_so, nominal, tanggal as tgl_trans");
        $this->db->where(" month(tanggal)='$bulan' and year(tanggal) = '$tahun' and status='Lunas' ");
        $query = $this->db->get($this->table);
        $hasil = $query->result_array();
        $i=1;
        foreach($hasil as $row){
            $row['id_detail_laba_rugi']=$id=md5($bulan.'/'.$tahun.'/biaya/'.$i);
            $row['created_at']=date('Y-m-d H:i:s');
            $row['id_laba_rugi']=$idlabarugi;
            $row['jenis_trans']='biaya';
            $insert = $this->db->insert('detail_laba_rugi', $row);
            $i++;
        }
        return $insert;
    }

}