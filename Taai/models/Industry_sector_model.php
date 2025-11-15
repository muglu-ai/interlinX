<?php 
class Industry_sector_model extends Base_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_industry_sectors_list_by_criteria($criteria = array(), $order_by = array()) {
        return $this->get_list_by_criteria(EVENT_TBL_MSTR_COMMUNITY, $criteria);
    }
    public function get_data($data) {
        $sql = "Select srno from " . EVENT_TBL_MSTR_COMMUNITY . " where comm_name like '%$data%'";
        return $this->get_detail_by_query($sql);
    }
    public function get_industry_sectors_detail_by_criteria($criteria = array(), $order_by = array()) {
        return $this->get_detail_by_criteria(EVENT_TBL_MSTR_COMMUNITY, $criteria);
    }
}