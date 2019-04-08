<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Komisi_model extends MY_Model
{
    public $table = 'komisi';
    public $primary_key = 'id';
    public $column_order = array(null, 'k.id', 'periode','jenis_komisi','nama_pegawai','nominal',null);
    public $column_search = array('periode','jenis_komisi','nama_pegawai','nominal');
    public $order = array('tanggal' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //$this->db->group_by('kode');
        //$this->db->order_by('tanggal','desc');
        $this->db->select("k.id, periode, jenis_komisi, nama_pegawai, sum(nominal) as nominal");
        $this->db->join('laba_rugi a','a.id = k.id_laba_rugi');
        $this->db->join('pegawai b','b.kode_pegawai = k.kode_pegawai');
        $this->db->group_by('id_laba_rugi,jenis_komisi,k.kode_pegawai');
        $this->db->from('komisi k');
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
        $this->db->where('id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function delete_by_id_laba_rugi($id)
    {
        $this->db->where('id_laba_rugi', $id);
        $this->db->delete($this->table);
    }
    
    public function getDataByIDLabaRugi($id){
        $data = array();
        $this->db->select("sum(nominal) as nominal");
        $this->db->where('id_laba_rugi',$id);
        $this->db->group_by('id_laba_rugi');
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            $i=1;
            foreach ($query->result() as $atributy) {
               //$data = $atributy->nominal ;
                return $atributy->nominal;
            }

        }else{
            return '0';    
        }
        

    }

    public function getDataByIDLabaRugiByJenis($id_laba_rugi, $jenis, $kode_pegawai){
        $data = array();
        $this->db->select('jenis_komisi, nama_pegawai, komisi.kode_so, nominal, sales_order.tanggal, komisi.nama_barang, komisi.qty');
        $this->db->where('jenis_komisi',$jenis);
        $this->db->where('id_laba_rugi',$id_laba_rugi);
        $this->db->where('pegawai.kode_pegawai',$kode_pegawai);
        $this->db->join('pegawai','pegawai.kode_pegawai = komisi.kode_pegawai');
        $this->db->join('sales_order','sales_order.kode_so = komisi.kode_so');
        $this->db->join('detail_so','sales_order.kode_so = detail_so.kode_so and and detail_so.nama_barang = komisi.nama_barang');
        //$this->db->limit(2);
        //$this->db->order_by('sales_order.tanggal','asc');
        $this->db->order_by('sales_order.tanggal','asc');
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            $i=1;
            foreach ($query->result() as $atributy) {
                $data[] = array(
                'no' => $i,
                'jenis_komisi' => $atributy->jenis_komisi,
                'nominal' => number_format((($atributy->nominal)?$atributy->nominal:'0'),0,",","."),
                'kode_so' => $atributy->kode_so,
                'kode_pegawai' => $atributy->nama_pegawai,
                'tanggal' => $atributy->tanggal,
                'nama_barang' => $atributy->nama_barang,
                'qty' => $atributy->qty,
                );
                $i++;
            }

        }
        return $data;

    }

}