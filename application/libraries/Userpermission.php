<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Userpermission 
{

    function __construct() 
    {
        $CI = & get_instance();

		if($CI->uri->segment(2))
		{
			//controller Name
			$get_class = $CI->uri->segment(2);
		}
		
		if($CI->uri->segment(3)!='')
		{
			//Function Name
			$get_class=$CI->uri->segment(2).'/'.$CI->uri->segment(3);
		}
		
		
        $user_id = $CI->session->userdata('admin_id');
		
        //Check Permission
        $CI->db->select('a.menu_id');
        $CI->db->from('user_permission as a');
        $CI->db->join('menu_master as b', 'a.menu_id=b.menu_id AND b.slink="' . trim($get_class) . '"');
        $CI->db->where('a.user_id="' . $user_id . '" AND a.view=0'); 
        $CI->db->order_by('a.menu_id');
        $query = $CI->db->get();
		
		
        if ($query->num_rows() > 1) {
			
          redirect('admin/nopermission','refresh'); 
        }
    }
	
	

    function user_per() 
    {
        $CI = & get_instance();
        $user_id = $CI->session->userdata('admin_id');

        $CI->db->select('*');
        $CI->db->from('user_permission as a');
        $CI->db->join('menu_master as b', 'a.menu_id=b.menu_id AND b.parent_id=0');
        $CI->db->where('a.user_id="' . $user_id . '" AND a.view=1 AND a.sidebar=1');
        $CI->db->order_by('b.sort_by');
        $CI->db->order_by('a.menu_id');
        $query = $CI->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function user_per_sub_menu($mid) {
        $CI = & get_instance();
        $user_id = $CI->session->userdata('admin_id');

        $CI->db->select('*');
        $CI->db->from('user_permission as a');
        $CI->db->join('menu_master as b', 'b.parent_id=' . $mid . ' AND a.menu_id=b.menu_id');
        $CI->db->where('a.user_id="' . $user_id . '" AND a.view=1 AND a.sidebar=1');
        $CI->db->order_by('b.sort_by');
        $CI->db->order_by('a.menu_id');
        $query1 = $CI->db->get();
        if ($query1->num_rows() > 0) {
            return $query1->result_array();
        } else {
            return null;
        }
    }
    
    public function menus() 
    {
        $CI = & get_instance();
        $user_id = $CI->session->userdata('admin_id');
        $CI->db->from("user_permission a");
        $CI->db->join("menu_master b","b.menu_id = a.menu_id");
        $CI->db->where([
            "a.user_id" => $user_id,
            "a.view" => 1,
            "a.sidebar" => 1,
            "b.parent_id" => 0,
        ]);
        $CI->db->order_by('b.sort_by');
        $CI->db->order_by('a.menu_id');
        $q = $CI->db->get();
        
        $final = array();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                if($row->menu_name == "Products"){
                    $CI->db->select("COUNT(id) total");
                    $CI->db->from("product_details");
                    $CI->db->where("publish_status != 'initiated'");
                    $cnt = $CI->db->get()->row();
                    $row->count = $cnt->total;
                }
                $CI->db->from("user_permission a");
                $CI->db->join("menu_master b","b.menu_id = a.menu_id");
                $CI->db->where([
                    "a.user_id" => $user_id,
                    "a.view" => 1,
                    "a.sidebar" => 1,
                    "b.parent_id" => $row->menu_id,
                ]);
                $q = $CI->db->get();
                if ($q->num_rows() > 0) {
                    $row->children = $q->result();
                    foreach($row->children as $row2):
                        //for orders
                        if($row2->menu_name == "All Orders"){
                            $CI->db->select("COUNT(orders_id) total");
                            $CI->db->from("orders");
                            $CI->db->where("date(date_purchased)",date('Y-m-d'));
                            $CI->db->where("orders_status!=8");
                            $cnt = $CI->db->get()->row();
                            $row2->count = $cnt->total;
                        }
                        if($row2->menu_name == "Completed Orders"){
                            $CI->db->select("COUNT(orders_id) total");
                            $CI->db->from("orders");
                            $CI->db->where("date(date_purchased)",date('Y-m-d'));
                            $CI->db->where("orders_status=4");
                            $cnt = $CI->db->get()->row();
                            $row2->count = $cnt->total;
                        }
                        if($row2->menu_name == "Unpaid Orders"){
                            $CI->db->select("COUNT(orders_id) total");
                            $CI->db->from("orders");
                            $CI->db->where("date(date_purchased)",date('Y-m-d'));
                            $CI->db->where("orders_status=8");
                            $cnt = $CI->db->get()->row();
                            $row2->count = $cnt->total;
                        }
                        if($row2->menu_name == "Cancelled Orders"){
                            $CI->db->select("COUNT(orders_id) total");
                            $CI->db->from("orders");
                            $CI->db->where("date(date_purchased)",date('Y-m-d'));
                             $CI->db->group_start();
                            $CI->db->where("orders_status=1");
                            $CI->db->or_where("orders_status=25");
                             $CI->db->group_end();
                            $cnt = $CI->db->get()->row();
                            $row2->count = $cnt->total;
                        }
                        if($row2->menu_name == "Return Orders"){
                            $CI->db->select("COUNT(orders_id) total");
                            $CI->db->from("orders");
                            $CI->db->where("date(date_purchased)",date('Y-m-d'));
                             $CI->db->group_start();
                            $CI->db->where("orders_status=23");
                            $CI->db->or_where("orders_status=24");
                            $CI->db->or_where("orders_status=13");
                             $CI->db->group_end();
                            $cnt = $CI->db->get()->row();
                            $row2->count = $cnt->total;
                        }
                        
                        //for Products
                        if($row2->menu_name == "Approved Products"){
                            $CI->db->select("COUNT(id) total");
                            $CI->db->from("product_details");
                            $CI->db->where("publish_status","approved");
                            $cnt = $CI->db->get()->row();
                            $row2->count = $cnt->total;
                        }
                        if($row2->menu_name == "Pending Approval"){
                            $CI->db->select("COUNT(id) total");
                            $CI->db->from("product_details");
                            $CI->db->where("publish_status","requested");
                            $cnt = $CI->db->get()->row();
                            $row2->count = $cnt->total;
                        }
                        if($row2->menu_name == "Rejected Products"){
                            $CI->db->select("COUNT(id) total");
                            $CI->db->from("product_details");
                            $CI->db->where("publish_status","rejected");
                            $cnt = $CI->db->get()->row();
                            $row2->count = $cnt->total;
                        }
                    endforeach;
                }
                array_push($final, $row);
            }
        }
        return $final;
    }

}

?>