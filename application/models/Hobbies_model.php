<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hobbies_model extends MY_Model
{
    public $table = 'hobbies';
    public $primary_key = 'id';
    public function __construct()
    {
        parent::__construct();

    }

    public function getDataHobbies($customerId){
        $data = array();
        $this->db->select("id,customer_id,hobbies");
        $this->db->where('customer_id',$customerId);
        $query = $this->db->get('hobbies');

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data[] = array(
                    'id' => $atributy->id,
                    'customer_id' => $atributy->customer_id,
                    'hobbies' => $atributy->hobbies
                );
            }

        }
        return $data;

    }



}