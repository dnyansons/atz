<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model 
{

    private $_company, $_user, $_sellerInfo, $_companyExportInfo, $_companyManufactureInfo, $_companyQc, $_companyRnd, $_companyTypes;

    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_company = "seller_company_details";
        $this->_user = "users";
        $this->_sellerInfo = "seller_info";
        $this->_companyExportInfo = "company_export_capability_details";
        $this->_companyManufactureInfo = "company_manufacturing_capabilities_details";
        $this->_companyQc = "company_quality_control_details";
        $this->_companyRnd = "company_rnd_details";
        $this->_companyTypes = "company_types";
        $this->_companyExportCapabilityDetails = "company_export_capability_details";
    }

    public function createCompany($data) 
    {
        $this->db->insert($this->_company, $data);
        return $this->db->insert_id();
    }

    public function addExportInfo($data) 
    {
        $this->db->insert($this->_companyExportInfo, $data);
        return $this->db->insert_id();
    }

    public function addManufactureInfo($data) 
    {
        $this->db->insert($this->_companyManufactureInfo, $data);
        return $this->db->insert_id();
    }

    public function addQcInfo($data) 
    {
        $this->db->insert($this->_companyQc, $data);
        return $this->db->insert_id();
    }

    public function addRndInfo($data) 
    {
        $this->db->insert($this->_companyRnd, $data);
        return $this->db->insert_id();
    }

    public function updateCompany($id, $data) 
    {
        $this->db->where(array("id" => $id));
        $this->db->update($this->_company, $data);
    }
    /*
     * @author : Shubham Patil
     */
    public function getCompanyDetailsBySeller($seller) 
    {
        $this->db->select("IFNULL(SCD.id,'NA') as pcompany_id,IFNULL(SCD.company_name,'') as company_name,SCD.*,EXP.*,MAN.*,RND.*,QA.*,IFNULL(CT.name,'') as company_type");
        $this->db->from($this->_company . " SCD");
        $this->db->join($this->_companyExportInfo . " EXP", "SCD.id = EXP.company_id", "LEFT");
        $this->db->join($this->_companyManufactureInfo . " MAN", "SCD.id = MAN.company_id", "LEFT");
        $this->db->join($this->_companyRnd . " RND", "SCD.id = RND.company_id", "LEFT");
        $this->db->join($this->_companyQc . " QA", "SCD.id = QA.company_id", "LEFT");
        $this->db->join($this->_companyTypes . " CT", "SCD.primary_business_type = CT.id", "LEFT");
        $this->db->join($this->_companyExportCapabilityDetails . " CEC", "SCD.id = CEC.company_id", "LEFT");
        $this->db->where(array("SCD.user_id" => $seller));
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getCompanyDetailsByName($name) 
    {
        $this->db->select("SCD.id as pcompany_id,SCD.*,EXP.*,MAN.*,RND.*,QA.*,CT.name as company_type");
        $this->db->from($this->_company . " SCD");
        $this->db->join($this->_companyExportInfo . " EXP", "SCD.id = EXP.company_id", "LEFT");
        $this->db->join($this->_companyManufactureInfo . " MAN", "SCD.id = MAN.company_id", "LEFT");
        $this->db->join($this->_companyRnd . " RND", "SCD.id = RND.company_id", "LEFT");
        $this->db->join($this->_companyQc . " QA", "SCD.id = QA.company_id", "LEFT");
        $this->db->join($this->_companyTypes . " CT", "SCD.primary_business_type = CT.id", "LEFT");
        $this->db->join($this->_companyExportCapabilityDetails . " CEC", "SCD.id = CEC.company_id", "LEFT");
        $this->db->where(array("SCD.company_name" => $name));
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getCompanyDetailsByProduct($product_id)
    {
        $this->db->select("SCD.id as pcompany_id,SCD.*,EXP.*,MAN.*,RND.*,QA.*,CT.name as company_type");
        $this->db->from($this->_company . " SCD");
        $this->db->join($this->_companyExportInfo . " EXP", "SCD.id = EXP.company_id", "LEFT");
        $this->db->join($this->_companyManufactureInfo . " MAN", "SCD.id = MAN.company_id", "LEFT");
        $this->db->join($this->_companyRnd . " RND", "SCD.id = RND.company_id", "LEFT");
        $this->db->join($this->_companyQc . " QA", "SCD.id = QA.company_id", "LEFT");
        $this->db->join($this->_companyTypes . " CT", "SCD.primary_business_type = CT.id", "LEFT");
        $this->db->join($this->_companyExportCapabilityDetails . " CEC", "SCD.id = CEC.company_id", "LEFT");
        $this->db->join("product_details PD", "PD.seller = SCD.id");
        $this->db->where(array("PD.id" => $product_id));
        $query = $this->db->get();
        return $query->row();
    }

    public function updateCompanyQualityProcess($id, $data) 
    {
        $this->db->where(["company_id" => $id]);
        $this->db->update($this->_companyQc, $data);
    }

    public function updateCompanyManufactureDetails($id, $data) {
        $this->db->where(["company_id" => $id]);
        $this->db->update($this->_companyManufactureInfo, $data);
    }
	
	public function updateCompanyRndProcess($id, $data) {
        $this->db->where(["company_id" => $id]);
        $this->db->update($this->_companyRnd, $data);
    }
	
    public function getCompanyDetailsById() 
    {
        
    }
	
	function getCountries()
	{
		$this->db->select('id,name');
		return $this->db->get('country')->result_array();
	}
	
	function update_company_export_capability_details($id, $data)
	{
		$this->db->where(["company_id" => $id]);
        $this->db->update($this->_companyExportCapabilityDetails, $data);
	}

    public function updateCompanyProfile($user_id, $data) 
    {
        $this->db->where(array("user_id" => $user_id));
        $this->db->update($this->_company, $data);
    }

    public function getAllCompanyTypes()
    {
        $this->db->select('id, name');
        $query=$this->db->get($this->_companyTypes);
        return $query->result();
    }


    public function setOnlineShopWebAddressData($user_id, $online_shop_web_address)
    {
        $this->db->set('company_url', $online_shop_web_address);
        $this->db->where('user_id', $user_id);
        $this->db->update('seller_company_details');
    }
    
    public function getCompanyBasicByseller($seller)
    {
        $this->db->select("SCD.id as pcompany_id,SCD.*");
        $this->db->from($this->_company . " SCD");
        $this->db->where(array("SCD.user_id" => $seller));
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getCompanyListByCategory($category)
    {
        //        SELECT 
        //            SCD.logo,
        //        PD.seller as seller_id,
        //        SCD.id as company_id,
        //        SCD.company_name,
        //        SCD.main_products
        //        FROM product_details PD 
        //        JOIN seller_company_details SCD ON SCD.user_id = PD.seller
        //        WHERE PD.category = 758
        //        GROUP BY PD.seller
        
        $this->db->select("SCD.logo,PD.seller as seller_id,SCD.id as company_id,SCD.company_name,SCD.main_products")
                ->from("product_details PD")
                ->join("$this->_company SCD","SCD.user_id = PD.seller")
                ->where(["PD.category" => $category])
                ->group_by("PD.seller");
        $query = $this->db->get();
        return $query->result();
        
    }
    
    public function getSellersCountRegionWise()
    {
        $query = $this->db->select("SCD.comp_operational_state,COUNT(SCD.id),U.first_name,U.last_name")
                ->from($this->_company." SCD")
                ->join($this->_user." U","SCD.user_id = U.id")
                ->where("comp_operational_state!=''")
                ->get();
        return $query->result();        
    }
    
    public function regionWiseSupplierList($region)
    {
        $query = $this->db->select("SCD.logo,company_name,CONCAT(U.first_name,' ',U.last_name) as supplier_name,CT.name as company_type")
                ->from($this->_company." SCD")
                ->join($this->_user." U","SCD.user_id = U.id")
                ->join("company_types CT","CT.id = SCD.primary_business_type")
                ->like("U.state",$region)
                ->get();
        return $query->result();
    }
}
