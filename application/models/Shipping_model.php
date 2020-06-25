<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }

    /*
     * Following functions are added to use with server side datatables
     */

    function allshippingmethods_count() {
        $query = $this->db->get('shipping_methods');
        return $query->num_rows();
    }

    function allshippingmethods($limit, $start, $col, $dir) {
        $this->db->select("*");
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get("shipping_methods");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function shippingmethod_search($limit, $start, $search, $col, $dir) {
        $this->db->select("*");
        $this->db->like('shipping_method_id', $search);
        $this->db->or_like('shipping_method_name', $search);
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get("shipping_methods");


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function shippingmethod_search_count($search) {
        $this->db->select("*");
        $this->db->like('shipping_method_id', $search);
        $this->db->or_like('shipping_method_name', $search);
        $query = $this->db->get("shipping_methods");
        return $query->num_rows();
    }

    function addData($data) {
        $this->db->insert('shipping_methods', $data);
        return true;
    }

    function updateData($data, $shipping_method_id) {
        $this->db->set($data);
        $this->db->where('shipping_method_id', $shipping_method_id);
        $this->db->update('shipping_methods');
        return true;
    }

    function deleteData($shipping_method_id) {
        $this->db->where('shipping_method_id', $shipping_method_id);
        $this->db->delete('shipping_methods');
        return true;
    }

    function getData($shipping_method_id) {
        $this->db->where('shipping_method_id', $shipping_method_id);
        $query = $this->db->get('shipping_methods');
        return $query->row();
    }

    public function get_shipping_rate($order_id, $pick_id, $weight = 0) {
        $tot_weight = $weight;
        //get pin code from seller to buyer
        $ord = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row_array();
        $paddress = $this->Common_model->getAll('seller_pick_address', array('pick_id' => $pick_id))->row_array();

        $buyer_pin = $ord['delivery_postcode'];
        //$seller_pin=$paddress['pincode'];
        $seller_pin = $ord['pick_pincode'];


        $this->db->select("region,edl,distance");
        $this->db->from("shipping_surface");
        $this->db->where('pincode="' . $seller_pin . '" OR  pincode="' . $buyer_pin . '"');
        $query = $this->db->get();
        $region_q = $query->result_array();

        if (count($region_q) == 2) {
            $tot_rate = 0;
            $region1 = $region_q[0]['region'];
            $region2 = $region_q[1]['region'];
            if (!empty($region1) && !empty($region2)) {
                //Get Rate 
                $this->db->select("rate");
                $this->db->from("shipping_vendor_rate_by_weight");
                $this->db->where('zone_from="' . $region1 . '" AND  zone_to="' . $region2 . '"');
                $query = $this->db->get();
                $rate_q = $query->row_array();

                //$tot_rate=$tot_rate + $rate_without_EDL=$rate_q['rate'];
                $tot_rate = $tot_rate + $rate_q['rate'];

                //Check EDL
                if ($region_q[0]['edl'] == 'Y') {
                    $r1_dist = $region_q[0]['distance'];
                    $rate1 = $this->get_EDL_rate($r1_dist, $tot_weight);
                    $tot_rate = $tot_rate + $rate1;
                }

                if ($region_q[1]['edl'] == 'Y') {
                    $r2_dist = $region_q[1]['distance'];
                    $rate2 = $this->get_EDL_rate($r2_dist, $tot_weight);
                    $tot_rate = $tot_rate + $rate2;
                }

                if ($tot_rate <= 500) {
                    return $tot_rate;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    //For Order Return
    public function get_return_shipping_rate($weight = 0, $buyer_pin, $seller_pin) {
        $tot_weight = $weight;



        $this->db->select("region,edl,distance");
        $this->db->from("shipping_surface");
        $this->db->where('pincode="' . $seller_pin . '" OR  pincode="' . $buyer_pin . '"');
        $query = $this->db->get();
        $region_q = $query->result_array();

        if (count($region_q) == 2) {
            $tot_rate = 0;
            $region1 = $region_q[0]['region'];
            $region2 = $region_q[1]['region'];
            if (!empty($region1) && !empty($region2)) {
                //Get Rate 
                $this->db->select("rate");
                $this->db->from("shipping_vendor_rate_by_weight");
                $this->db->where('zone_from="' . $region1 . '" AND  zone_to="' . $region2 . '"');
                $query = $this->db->get();
                $rate_q = $query->row_array();

                //$tot_rate=$tot_rate + $rate_without_EDL=$rate_q['rate'];
                $tot_rate = $tot_rate + $rate_q['rate'];

                //Check EDL
                if ($region_q[0]['edl'] == 'Y') {
                    $r1_dist = $region_q[0]['distance'];
                    $rate1 = $this->get_EDL_rate($r1_dist, $tot_weight);
                    $tot_rate = $tot_rate + $rate1;
                }

                if ($region_q[1]['edl'] == 'Y') {
                    $r2_dist = $region_q[1]['distance'];
                    $rate2 = $this->get_EDL_rate($r2_dist, $tot_weight);
                    $tot_rate = $tot_rate + $rate2;
                }


                return $tot_rate;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function get_shipping_rate_approx($seller_pin, $buyer_pin) {

        $this->db->select("region,edl,distance");
        $this->db->from("shipping_surface");
        $this->db->where('pincode="' . $seller_pin . '"');
        $query1 = $this->db->get();
        $region_q1 = $query1->row_array();
       
        $this->db->select("region,edl,distance");
        $this->db->from("shipping_surface");
        $this->db->where('pincode="' . $buyer_pin . '"');
        $query2 = $this->db->get();
        $region_q2 = $query2->row_array();
 
        if ((!empty($region_q1)) && (!empty($region_q2))) {
           
           $tot_rate = 0;
           $region1 = $region_q1['region'];
            
           $region2 = $region_q2['region'];
            if (!empty($region1) && !empty($region2)) {
                //Get Rate 
                $this->db->select("rate");
                $this->db->from("shipping_vendor_rate_by_weight");
                $this->db->where('zone_from="' . $region1 . '" AND  zone_to="' . $region2 . '"');
                $query = $this->db->get();
                $rate_q = $query->row_array();
               
                //$tot_rate=$tot_rate + $rate_without_EDL=$rate_q['rate'];
               $tot_rate = $tot_rate + $rate_q['rate'];

                //Check EDL
                if ($region_q1['edl'] == 'Y') {
                    $r1_dist = $region_q1['distance'];
                    $rate1 = $this->get_EDL_rate($r1_dist, $tot_weight);
                    $tot_rate = $tot_rate + $rate1;

                    //for check edl
                    $tot_rate = 0;
                }

                if ($region_q2['edl'] == 'Y') {
                    $r2_dist = $region_q2['distance'];
                    $rate2 = $this->get_EDL_rate($r2_dist, $tot_weight);
                    $tot_rate = $tot_rate + $rate2;

                    //for check edl
                    $tot_rate = 0;
                }
                return $tot_rate;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function get_EDL_rate($dist, $weight) {
        if ($weight > 1500) {
            $cal_rate = $weight * 10;
            if ($cal_rate > 10000) {
                return $cal_rate;
            } else {
                return 10000;
            }
        } else {
            $this->db->select("rate");
            $this->db->from("shipping_vendor_rate_by_distance");
            $this->db->where('"' . $dist . '"  between distance_from AND distance_to');
            $this->db->where('"' . $weight . '"  between kg_from AND kg_to');
            $query = $this->db->get();
            $rate_q = $query->row_array();
            $rate = $rate_q['rate'];
            if ($rate > 0) {
                return $rate;
            } else {
                return 0;
            }
        }
    }

    function get_seller_area($pick_id = 0) {
        $paddress = $this->Common_model->getAll('seller_pick_address', array('pick_id' => $pick_id))->row_array();

        $seller_pin = $paddress['pincode'];

        $this->db->select("area");
        $this->db->from("shipping_surface");
        $this->db->where('pincode="' . $seller_pin . '"');
        $this->db->where('edl!=', 'Y');
        $query = $this->db->get();
        return $region_q = $query->row_array();
    }

    function get_buyer_area($pincode = 0) {//Get area by passing Pincode 
        $this->db->select("area");
        $this->db->from("shipping_surface");
        $this->db->where('pincode="' . $pincode . '"');
        $this->db->where('edl!=', 'Y');
        $query = $this->db->get();
        return $region_q = $query->row_array();
    }

    function get_qty_wise_product_rate($product_id, $qty = 0) {
        $this->db->select("final_price");
        $this->db->from("product_price");
        $this->db->where('"' . $qty . '"  between quantity_from AND quantity_upto');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        $rate_q = $query->row_array();
        $price = $rate_q['final_price'];
        if ($price > 0) {
            return $price;
        } else {
            return 0;
        }
    }

    /**
     * @auther Yogesh Pardeshi 26082019 1051am
     * @param $product_id = product id pk, $qty = total quantity for order product
     * @return $atz_price for product from table as offer is running
     * @use start order page from Userorder controller
     * */
    function get_qty_wise_product_offer_rate($product_id, $qty = 0) {
        $this->db->select("atz_price");
        $this->db->from("product_price");
        $this->db->where('"' . $qty . '"  between quantity_from AND quantity_upto');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        $rate_q = $query->row_array();
        $price = $rate_q['atz_price'];
        if ($price > 0) {
            return $price;
        } else {
            return 0;
        }
    }

}
