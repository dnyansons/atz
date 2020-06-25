<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class HelpCenter_model extends CI_Model {

    private $_table;
    private $_tableDescription;

    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "helpcenter";
        $this->_subtitle = "helpcentersubtitles";
		$this->_question = "helpcentersubtitles";
    }
	
	function add_title($arr) {
        return $this->db->insert($this->_table, $arr);
    }
		
	function getTitlesList()
	{
		$this->db->select('h2.id, h1.title as parent_title, h2.title as main_title, h1.added_date');
		$this->db->from('helpcenter h1');
		$this->db->join('helpcenter h2','h1.id = h2.parent');
		$this->db->where('h2.parent > 0');
		return $this->db->get()->result_array();
	}
	
	function getTitles()
	{
        return $this->db->get($this->_table)->result_array();
	}
	
	function getTitlesIdwise($id)
	{
		$this->db->select('h2.id, h1.title as parent_title, h2.title as main_title, h2.description');
		$this->db->from('helpcenter h1');
		$this->db->join('helpcenter h2','h1.id = h2.parent','left');
		$this->db->where('h2.id',$id);
        return $this->db->get($this->_table)->row();
	}
	
	function updateTitle($arr,$id)
	{
		$this->db->where('id',$id);
		$this->db->set('title',$arr['title']);
		$this->db->set('parent',$arr['parent']);
		$this->db->set('updated_date',$arr['updated_date']);
        return $this->db->update($this->_table);
	}
	
	function getAllTitles()
	{
		$this->db->select('id,title');
		$this->db->from('helpcenter');
		$this->db->where('parent',0);
		return $this->db->get()->result_array();
	}
	
	function getAllsubTitles($id)
	{
		$this->db->select('id,title');
		$this->db->from('helpcenter');
		$this->db->where('parent',$id);
		return $this->db->get()->result_array();
	}
	
	function getdescription($id)
	{
		$this->db->select('description,title');
		$this->db->from('helpcenter');
		$this->db->where('id',$id);
		return $this->db->get()->row();
	}
	
	function getTitlesListOfSeller()
	{
		$this->db->select('h2.id, h1.title as parent_title, h2.title as main_title, h1.added_date');
		$this->db->from('helpforseller h1');
		$this->db->join('helpforseller h2','h1.id = h2.parent');
		$this->db->where('h2.parent > 0');
		return $this->db->get()->result_array();
	}
	
	function add_titleOfSeller($arr) {
        return $this->db->insert('helpforseller', $arr);
    }
	
	function getTitlesOfSeller()
	{
        return $this->db->get('helpforseller')->result_array();
	}
	
	function getTitlesOfSellerIdwise($id)
	{
		$this->db->select('h2.id, h1.title as parent_title, h2.title as main_title, h2.description');
		$this->db->from('helpforseller h1');
		$this->db->join('helpforseller h2','h1.id = h2.parent','left');
		$this->db->where('h2.id',$id);
        return $this->db->get($this->_table)->row();
	}
	
	function getAllTitlesOfSeller()
	{
		$this->db->select('id,title');
		$this->db->from('helpforseller');
		$this->db->where('parent',0);
		return $this->db->get()->result_array();
	}
	
	function getAllsubTitlesofSeller($id)
	{
		$this->db->select('id,title');
		$this->db->from('helpforseller');
		$this->db->where('parent',$id);
		return $this->db->get()->result_array();
	}
	
	function updateTitleofSeller($arr,$id)
	{
		$this->db->where('id',$id);
		$this->db->set('title',$arr['title']);
		$this->db->set('parent',$arr['parent']);
		$this->db->set('updated_date',$arr['updated_date']);
        return $this->db->update('helpforseller');
	}
	
	function getDesciptionOfSeller($id)
	{
		$this->db->select('description,title');
		$this->db->from('helpforseller');
		$this->db->where('id',$id);
		return $this->db->get()->row();
	}

}
