<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Model_menu extends CI_Model {

function __construct() {
    parent::__construct();

    $this->tableName = 'permissions';
}


    function get_items() {
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where('parent_id', '0');
        $this->db->order_by('parent_id');
        $this->db->order_by('sequence');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->result_array();
    }

    function get_parent($id){
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where('id', $id);
        $this->db->order_by('sequence');
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_sub($id) {
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where('parent_id', $id);
        $this->db->where_not_in('parent_id', array('0'));
        $this->db->order_by('sequence');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->result_array();
    }

    function get_sub_count($id) {
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where('parent_id', $id);
        $this->db->order_by('sequence');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->num_rows();
    }


    function generateTree($items = array(), $parent_id = 0){
        $tree = '<ul id="menu" class="menu">';

        for($i=0, $ni=count($items); $i < $ni; $i++){
            if($items[$i]['parent_id'] == $parent_id){

                $pId = $items[$i]['id'];
                $parents = $this->get_parent($pId);

                $tree .= '<li>';

                $parents_sub = $this->get_sub_count($pId);
                // tesx($parents_sub);

                if($parents_sub == 0){
                    $tree .= '<a href="'.base_url($parents['link']).'" >
                            <i data-acorn-icon="'.$parents['icon'].'" class="icon" data-acorn-size="18"></i>';

                }else{
                    $tree .= '<a href="#menu-'.$parents['id'].'" data-href="'.base_url($parents['link']).'" >
                            <i data-acorn-icon="'.$parents['icon'].'" class="icon" data-acorn-size="18"></i>';
                }

                $tree .= '<span class="label">'.$parents['display_name'].'</span></a>';

                        $subtree = $this->get_sub($pId);
                        if($subtree==TRUE){
                            $tree .= '<ul id="menu-'.$parents['id'].'">';
                                foreach($subtree as $sub){
                                    $tree .= '<li><a href="'.base_url($sub['link']).'">';
                                    $tree .= '<span class="label">'.$sub['display_name'].'</span></a>';
                                    $tree .= '</li>';
                                }
                            $tree .= '</ul>';
                        }

                $tree .= '</li>';
            }
        }
        $tree .= '</ul>';
        return $tree;
    }


} // End of Model Class
