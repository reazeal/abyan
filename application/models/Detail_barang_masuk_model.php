<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_barang_masuk_model extends MY_Model
{
    public $table = 'detail_barang_masuk';
    public $primary_key = 'id';
    //public $column_order = array(null, 'id','nomor_invoice','nama_barang','qty','',null);
    //public $column_search = array('id','tanggal','nomor_invoice','keterangan');
    public $order = array('id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
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


    public function delete_by_id($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
    }

    public function delete_by_no_bukti($no_bukti)
    {
        $this->db->where('no_bukti', $no_bukti);
        $this->db->delete($this->table);
    }

   

    public function update_by_id($id, $data)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function total_masuk_pertahun(){
        $total_masuk_pertahun = array();
        $tahun = date('Y');
        $this->db->select("
            -- ifnull(round(sum(qty) / 1000,1),0) as total_masuk
            ifnull(sum(qty),0)  as total_masuk
        ");
        $this->db->where("tanggal like '%$tahun%' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_masuk_pertahun = $atributy->total_masuk ;
                
            }

        }
        return $total_masuk_pertahun;

    }

   public function total_perbarang_kode_po($kodebarang, $kodepo){
        $total_masuk = array();
        $this->db->select("
            sum(qty) as qty 
        ");
        $this->db->where("nomor_referensi",$kodepo);
        $this->db->where("kode_barang",$kodebarang);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $qty = $atributy->qty ;
                
            }

        }
        return $qty;

    }

    public function getDataByTransaksi($id){
        $data = array();
        $this->db->select("detail_barang_masuk.id as id, detail_barang_masuk.kode_barang_masuk as kode_barang_masuk, detail_barang_masuk.kode_barang as kode_barang, detail_barang_masuk.nama_barang as nama_barang, detail_barang_masuk.qty as qty, detail_barang_masuk.nomor_referensi as nomor_referensi");
        $this->db->join('barang_masuk','barang_masuk.kode_barang_masuk = detail_barang_masuk.kode_barang_masuk');
        $this->db->where('barang_masuk.id',$id);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                    $data[] = array(
                    'id' => $atributy->id,
                    'kode_barang_masuk' => $atributy->kode_barang_masuk,
                    'kode_barang' => $atributy->kode_barang,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                    'nomor_referensi' => $atributy->nomor_referensi,
                    
                );
                
            }

        }
        return $data;

    }

    public function get_by_penerimaan(){
        $data = array();
        $this->db->select('detail_barang_masuk.kode_barang, detail_barang_masuk.id, detail_barang_masuk.nama_barang, barang_masuk.tanggal');
        $this->db->join('barang_masuk','detail_barang_masuk.kode_barang_masuk = barang_masuk.kode_barang_masuk');
        $this->db->where('detail_barang_masuk.qty != detail_barang_masuk.keluar ');
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        //return $query->row();
        return $query->result();
        
       
    }

    public function get_qty_keluar($id)
    {
        $this->db->select('keluar');
        $this->db->from($this->table);

        $this->db->where('id',$id);
        $query = $this->db->get();

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $keluar = $atributy->keluar ;
                
            }

        }
        return $keluar;
    }

}