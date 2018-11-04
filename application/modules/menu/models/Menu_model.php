<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends MY_Model
{
    public $table = 'menus';
    public $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }




}