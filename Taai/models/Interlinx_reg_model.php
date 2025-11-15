<?php
class Interlinx_reg_model extends Base_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_reg_detail_by_criteria($criteria = array())
    {
        return $this->get_detail_by_criteria(EVENT_TBL_INX_REG_TBL, $criteria);
    }

    /**
     * This function update the data
     * @param array $collection
     * @param array $condition
     * @return int affected_rows
     */
    public function update_reg_detail($collection = array(), $condition = array())
    {
        return $this->update(EVENT_TBL_INX_REG_TBL, $collection, $condition);
    }

    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_keywords_detail_by_criteria($criteria = array())
    {
        return $this->get_detail_by_criteria(EVENT_TBL_ALL_USR_KEYWORD, $criteria);
    }

    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function save_keyword_details($criteria = array())
    {
        //Save user data
        $id = $this->save(EVENT_TBL_ALL_USR_KEYWORD, $criteria);

        return $id;
    }

    /**
     * This function update the data
     * @param array $collection
     * @param array $condition
     * @return int affected_rows
     */
    public function update_keyword_details($collection = array(), $condition = array())
    {
        return $this->update(EVENT_TBL_ALL_USR_KEYWORD, $collection, $condition);
    }

    /**
     * This function update the data
     * @param array $collection
     * @param array $condition
     * @return int affected_rows
     */
    public function get_data1($user_id)
    {
        $sql = "select * from " . EVENT_TBL_INX_REG_TBL . " where( (metting_location ='In Exhibition Stall') AND (metting_location_hall !='') AND (metting_location_stall_name !='') AND (metting_location_stall_no !='') AND (user_id= '$user_id') ) ";
        return $this->get_detail_by_query($sql);
    }
    public function get_data2($user_id)
    {
        $sql = "select * from " . EVENT_TBL_INX_REG_TBL . " where( (metting_location ='In Exhibition Stall') AND (metting_location_hall !='') AND (metting_location_stall_name !='') AND (metting_location_stall_no !='') AND (user_id= '$user_id') ) ";
        return $this->get_detail_by_query($sql);
    }

    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_matched_data($criteria = array())
    {
        $limit = $where = $whereCondition = '';
		//print_r($criteria);exit;
        $whereCondition = "";
        $indlike = '';
        if (isset($criteria['my_industries']) && !empty($criteria['my_industries'])) {
			$my_industries = $criteria['my_industries'];
			//$my_industries = explode(';', $criteria['my_industries']);
			//print_r($criteria);exit;
			$like = '';
			for ($i = 1; $i <= 23; $i++) {
				if(!empty($my_industries['intr' . $i])) 
                $like .= "(intr" . $i . " LIKE '%" . $my_industries['intr' . $i] . "%') OR ";
            }
			$indlike = $like = trim(trim($like), 'OR');
            /*$my_industries = explode(';', $criteria['my_industries']);
            $like = '';
            foreach ($my_industries as $my_industry) {
                $like .= " my_industries LIKE '%" . $my_industry . "%' OR ";
            }*/
			if(!empty($like)){
				$like = trim(trim($like), 'OR');
				if (isset($criteria['my_keywords']) && !empty($criteria['my_keywords'])) {
					$whereCondition = "((" . $like . ")";
				} else {
					$whereCondition = "(" . $like . ")";
				}
			}
        }
        if (isset($criteria['my_keywords']) && !empty($criteria['my_keywords'])) {
            $my_industries = explode(';', $criteria['my_keywords']);
            $like = '';
            foreach ($my_industries as $my_industry) {
                $like .= " my_keywords LIKE '%" . $my_industry . "%' OR ";
            }
            $like = trim(trim($like), 'OR');
			
			if(!empty($like)){
				if (!empty($whereCondition)) {
					$whereCondition .= " OR ";
				}
				if (isset($indlike) && !empty($indlike)) {
					$whereCondition .= "(" . $like . "))";
				} else {
					$whereCondition .= "(" . $like . ")";
				}
			}
        }
        if (isset($criteria['user_id']) && !empty($criteria['user_id'])) {
            if (!empty($whereCondition)) {
                $whereCondition .= " AND ";
            }
            $whereCondition .= " user_id !='" . $criteria['user_id'] . "'";
        }

        $order_by = " ORDER BY srno DESC";
        if (isset($criteria['search-tej']) && !empty($criteria['search-tej'])) {
            $cata = '';
            if (isset($criteria['cata']) && !empty($criteria['cata'])) {
                $cata = "OR (" . $criteria['cata'] . " LIKE '%" . $criteria['search'] . "%')";
            }
            /* original code $whereCondition = "( ( (fname LIKE '%" . $criteria['search'] . "%') OR (lname LIKE '%" . $criteria['search'] . "%') $cata ) AND (user_id != '" . $criteria['user_id'] . "') )"; */

            $whereCondition = "( ( (org_name LIKE '%" . $criteria['search'] . "%') OR (org_profile LIKE '%" . $criteria['search'] . "%') OR (my_industries LIKE '%" . $criteria['search'] . "%') OR (my_keywords LIKE '%" . $criteria['search'] . "%') OR (fname LIKE '%" . $criteria['search'] . "%') OR (lname LIKE '%" . $criteria['search'] . "%') $cata ) AND (user_id != '" . $criteria['user_id'] . "') )";

            $order_by = '';
        }

        if (isset($criteria['search-tejind']) && !empty($criteria['search-tejind'])) {
            if (isset($criteria['catas'])) {
                $like = '';
                for ($i = 1; $i <= 20; $i++) {
                    $like .= " (intr" . $i . " LIKE '%" . $criteria['search'] . "%') OR";
                }
                $whereCondition = "( (" . trim($like, 'OR') . ") OR (my_industries LIKE '%" . $criteria['search'] . "%') ) AND (user_id != '" . $criteria['user_id'] . "')";
            } else {
                $whereCondition = "( (" . $criteria['cata'] . " LIKE '%" . $criteria['search'] . "%') OR (my_industries LIKE '%" . $criteria['search'] . "%') ) AND (user_id != '" . $criteria['user_id'] . "')";
            }
        }

        if (isset($criteria['search-tejorg']) && !empty($criteria['search-tejorg'])) {
            $whereCondition = "(org_name LIKE '%" . $criteria['search'] . "%') AND (user_id != '" . $criteria['user_id'] . "')";
        }

        if (isset($criteria['search-tejcou']) && !empty($criteria['search-tejcou'])) {
            $whereCondition = "(country LIKE '%" . $criteria['search'] . "%') AND (user_id != '" . $criteria['user_id'] . "')";
        }

        if (isset($criteria['search-tejturn']) && !empty($criteria['search-tejturn'])) {
            $whereCondition = "( (org_turn_over >= " . $criteria['from'] . ") AND (org_turn_over <= " . $criteria['to'] . ")  AND (org_turn_over_unit='" . $criteria['cur'] . "') AND (user_id != '" . $criteria['user_id'] . "'))";
        }

        if (isset($criteria['latest-tej']) && !empty($criteria['latest-tej'])) {
            $whereCondition = "(user_id != '" . $criteria['user_id'] . "')";
        }

        if (!empty($whereCondition)) {
            $where = " WHERE " . $whereCondition;
        }
        if (isset($criteria['offset']) && isset($criteria['limit'])) {
            $limit = " LIMIT " . $criteria['offset'] . ", " . $criteria['limit'];
        }
        $sql = "SELECT *
				FROM " . EVENT_TBL_INX_REG_TBL . "
				" . $where . $order_by . $limit;

        //echo $sql;
        //exit;
        return $this->get_list_by_query($sql, true);
    }

    /**
     * Count matched records by criteria without loading full result sets
     * @param array $criteria
     * @return int
     */
    public function get_matched_count($criteria = array())
    {
        $where = $whereCondition = '';
        $indlike = '';
        if (isset($criteria['my_industries']) && !empty($criteria['my_industries'])) {
            $my_industries = $criteria['my_industries'];
            $like = '';
            for ($i = 1; $i <= 23; $i++) {
                if(!empty($my_industries['intr' . $i]))
                $like .= "(intr" . $i . " LIKE '%" . $my_industries['intr' . $i] . "%') OR ";
            }
            $indlike = $like = trim(trim($like), 'OR');
            if(!empty($like)){
                $like = trim(trim($like), 'OR');
                if (isset($criteria['my_keywords']) && !empty($criteria['my_keywords'])) {
                    $whereCondition = "((" . $like . ")";
                } else {
                    $whereCondition = "(" . $like . ")";
                }
            }
        }
        if (isset($criteria['my_keywords']) && !empty($criteria['my_keywords'])) {
            $my_industries = explode(';', $criteria['my_keywords']);
            $like = '';
            foreach ($my_industries as $my_industry) {
                $like .= " my_keywords LIKE '%" . $my_industry . "%' OR ";
            }
            $like = trim(trim($like), 'OR');
            if(!empty($like)){
                if (!empty($whereCondition)) {
                    $whereCondition .= " OR ";
                }
                if (isset($indlike) && !empty($indlike)) {
                    $whereCondition .= "(" . $like . "))";
                } else {
                    $whereCondition .= "(" . $like . ")";
                }
            }
        }
        if (isset($criteria['user_id']) && !empty($criteria['user_id'])) {
            if (!empty($whereCondition)) {
                $whereCondition .= " AND ";
            }
            $whereCondition .= " user_id !='" . $criteria['user_id'] . "'";
        }
        if (isset($criteria['search-tej']) && !empty($criteria['search-tej'])) {
            $cata = '';
            if (isset($criteria['cata']) && !empty($criteria['cata'])) {
                $cata = "OR (" . $criteria['cata'] . " LIKE '%" . $criteria['search'] . "%')";
            }
            $whereCondition = "( ( (org_name LIKE '%" . $criteria['search'] . "%') OR (org_profile LIKE '%" . $criteria['search'] . "%') OR (my_industries LIKE '%" . $criteria['search'] . "%') OR (my_keywords LIKE '%" . $criteria['search'] . "%') OR (fname LIKE '%" . $criteria['search'] . "%') OR (lname LIKE '%" . $criteria['search'] . "%') $cata ) AND (user_id != '" . $criteria['user_id'] . "') )";
        }
        if (isset($criteria['search-tejind']) && !empty($criteria['search-tejind'])) {
            if (isset($criteria['catas'])) {
                $like = '';
                for ($i = 1; $i <= 20; $i++) {
                    $like .= " (intr" . $i . " LIKE '%" . $criteria['search'] . "%') OR";
                }
                $whereCondition = "( (" . trim($like, 'OR') . ") OR (my_industries LIKE '%" . $criteria['search'] . "%') ) AND (user_id != '" . $criteria['user_id'] . "')";
            } else {
                $whereCondition = "( (" . $criteria['cata'] . " LIKE '%" . $criteria['search'] . "%') OR (my_industries LIKE '%" . $criteria['search'] . "%') ) AND (user_id != '" . $criteria['user_id'] . "')";
            }
        }
        if (isset($criteria['search-tejorg']) && !empty($criteria['search-tejorg'])) {
            $whereCondition = "(org_name LIKE '%" . $criteria['search'] . "%') AND (user_id != '" . $criteria['user_id'] . "')";
        }
        if (isset($criteria['search-tejcou']) && !empty($criteria['search-tejcou'])) {
            $whereCondition = "(country LIKE '%" . $criteria['search'] . "%') AND (user_id != '" . $criteria['user_id'] . "')";
        }
        if (isset($criteria['search-tejturn']) && !empty($criteria['search-tejturn'])) {
            $whereCondition = "( (org_turn_over >= " . $criteria['from'] . ") AND (org_turn_over <= " . $criteria['to'] . ")  AND (org_turn_over_unit='" . $criteria['cur'] . "') AND (user_id != '" . $criteria['user_id'] . "'))";
        }
        if (isset($criteria['latest-tej']) && !empty($criteria['latest-tej'])) {
            $whereCondition = "(user_id != '" . $criteria['user_id'] . "')";
        }
        if (!empty($whereCondition)) {
            $where = " WHERE " . $whereCondition;
        }
        $sql = "SELECT COUNT(*) AS cnt FROM " . EVENT_TBL_INX_REG_TBL . " " . $where;
        $row = $this->get_detail_by_query($sql, true);
        return isset($row['cnt']) ? (int)$row['cnt'] : 0;
    }



    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_keywords_data($criteria = array())
    {
        $limit = $where = $whereCondition = '';
        $whereCondition = "";

        $order_by = " ORDER BY A.user_id DESC";

        if (isset($criteria['offset']) && isset($criteria['limit'])) {
            $limit = " LIMIT " . $criteria['offset'] . ", " . $criteria['limit'];
        }
        $gotName = $criteria['search'];
        $sql = "SELECT DISTINCT(A.user_id) from " . EVENT_TBL_ALL_USR_KEYWORD . " as A, " . EVENT_TBL_ALL_USR_PRODUCT_DTLS . " as B WHERE ( ( (A.key_1 LIKE '%$gotName%') OR (A.key_2 LIKE '%$gotName%') OR (A.key_3 LIKE '%$gotName%') OR (A.key_4 LIKE '%$gotName%') OR (A.key_5 LIKE '%$gotName%') OR (A.key_6 LIKE '%$gotName%') OR (A.key_7 LIKE '%$gotName%') OR (A.key_8 LIKE '%$gotName%') OR (A.key_9 LIKE '%$gotName%') OR (A.key_10 LIKE '%$gotName%') OR (B.prod_key_1 LIKE '%$gotName%') OR (B.prod_key_2 LIKE '%$gotName%') OR (B.prod_key_3 LIKE '%$gotName%') OR (B.prod_key_4 LIKE '%$gotName%') OR (B.prod_key_5 LIKE '%$gotName%') OR (B.prod_key_6 LIKE '%$gotName%') OR (B.prod_key_7 LIKE '%$gotName%') OR (B.prod_key_8 LIKE '%$gotName%') OR (B.prod_key_9 LIKE '%$gotName%') OR (B.prod_key_10 LIKE '%$gotName%')) AND (A.user_id != '" . $criteria['user_id'] . "') AND ((B.user_id != '" . $criteria['user_id'] . "')) ) " . $order_by . $limit;

        //echo $sql;exit;
        return $this->get_list_by_query($sql, true);
    }

    /**
     * Count keyword matches (distinct users) without loading full list
     * @param array $criteria
     * @return int
     */
    public function get_keywords_count($criteria = array())
    {
        $gotName = $criteria['search'];
        $sql = "SELECT COUNT(DISTINCT A.user_id) AS cnt
                FROM " . EVENT_TBL_ALL_USR_KEYWORD . " AS A, " . EVENT_TBL_ALL_USR_PRODUCT_DTLS . " AS B
                WHERE ( ( (A.key_1 LIKE '%$gotName%') OR (A.key_2 LIKE '%$gotName%') OR (A.key_3 LIKE '%$gotName%') OR (A.key_4 LIKE '%$gotName%') OR (A.key_5 LIKE '%$gotName%') OR (A.key_6 LIKE '%$gotName%') OR (A.key_7 LIKE '%$gotName%') OR (A.key_8 LIKE '%$gotName%') OR (A.key_9 LIKE '%$gotName%') OR (A.key_10 LIKE '%$gotName%') OR (B.prod_key_1 LIKE '%$gotName%') OR (B.prod_key_2 LIKE '%$gotName%') OR (B.prod_key_3 LIKE '%$gotName%') OR (B.prod_key_4 LIKE '%$gotName%') OR (B.prod_key_5 LIKE '%$gotName%') OR (B.prod_key_6 LIKE '%$gotName%') OR (B.prod_key_7 LIKE '%$gotName%') OR (B.prod_key_8 LIKE '%$gotName%') OR (B.prod_key_9 LIKE '%$gotName%') OR (B.prod_key_10 LIKE '%$gotName%'))
                  AND (A.user_id != '" . $criteria['user_id'] . "') AND (B.user_id != '" . $criteria['user_id'] . "') )";
        $row = $this->get_detail_by_query($sql, true);
        return isset($row['cnt']) ? (int)$row['cnt'] : 0;
    }

    public function get_data3()
    {
        $sql = "SELECT  distinct(org_name) FROM " . EVENT_TBL_INX_REG_TBL . " WHERE (  (!(ISNULL(org_name))) AND (org_name!='')) ORDER BY org_name ASC";
        return $this->get_list_by_query($sql);
    }

    public function get_data4()
    {
        $sql = "SELECT  distinct(country) FROM " . EVENT_TBL_INX_REG_TBL . " WHERE ( (country!='') ) ORDER BY country ASC";
        return $this->get_list_by_query($sql);
    }

    public function get_data5($usr_id_temp)
    {
        $sql = "select * from " . EVENT_TBL_INX_REG_TBL . " WHERE (user_id != '$usr_id_temp') ORDER BY srno DESC";
        return $this->get_list_by_query($sql);
    }
}
