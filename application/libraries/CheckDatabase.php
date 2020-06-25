<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Note: Library to check missing columns in two database
 * Created to check online and offline database comparision
 * @auther Yogesh Pardeshi 
 */

class CheckDatabase {

    //private   $localDB = "atzcart_online", $onlineDB = "atzcart_testing";
    private $localDB = "shubh_ayntest", $onlineDB = "ayntest";

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->database();
    }

    /**
     * @auther Yogesh Pardeshi 09092019 147pm
     * @param database full name e.g. atzcart_dbtest
     * @return names of tables from db
     * @use to check missing columns for online and localhost db
     * */
    private function getTableNames($dbname) {
        $sql = 'SELECT table_name FROM information_schema.tables WHERE table_schema = ?';
        $query = $this->CI->db->query($sql, array($dbname));
        $result = $query->result_array();
        $tablenames = array();
        foreach ($result as $table) {
            $tablenames [] = $table['table_name'];
        }
        return $tablenames;
    }

    /**
     * @auther Yogesh Pardeshi 09092019 147pm
     * @param database full name e.g. atzcart_dbtest
     * @return names of tables from db
     * @use to check missing columns for online and localhost db
     * */
    private function compareTableColumns($schemaComapareArr) {
        $sql = "SELECT *
                FROM INFORMATION_SCHEMA.COLUMNS a 
                WHERE a.TABLE_NAME = ?
                 AND a.TABLE_SCHEMA = ?
                 AND a.COLUMN_NAME NOT IN (
                  SELECT b.COLUMN_NAME
                  FROM INFORMATION_SCHEMA.COLUMNS b 
                  WHERE b.TABLE_NAME = ? 
                   AND b.TABLE_SCHEMA = ?
                 )";
        $query = $this->CI->db->query($sql, array(
            $schemaComapareArr['TABLE_NAME_LOCAL'],
            $this->localDB,
            $schemaComapareArr['TABLE_NAME_ONLINE'],
            $this->onlineDB
        ));
        return $query->result_array();
    }

    /**
     * @auther Yogesh Pardeshi 
     * @param 
     * @return 
     * @use
     * */
    public function checkDB() {
        $dbLocalTableNames = $this->getTableNames($this->localDB);
        $dbOnlineTableNames = $this->getTableNames($this->onlineDB);

        $localTableCount = count($dbLocalTableNames);
        $onlineTableCount = count($dbOnlineTableNames);

        if ($localTableCount < $onlineTableCount) {
            echo "database <b>$this->localDB</b> is having less table than <b>$this->onlineDB</b> database <br><br>"
            . "<b>$this->localDB</b> Table Count = $localTableCount < "
            . "<b>$this->onlineDB</b> Table Count = $onlineTableCount <br>";
        } else if ($localTableCount > $onlineTableCount) {
            echo " database <b>$this->onlineDB</b> is having greater table than <b>$this->localDB</b> database <br><br>"
            . "<b>$this->localDB</b> Table Count = $localTableCount > "
            . "<b>$this->onlineDB</b> Table Count = $onlineTableCount <br>";
        } else {
            echo "<b>$this->onlineDB</b> database == <b>$this->localDB</b> database both have equal tables <br><br>"
            . "<b>$this->localDB</b> Table Count = $localTableCount ===== "
            . "<b>$this->onlineDB</b> Table Count = $onlineTableCount <br>";
        }

        $notInLocalDatabase = array_diff($dbOnlineTableNames, $dbLocalTableNames);
        $notInOnlineDatabase = array_diff($dbLocalTableNames, $notInOnlineDatabase);

        echo "<br><br>";
        if (count($notInLocalDatabase) != 0) {
            echo "Missing in $this->localDB database <br>";
            print_r($notInLocalDatabase);
        }
        echo "<br><br>";
        if (count($notInOnlineDatabase) != 0) {
            echo "Missing in $this->onlineDB database <br>";
            print_r($notInOnlineDatabase);
        }

        // Sort arrays
        asort($dbLocalTableNames);
        //asort($dbOnlineTableNames);
//        echo"<pre>";
//        print_r($dbLocalTableNames); echo "<br><br><br>";
//        print_r($dbOnlineTableNames);

        echo "<br>Count $this->localDB db = " . count($dbLocalTableNames);
        echo "<br>Count $this->onlineDB db = " . count($dbOnlineTableNames) . '<br><br><br><br>';

        $schemaComapareArr = array();
        //for changes required in local db uncomment this
        //$schemaComapareArr['TABLE_SCHEMA_LOCAL'] = 'atzcart_online';
        //$schemaComapareArr['TABLE_SCHEMA_ONLINE'] = 'atzcart_testdb';
        //for changes required in online db uncomment this
        $schemaComapareArr['TABLE_SCHEMA_LOCAL'] = $this->localDB;
        $schemaComapareArr['TABLE_SCHEMA_ONLINE'] = $this->onlineDB;

        $missingColumnsInOnline = array();

        echo "Missing in $this->onlineDB database <br>";
        for ($i = 0; $i < count($dbOnlineTableNames); $i++) {
            $schemaComapareArr['TABLE_NAME_LOCAL'] = $dbLocalTableNames[$i];
            $schemaComapareArr['TABLE_NAME_ONLINE'] = $dbLocalTableNames[$i];
            //echo "Checking For " . $dbOnlineTableNames[$i]['table_name'].'<br>';
            $missingColumnsInOnline = $this->compareTableColumns($schemaComapareArr);
            //print_r($missingColumnsInOnline);
            if (count($missingColumnsInOnline) != 0) {
                //echo $this->db->last_query(); echo "<br>";
                echo "<p style = 'color:red'><b> <br>"
                . "Did not found below columns in <span style='color:black;'>" .
                $dbLocalTableNames[$i] . "</span><br><br>";

                for ($j = 0; $j < count($missingColumnsInOnline); $j++) {
                    echo $missingColumnsInOnline[$j]['COLUMN_NAME'] . ' &nbsp;&nbsp;&nbsp;&nbsp;';
                }
                echo "</b></p>";
            }

//            else
//                echo "<p style='color:Green;'><b>No Change</b></p>";
        }
    }

    /**
     * @auther Yogesh Pardeshi 24092019
     * @return tables wise engine name
     * @use to check engine of created tables
     * */
    public function checkTableEngine() {
        $myism = 0;
        $innodb = 0;
        $onlineDbTables = $this->getTableNames($this->onlineDB);
        //$localDbTables = $this->getTableNames($this->localDB);
        foreach ($onlineDbTables as $tableName) {

            $sql = 'SHOW TABLE STATUS WHERE Name = ?';
            $query = $this->CI->db->query($sql, array($tableName));
            $result = $query->result_array();
            $tableEng = $result[0]['Engine'];

            if ($tableEng == 'MyISAM') {
                echo "Checking table <b style='font-size:1.2em;'>$tableName</b> Engine = ";
                echo "<span style='color:red;'>$tableEng</span><br>";
                $myism++;
            } else {
                //echo "<span style='color:green;'>$tableEng</span>";
                $innodb++;
            }
        }

        echo "<br> Total MyISM tables = $myism <br> Total InnoDB tables = $innodb ";
    }

    /**
     * @auther Yogesh Pardeshi 24092019
     * @return converts table to InnoDB
     * @use
     * */
    public function changeEngine() {
        $array = array('apk_history',
'app_info',
'bi_data_reports',
'bi_recommended_comments',
'brands',
'collections',
'company_types',
'country',
'country_old',
'coupons',
'coupons_to_product',
'currency',
'currency_conver_charges',
'email_preferences',
'email_subscriptions',
'email_verification',
'insights_recommended',
'orders_history',
'order_refund',
'order_refund_history',
'quality_control_testing_equipment',
'reasons_for_sourcing',
'refund_reason',
'return_orders_history',
'reviews_reply',
'rfqs',
'rfq_to_seller',
'security_questions',
'seller_company_details',
'shipping_methods',
'temp_test',
'terms_of_use',
'units',
'user_preferences',
'user_purchasing_behaviour',
'user_security_questions'
);
        
        foreach($array as $val){
             echo $sql = "ALTER TABLE $val ENGINE=InnoDB;<br>";
        }
        exit;
        
        $myism = 0;
        $innodb = 0;
        $onlineDbTables = $this->getTableNames($this->onlineDB);
        //$localDbTables = $this->getTableNames($this->localDB);
        $count = 1;
        foreach ($onlineDbTables as $tableName) {
            $sql = 'SHOW TABLE STATUS WHERE Name = ?';
            $query = $this->CI->db->query($sql, array($tableName));
            $result = $query->result_array();
            $tableEng = $result[0]['Engine'];
            echo $count++; echo "<br>";
            if ($tableEng == 'MyISAM') {
                //echo "Changing table <b style='font-size:1.2em;'>$tableName</b> Engine MyISAM to InnoDB ";
                echo $sql = "ALTER TABLE $tableName ENGINE=InnoDB;";
                //$query = $this->CI->db->query($sql, array($tableName));
//                if ($query === true) {
//                    echo "<br>table <span style='color:green'><b>$tableName</b> converted to <i>InnoDB</i></span>";
//                }
            }
        }
    }
}
