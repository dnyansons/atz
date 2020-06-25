<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model("Users_model");
        $this->load->model("Common_model");
        $this->load->model("Order_model");
        $this->load->model("Shipping_model");
        $this->load->model('Product_model');
        $this->load->model("Categories_model");
        $this->load->model("Banners_model");
        $this->load->model("Rfqs_model");
        $this->load->model("Subscribers_model");
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->model('myfavourite_model');
        $this->load->model('Inquiries_model');
        $this->load->library('Shipping');
        $this->load->library("get_header_data");
        $this->load->library('user_agent');
        $this->load->library('Send_data');
        $this->load->library('Browser_notification');
    }

    public function index() {
        echo 'Testing';
        echo'<br>';
        echo date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);

        $var = 541;
        $number = sprintf('%.2f', $var);
        echo $number;
    }

    function tracking() {
        $awb_number = 53387019766;
        $url = "http://www.bluedart.com/servlet/RoutingServlet?handler=tnt&action=custawbquery&loginid=PNQ68152&awb=awb&numbers=" . $awb_number . "&format=xml&lickey=shpfrizntrznsoenuinitepppenfhuun&verno=1.3&scan=1";

        $get = file_get_contents($url);
        $arr = simplexml_load_string($get);

        $sdate = $arr->Shipment->StatusDate;
        echo'<pre>';
        // print_r($arr);
        $new_arr = json_decode(json_encode($arr->Shipment->Scans));

        $track_arr = (array_reverse($new_arr->ScanDetail));

        foreach ($track_arr as $track_arr) {
            print_r($track_arr);
            echo $track_arr->ScanCode . '<br>';

            $DLdate = date('Y-m-d', strtotime($track_arr->ScanDate));
            $DLtime = date('H:i:s', strtotime($track_arr->ScanTime));

            echo $DLt = $DLdate . ' ' . $DLtime;
            echo'<br>';
        }
    }

    function test_token() {
        echo $this->session->userdata('auth_token');
    }

    function sons() {
        $this->load->view('front/common/header');
        $this->load->view('front/test_alert');
        $this->load->view('front/common/footer');
    }

    public function test() {
 
        $this->output->enable_profiler(true);
 
        //require '../vendor/autoload.php';
        if (isset($_FILES['image'])) {
            $file_name = $_FILES['image']['name'];
            $temp_file_location = $_FILES['image']['tmp_name'];

            $s3 = new Aws\S3\S3Client([
                'region' => 'ap-south-1',
                'version' => 'latest',
                'credentials' => [
                    'key' => "AKIAJQ54Z2QIUXAN45PA",
                    'secret' => "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",
                ],
                "http" => [
                    "verify" => false
                ]
            ]);

            $result = $s3->putObject([
                'Bucket' => 'aynbucket',
                'Key' => 'testfolder23/' . $file_name,
                'SourceFile' => $temp_file_location
            ]);
            
            echo "<pre>";
            print_r($result->get('ObjectURL'));
 
        if (isset($_FILES['quote_attachment'])) {
            $this->load->library("awsupload");


            echo $this->awsupload->upload("image", "upload/demo");
 
        $this->output->enable_profiler(true);
        if (isset($_FILES['image'])) {
            $this->load->library("awsupload");
            $checkImageSizes = $this->awsupload->checkImageSize('image', 'product');
            if ($checkImageSizes !== true) {
                echo $checkImageSizes;
                return;
            }
            echo $this->awsupload->upload("image", "demo/uploads", 'image');


        } else {
            $this->load->view("testing/test");
        }
    }
    }
    }

    function test2($seller_pin = 411057, $buyer_pin = 441912) {

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
                echo 'Rate' . $tot_rate = $tot_rate + $rate_q['rate'];
                echo'<br>';
                //Check EDL
                if ($region_q[0]['edl'] == 'Y') {
                    $r1_dist = $region_q[0]['distance'];
                    $rate1 = $this->get_EDL_rate($r1_dist, $tot_weight);
                    $tot_rate = $tot_rate + $rate1;
                }

                if ($region_q[1]['edl'] == 'Y') {
                    echo 'Dist' . $r2_dist = $region_q[1]['distance'];
                    echo $rate2 = $this->get_EDL_rate($r2_dist, $tot_weight);
                    echo'<br>';
                    $tot_rate = $tot_rate + $rate2;
                    echo'<br>';
                }


                echo $tot_rate;
            } else {
                echo 0;
            }
        } else {
            echo 0;
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

    function call_procedure() {
        // $this->db->query('CALL GetAllOrders()');
        // $this->db->get();

        $data = $this->db->query("CALL GetAllOrders()")->result();
        echo'<pre>';
        print_r($data);

    }

    public function check($id) {
        $this->output->enable_profiler(true);
        $this->load->model("Myfavourite_model");
        $this->load->model("Product_model");
        $res = $this->Myfavourite_model->getUsersFavouritesProducts($user_id);
        $products = json_decode($res['products']);
        for ($i = 0; $i < count($products); $i++) {
            $favorite_prod[]= $this->Product_model->getfavProductDetails($products[$i]);
        }

        $data['favorite_prod'] = array_reverse($favorite_prod);
        echo "<pre>";
        print_r($data);
    }

    public function times() {
        $arr = array();
        set_time_limit(0);

        for ($i = 0; $i < 100000; $i++) {
            $id = uniqid(time(), true);
            if (!in_array($id, $arr)) {
                echo $id . '<br/><br/>';
            } else {
                echo 'duplicate = ' . $id . '<br/><br/>';
                break;
            }
        }
    }

    public function testuploadresize() {
        if (isset($_FILES) && !empty($_FILES)) {
            echo '<pre>';
            print_r($_FILES);
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_FILES['image']['tmp_name'];
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 75;
            $config['height'] = 50;

            $this->load->library('image_lib', $config);

            $this->image_lib->resize();
        } else {
            echo sys_get_temp_dir() . "<br>";
            echo "<form method='post' enctype='multipart/form-data'><input type='file' name='image'><input type='submit'></form>";
        }
    }

    /**
     * @auther Yogesh Pardeshi $date
     * @param 
     * @return 
     * @use
     * */
    public function checkBase() {
        $this->load->library('awsupload');
        $image_base64 = '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcGBwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2wBDAQICAgMDAwYDAwYMCAcIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAKyArIDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9/KKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKY8qwx7m+VfegBtxOlrEzyMqIo+ZmryHxt/wUG+BXw01B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+/PNZXUf/fHkJXlPjf8A4M+5beKV/Cvx0O8/ch1Xw1/7Ok//ALJX7d0UAfzz69/waRfHqB/9D+IXwsu/96a+h/8AaFc5qH/Bpf8AtMRSfuPEnwhn/wC4vep/7ZV/R3RQB/N9H/waa/tPXMv73X/hAi/3/wC271//AGyq3H/waJ/tGS/63xt8JU+moX3/AMi1/RtRQB/O/p//AAZ8/HGWL9/8TvhfA3+x9tf/ANo12Phr/gzY8WSx/wDE2+OmgW5/u2fhuafP/fc6V+99FAH4ZWH/AAZm4/4+vj8//bHwp/8AdVWZf+DM2zk+78frv/wk0/8Akqv3EooA/Ebw1/wZieFYtURtb+OniS6tP447Pw7BBJJ/wN5n/wDQK/Sb/gnn/wAEuPhV/wAEx/AN9onw20y++0635cmsaxqVybi/1R0zs3twiINz/JGiJz0r6TooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP/2Q==';
        $image_base64 = base64_decode($image_base64);
        $uniqueName = $this->awsupload->getUniqueName('png');
        $file = 'demo/uploads/' . $uniqueName;
        echo $s3FilePath = $this->awsupload->filePutContents($file, $image_base64, 'image');
    }
    
    /**
     * @auther Yogesh Pardeshi $date
     * @param 
     * @return 
     * @use
     **/
    public function checkMime() {
        echo base_url('uploads/demo/demo.jpg');
        $data =  mime_content_type('uploads/demo/mypng.jpg');
        print_r(var_dump($data));
    }
    
    /**
     * @auther Yogesh Pardeshi $date
     * @param 
     * @return 
     * @use
     **/
    public function checkDB() {

        $dbLocalName = 'ayntest';
        $dbOnlineName = 'atzcart_online';

        $dbLocalTableNames = $this->getTableNames($dbLocalName);
        $dbOnlineTableNames = $this->getTableNames($dbOnlineName);

        $localTableCount = count($dbLocalTableNames);
        $onlineTableCount = count($dbOnlineTableNames);

        if ($localTableCount < $onlineTableCount) {
            echo " Local db $dbLocalName is having less table than Online database <br><br>"
            . "Local Table Count = $localTableCount < "
            . "Online Table Count = $onlineTableCount <br>";
        } else if ($localTableCount > $onlineTableCount) {
            echo " Online db $dbOnlineName is having greater table than Local database <br><br>"
            . "Local Table Count = $localTableCount > "
            . "Online Table Count = $onlineTableCount <br>";
        } else {
            echo "Local database == Online database both have equal tables <br><br>"
            . "Local Table Count = $localTableCount ===== "
            . "Online Table Count = $onlineTableCount <br>";
        }

        $notInLocalDatabase = array_diff($dbOnlineTableNames, $dbLocalTableNames);
        $notInOnlineDatabase = array_diff($dbLocalTableNames, $notInOnlineDatabase);

        echo "<br><br>";
        if (count($notInLocalDatabase) != 0) {
            echo "Missing in local database <br>";
            print_r($notInLocalDatabase);
        }
        echo "<br><br>";
        if (count($notInOnlineDatabase) != 0) {
            echo "Missing in online database <br>";
            print_r($notInOnlineDatabase);
        }

        // Sort arrays
        asort($dbLocalTableNames);
        //asort($dbOnlineTableNames);
//        echo"<pre>";
//        print_r($dbLocalTableNames); echo "<br><br><br>";
//        print_r($dbOnlineTableNames);

        echo "<br>Count local db = " . count($dbLocalTableNames);
        echo "<br>Count online db = " . count($dbOnlineTableNames) . '<br><br><br><br>';

        $schemaComapareArr = array();
        //for changes required in local db uncomment this
        //$schemaComapareArr['TABLE_SCHEMA_LOCAL'] = 'atzcart_online';
        //$schemaComapareArr['TABLE_SCHEMA_ONLINE'] = 'atzcart_testdb';
        //for changes required in online db uncomment this
        $schemaComapareArr['TABLE_SCHEMA_LOCAL'] = 'ayntest';
        $schemaComapareArr['TABLE_SCHEMA_ONLINE'] = 'atzcart_online';

        $missingColumnsInOnline = array();

        echo "Missing in online database <br>";
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

    public function tst5() {
        $user_id = $this->session->userdata("user_id");
        $this->output->enable_profiler(true);
        $this->load->model("Myfavourite_model");
        $this->load->model("Product_model");
        $res = $this->Myfavourite_model->getUsersFavouritesProducts($user_id);
        $products = json_decode($res['products']);
        for ($i = 0; $i < count($products); $i++) {
            $favorite_prod[] = $this->Product_model->getfavProductDetails($products[$i]);
        }

        $data['favorite_prod'] = array_reverse($favorite_prod);
        echo "<pre>";
        print_r($res);
    }
    
    /**
     * @auther Yogesh Pardeshi 24092019
     * @param 
     * @return 
     * @use
     **/
    public function checkDT() {
        //$this->load->library('CheckDatabase');
        //$this->checkdatabase->changeEngine();
        $this->load->model('Offer_model');
        $array['offer_id'] = "";
        $array['category_id'] = 755;
        $array['limit_start'] = 1;
        $array['limit_end'] = 0;
        $data = $this->Offer_model->productReport();
        echo $this->db->last_query();
        foreach($data as $products){
            print_r($products);
            echo "<br><br>";
        }
        
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
        $query = $this->db->query($sql, array(
            $schemaComapareArr['TABLE_NAME_LOCAL'],
            $schemaComapareArr['TABLE_SCHEMA_LOCAL'],
            $schemaComapareArr['TABLE_NAME_ONLINE'],
            $schemaComapareArr['TABLE_SCHEMA_ONLINE']
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
        $dbLocalName = 'atzcart_testdb';
        $dbOnlineName = 'atz';

        $dbLocalTableNames = $this->getTableNames($dbLocalName);
        $dbOnlineTableNames = $this->getTableNames($dbOnlineName);

        $localTableCount = count($dbLocalTableNames);
        $onlineTableCount = count($dbOnlineTableNames);

        if ($localTableCount < $onlineTableCount) {
            echo " Local db $dbLocalName is having less table than Online database <br><br>"
            . "Local Table Count = $localTableCount < "
            . "Online Table Count = $onlineTableCount <br>";
        } else if ($localTableCount > $onlineTableCount) {
            echo " Online db $dbOnlineName is having greater table than Local database <br><br>"
            . "Local Table Count = $localTableCount > "
            . "Online Table Count = $onlineTableCount <br>";
        } else {
            echo "Local database == Online database both have equal tables <br><br>"
            . "Local Table Count = $localTableCount ===== "
            . "Online Table Count = $onlineTableCount <br>";
        }

        $notInLocalDatabase = array_diff($dbOnlineTableNames, $dbLocalTableNames);
        $notInOnlineDatabase = array_diff($dbLocalTableNames, $notInOnlineDatabase);

        echo "<br><br>";
        if (count($notInLocalDatabase) != 0) {
            echo "Missing in local database <br>";
            print_r($notInLocalDatabase);
        }
        echo "<br><br>";
        if (count($notInOnlineDatabase) != 0) {
            echo "Missing in online database <br>";
            print_r($notInOnlineDatabase);
        }

        // Sort arrays
        asort($dbLocalTableNames);
        //asort($dbOnlineTableNames);
//        echo"<pre>";
//        print_r($dbLocalTableNames); echo "<br><br><br>";
//        print_r($dbOnlineTableNames);

        echo "<br>Count local db = " . count($dbLocalTableNames);
        echo "<br>Count online db = " . count($dbOnlineTableNames) . '<br><br><br><br>';

        $schemaComapareArr = array();
        //for changes required in local db uncomment this
        //$schemaComapareArr['TABLE_SCHEMA_LOCAL'] = 'atzcart_online';
        //$schemaComapareArr['TABLE_SCHEMA_ONLINE'] = 'atzcart_testdb';
        //for changes required in online db uncomment this
        $schemaComapareArr['TABLE_SCHEMA_LOCAL'] = 'atzcart_testdb';
        $schemaComapareArr['TABLE_SCHEMA_ONLINE'] = 'atz';

        $missingColumnsInOnline = array();

        echo "Missing in online database <br>";
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

}
