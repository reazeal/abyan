<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Komisi_model extends MY_Model
{
    public $table = 'komisi';
    public $primary_key = 'id';
    
    public function __construct()
    {
        parent::__construct();
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

}