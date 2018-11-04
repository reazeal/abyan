<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: hqeem
 * Date: 5/31/2017
 * Time: 1:14 PM
 */


/**
 * @property  ion_auth $ion_auth
 * @property  menu_model $menu_model
 */
class Menu extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->in_group('admin')) {
            redirect('auth/session_not_authorized', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->model('menu_model');
        $this->load->helper('text');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->render('admin/dashboard_view');
    }

    public function coba()
    {
        $data = $this->menu_model->order_by(array('urutan'=>'ASC'))->get_all(array('parent_id'=>0));
        $html = $this->html_ordered_menu($data,0);
        echo $html;
    }


    function ordered_menu($array,$parent_id = 0)
    {
        $temp_array = array();
        foreach($array as $element)
        {
            if($element->parent_id==$parent_id)
            {
                $element->subs = $this->ordered_menu($array,$element->id);
                $temp_array[] = $element;
            }
        }
        return $temp_array;
    }

    function html_ordered_menu($array,$parent_id = 0)
    {
        $menu_html = '<ul>';
        if(!empty($array)){
            foreach($array as $element)
            {
                if($element->parent_id==$parent_id)
                {
                    $menu_html .= '<li><a href="'.$element->url.'">'.$element->nama_menu.'</a>';
                    $sub_menus= $this->menu_model->order_by(array('urutan'=>'ASC'))->get_all(array('parent_id'=>$element->id));
                    if(!empty($sub_menus)){
                        $menu_html .= '<ul>';
                        foreach($sub_menus as $x)
                        {
                            $menu_html .= '<li><a href="'.$x->url.'">'.$x->nama_menu.'</a>';

                            $sub_menus2= $this->menu_model->order_by(array('urutan'=>'ASC'))->get_all(array('parent_id'=>$x->id));
                            if(!empty($sub_menus2)){
                                $menu_html .= '<ul>';
                                foreach($sub_menus2 as $y)
                                {
                                    $menu_html .= '<li><a href="'.$y->url.'">'.$y->nama_menu.'</a>';
                                }
                                $menu_html .= '</ul>';
                            }

                            $menu_html .= '</li>';
                        }
                        $menu_html .= '</ul>';
                    }

                    $menu_html .= '</li>';
                }
            }
        }else{
            $menu_html .= '<li>Tidak ada menu';
            $menu_html .= '</li>';
        }

        $menu_html .= '</ul>';
        return $menu_html;
    }

}