<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Companytype_model extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

    public function addCompanyData($company_type_data) 
    {
        $this->db->insert('company_types', $company_type_data);
        return $this->db->insert_id();
    }

    public function updateCompanyData($company_type_data, $id) 
    {
        $this->db->set($company_type_data);
        $this->db->where('id', $id);
        $query = $this->db->update('company_types');
        return true;
    }

    public function getCompanyTypeData($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('company_types');
        return $query->row();
    }

    public function deleteCompanyData($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('company_types');
        return true;
    }

    /*
     * Following functions are added to use with server side datatables
     */

    public function getAll() 
    {
        $query = $this->db->get('company_types');
        return $query->result();
    }

    function allcompany_count() 
    {
        $query = $this
                ->db
                ->get('company_types');

        return $query->num_rows();
    }

    function allcompany($limit, $start, $col, $dir) 
    {
        $query = $this
                ->db
                ->select("*")
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get("company_types");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function company_search($limit, $start, $search, $col, $dir) 
    {
        $query = $this
                ->db
                ->select("id,name,date_added,date_modified")
                ->like('id', $search)
                ->or_like('name', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get("company_types");


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function company_search_count($search) 
    {
        $query = $this
                ->db
                ->like('id', $search)
                ->or_like('name', $search)
                ->get("company_types");

        return $query->num_rows();
    }

}
