<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Apks_model extends CI_Model
{
    public $_table;
    public function __construct() 
    {
        parent::__construct();
        $this->_table = "apk_history";
    }
    
    public function getList($platform = "android")
    {
        $this->db->select("id,version,platform,is_current,uploaded_on");
        $this->db->where(["platform"=>$platform]);
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    
    public function addNew($data)
    {
        $this->db->insert($data);
        return $this->db->insert_id();
    }
    
    public function getFeatures($id)
    {
        $this->db->select("features");
        $this->db->where(["id"=>$id]);
        $query = $this->db->get($this->_table);
        return $query->row();
    }
    
    public function getCurrentFeaturesByPlatform($platform)
    {
        $this->db->select("features,version");
        $this->db->where(["is_current"=>1,"platform"=>$platform]);
        $query = $this->db->get($this->_table);
        return $query->row();
    }
}
