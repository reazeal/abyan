<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  ion_auth $ion_auth
 */
class MY_Controller extends CI_Controller
{
    protected $data = array();
	protected $data_content = array();
	function __construct()
	{
		parent::__construct();
        $this->data['site_title'] = $this->config->item("site_title");
        $this->data['site_dev'] = $this->config->item("site_dev");
        $this->data['site_description'] = $this->config->item("site_description");
        $this->data['copyright'] = $this->config->item("copyright");
        $this->data['credit'] = $this->config->item("credit");
        $this->data['menu_data'] = array('master' =>false,'transaksi'=>false,'dashboard'=>false,'cetakan'=>false);
	}

	protected function render($the_view = NULL, $template = 'admin')
	{
		if($template == 'json' || $this->input->is_ajax_request())
		{
			header('Content-Type: application/json');
			echo json_encode($this->data);
		}
		elseif(is_null($template))
		{
			$this->load->view($the_view,$this->data);
		}
		else
		{
			$this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $this->data, TRUE);
			$this->load->view('templates/' . $template . '_view', $this->data);
		}
	}

    function get_nama_bulan_id($a) {
        if ($a == 1)
            $b = 'Januari';
        elseif ($a == 2)
            $b = 'Pebruari';
        elseif ($a == 3)
            $b = 'Maret';
        elseif ($a == 4)
            $b = 'April';
        elseif ($a == 5)
            $b = 'Mei';
        elseif ($a == 6)
            $b = 'Juni';
        elseif ($a == 7)
            $b = 'Juli';
        elseif ($a == 8)
            $b = 'Agustus';
        elseif ($a == 9)
            $b = 'September';
        elseif ($a == 10)
            $b = 'Oktober';
        elseif ($a == 11)
            $b = 'Nopember';
        else
            $b = 'Desember';
        return $b;
    }

    function terbilang($x)
    {
        $bil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($x < 12)
            return " " . $bil[$x];
        elseif ($x < 20)
            return $this->terbilang($x - 10) . " belas";
        elseif ($x < 100)
            return $this->terbilang($x / 10) . " puluh" . $this->terbilang($x % 10);
        elseif ($x < 200)
            return " seratus" . $this->terbilang($x - 100);
        elseif ($x < 1000)
            return $this->terbilang($x / 100) . " ratus" . $this->terbilang($x % 100);
        elseif ($x < 2000)
            return " seribu" . $this->terbilang($x - 1000);
        elseif ($x < 1000000)
            return $this->terbilang($x / 1000) . " ribu" . $this->terbilang($x % 1000);
        elseif ($x < 1000000000)
            return $this->terbilang($x / 1000000) . " juta" . $this->terbilang($x % 1000000);
        else
            return " " . $bil[$x];
    }

    function get_nm_hr($a) {
	    $b ="";

        if ($a == 'Wed')
            $b = 'RB';
        elseif ($a == 'Thu')
            $b = 'KM';
        elseif ($a == 'Fri')
            $b = 'JM';
        elseif ($a == 'Sat')
            $b = 'SB';
        elseif ($a == 'Sun')
            $b = 'MG';
        elseif ($a == 'Mon')
            $b = 'SN';
        elseif ($a == 'Tue')
            $b = 'SL';
        return $b;
    }

    //Mengubah format tanggal dari database ke format tgl-bln-thn
    function tanggal($tgl){
	     if(!empty($tgl)){
            $tgl=explode(" ",$tgl);
            $tgl=explode("-",$tgl[0]);
            return $tgl[2]."-".$tgl[1]."-".$tgl[0];
        }else {
            return "-";
        }
    }

    //Mengubah format tanggal dari format tgl-bln-thn ke database
    function tanggaldb($tgl){
        if(!empty($tgl)){
            $tgl=explode("-",$tgl);
            return $tgl[2]."-".$tgl[1]."-".$tgl[0];
        }else{
            return "0000-00-00";
        }

    }

    function pemisah_ribuan($angka){
        if(!empty($angka)){
            $ribuan = number_format((($angka)?$angka:'0'),0,",",".");
            return $ribuan;
        }else{
            return "0";
        }

    }
    
}

/**
 * @property  ion_auth $ion_auth
 */
class Admin_Controller extends MY_Controller
{
	public $data_content = array();
	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->helper('url');
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
        $current_user = $this->ion_auth->user()->row();
        $this->user_id = $current_user->id;
		$this->data['current_user'] = $current_user;
		$this->data['current_user_menu'] = '';
		$this->data['username_auth'] = $current_user->username;
		$this->data['firstname_auth'] = $current_user->first_name;
		$this->data['lastname_auth'] = $current_user->last_name;

	}
	protected function render($the_view = NULL, $template = 'admin')
	{
		parent::render($the_view, $template);
	}
}

class Public_Controller extends MY_Controller
{
	public $data_content = array();
	public $data_content_blog = array();
    function __construct()
	{
        parent::__construct();
	}

    protected function render($the_view = NULL, $template = 'public')
    {
        //$this->load->library('menus');
        //$this->data['top_menu'] = $this->menus->get_menu('top-menu',$this->current_lang,'bootstrap_menu');
        parent::render($the_view, $template);
    }


}
