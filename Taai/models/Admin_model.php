<?php
class Admin_model extends Base_model {
	function __construct() {
		// Call the Model constructor
		parent::__construct ();
	}
	
	/**
	 * This function return the customer detail by criteria
	 * @param array $criteria
	 * @return mixed[] Return the customer detail
	 */
	public function get_admin_detail_by_criteria($criteria = array()) {
		return $this->get_detail_by_criteria($this->admin_table, $criteria);
	}
}