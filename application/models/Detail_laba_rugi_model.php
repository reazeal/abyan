<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_laba_rugi_model extends MY_Model
{
    public $table = 'detail_laba_rugi';
    public $primary_key = 'id_laba_rugi';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function delete_by_id_laba_rugi($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
    }
    
    public function getDataByIDLabaRugi($id){
        $data = array();
        $this->db->where('id_laba_rugi',$id);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            $i=1;
            foreach ($query->result() as $atributy) {
                $data[] = array(
                'no' => $i,
                'kode_so' => $atributy->kode_so,
                'jenis_trans' => $atributy->jenis_trans,
                'nominal' => $atributy->nominal,
                'tgl_trans' => $atributy->tgl_trans,
                );
                $i++;
            }

        }
        return $data;

    }

}