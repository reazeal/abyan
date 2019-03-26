<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Piutang_model extends MY_Model
{
    public $table = 'piutang';
    public $primary_key = 'id';
    public $column_order = array(null, 'id','kode_piutang', 'kode_referensi','kode_relasi','nama_relasi','jenis','nominal','tanggal','tanggal_jatuh_tempo',null);
    public $column_search = array('kode_piutang', 'kode_referensi','kode_relasi','nama_relasi','jenis','nominal','tanggal','tanggal_jatuh_tempo');
    public $order = array('tanggal_jatuh_tempo' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //$this->db->group_by('kode');
       // $this->db->order_by('tanggal_jatuh_tempo','asc');
        $this->db->where('status','Belum Lunas');
        $this->db->from('piutang');
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
        //$this->db->update($this->table,array("upload_rate"=>0,"download_rate"=>0));
    }

    public function delete_by_id($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
    }

    public function update_by_kode($kode, $data)
    {
        $this->db->where('kode_piutang',$kode);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
        //$this->db->update($this->table,array("upload_rate"=>0,"download_rate"=>0));
    }


    public function total_piutang_perbulan_tahun($bulan,$tahun){
        $total_piutang = array();
        $filter = "$bulan"."/".$tahun;
        $this->db->select("
            ifnull(max(abs(substring_index(kode_piutang, '/', 1))),0) as total_piutang
        ");
        $this->db->where(" kode_piutang like '%$filter' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_piutang = $atributy->total_piutang ;
                
            }

        }
        return $total_piutang;

    }

    public function get_piutang_by_kode_kirim($kode_kirim){

         $this->db->select("
            kode_piutang, nominal, kode_bantu
        ");

        $this->db->from($this->table);
        $this->db->where("kode_referensi",$kode_kirim);
      //  $this->db->where("tanggal",$tanggal);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_piutang_sekarang(){
        //$this->db->select("ifnull(sum(p.nominal),0)-sum(ifnull(pp.nominal,0)) as nominalpiutang");
        $this->db->select("ifnull(sum(p.nominal),0) as nominalpiutang");
        $this->db->from($this->table.' p');
        //$this->db->join('pembayaran_piutang pp','p.kode_piutang=pp.kode_piutang','left');
        $this->db->where("status = 'Belum Lunas'");
        //$this->db->group_by("p.kode_piutang");
        $this->db->having("nominalpiutang <> 0");
        $query = $this->db->get();
        
        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            
            return $query->row()->nominalpiutang;

        }else{
            return '0';
        }

//        return $query->row()->nominalpiutang;
        //return '0';
    }
}