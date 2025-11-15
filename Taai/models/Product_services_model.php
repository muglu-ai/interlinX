<?php 
class Product_services_model extends Base_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function save_product_services_details($criteria = array()) {
        $criteria['created_time'] = date('h:i:s a');
        $criteria['created_date'] = date('Y-m-d');
        
        do {
            $i = 0;
            $b_no1 = "prdct-";
            $temp_no = rand(1, 99999);
            $b_no = $b_no1 . $temp_no;
            $tst_brid_num = $this->get_product_services_detail_by_criteria(array('product_id'=>$b_no));
            if(empty($tst_brid_num)) {
                $i++;
            } else {
                $b_no = "";
            }
        } while(!($i == 1));
        
        $criteria['product_id'] = $b_no;
        if(!empty($criteria['product_keywords'])) {
            
        }
        //Save user data
        $id = $this->save(EVENT_TBL_ALL_USR_PRODUCT_DTLS, $criteria);
        
        return $id;
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_product_services_detail_by_criteria($criteria = array()) {
        return $this->get_detail_by_criteria(EVENT_TBL_ALL_USR_PRODUCT_DTLS, $criteria);
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_product_services_list_by_criteria($criteria = array(), $order_by = array()) {
        return $this->get_list_by_criteria(EVENT_TBL_ALL_USR_PRODUCT_DTLS, $criteria);
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function update_product_services_details($collection, $condition) {
        //Save user data
        $id = $this->update(EVENT_TBL_ALL_USR_PRODUCT_DTLS, $collection, $condition);
        
        return $id;
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function delete_product_services($criteria = array()) {
        return $this->delete(EVENT_TBL_ALL_USR_PRODUCT_DTLS, $criteria);
    }
}