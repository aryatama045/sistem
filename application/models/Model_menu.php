<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Model_menu extends CI_Model {

function __construct() {
    parent::__construct();

    $this->tableName = 'permissions';

    $this->load->library('auth');
}


    function get_items() {
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where('parent_id', '0');
        $this->db->order_by('parent_id');
        $this->db->order_by('sequence ASC');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->result_array();
    }

    function get_parent($id){
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where('id', $id);
        $this->db->order_by('sequence ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_sub($id) {
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where('parent_id', $id);
        $this->db->where_not_in('parent_id', array('0'));
        $this->db->order_by('sequence ASC');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->result_array();
    }

    function get_sub_count($id) {
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where('parent_id', $id);
        $this->db->order_by('sequence ASC');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->num_rows();
    }

    function get_permission() {
        $this->db->select('*');
        $this->db->from('permission');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->result_array();
    }

    function get_permission_roles($id) {
        $this->db->select('permission_id');
        $this->db->from('permission_roles');
        $this->db->where('role_id', $id);
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->result_array();
    }


    function generateTree($parent_id = 0)
    {
        $items = $this->Model_menu->get_items();

        $user_session = $this->session->userdata('roles');

        $permission = $this->get_permission_roles($user_session['0'] ?? '');

        $log_perm = array();
        foreach($permission as $k=>$v) {
            $res = $v['permission_id'];
            array_push($log_perm, $res);
        }


        $tree = '<ul id="menu" class="menu">';

        for($i=0, $ni=count($items); $i < $ni; $i++){

            $idMenu = $items[$i]['id'];

            $headmenucheck = $this->menu_cek($log_perm, $idMenu);

            if($headmenucheck == TRUE){

                if($items[$i]['parent_id'] == $parent_id){

                    $pId = $items[$i]['id'];
                    $parents = $this->get_parent($pId);

                    $tree .= '<li >';

                    $parents_sub = $this->get_sub_count($pId);

                    $urlm = $this->uri->segment(1);

                    if($urlm == $parents['link'])
                        $activem = "active";
                    else
                        $activem = "";

                    if($parents_sub == 0){
                        $tree .= '<a href="'.base_url($parents['link']).'" class="'.$activem.'">
                                <i data-acorn-icon="'.$parents['icon'].'" class="icon" data-acorn-size="18"></i>';

                    }else{

                        $tree .= '<a href="#menu-'.$parents['id'].'" class="'.$activem.'" data-href="'.base_url($parents['link']).'" >
                                <i data-acorn-icon="'.$parents['icon'].'" class="icon" data-acorn-size="18"></i>';
                    }

                    $tree .= '<span class="label">'.$parents['display_name'].'</span></a>';


                        $subtree = $this->get_sub($pId);

                        /**  This subtree */
                        if($subtree==TRUE){
                            $tree .= '<ul id="menu-'.$parents['id'].'">';
                                foreach($subtree as $sub){

                                    $subId = $sub['id'];

                                    $submenucheck = $this->menu_cek($log_perm, $subId);

                                    if($submenucheck == TRUE){

                                        $url = curl();
                                        $url1 = $this->uri->segment(1);
                                        $url2 = $this->uri->segment(2);

                                        $surl = $url1.'/'.$url2;

                                        if($url == $sub['link'] || $surl == $sub['link'])
                                            $active = "active";
                                        else
                                            $active = "";

                                        $tree .= '<li ><a href="'.base_url($sub['link']).'" class="'.$active.'">';
                                        $tree .= '<span class="label">'.$sub['display_name'].'</span></a>';
                                        $tree .= '</li>';

                                    }

                                }
                            $tree .= '</ul>';
                        }
                        /**  This subtree */

                    $tree .= '</li>';

                }

            }

        }

        $tree .= '</ul>';
        return $tree;
    }


    function menu_cek($array, $id)
	{

		$array = array_values($array);// get value

        $cek = array();
        foreach($array as $val){

            // tesx($val, $id);

            if($val == $id)
            {
                // Array has
                return TRUE;
            }
            array_push($cek, $id);

        }

        // tesx($cek);
	}


} // End of Model Class
