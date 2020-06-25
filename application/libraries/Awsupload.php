<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Awsupload {

    private $CI;
    private $s3;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $this->CI->load->helper("file");
        $this->s3 = new Aws\S3\S3Client([
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
    }

    /**
     * @param $folder = destination path to save file
     * @param $inputName =  name of file input control from html form
     * @return false on failed
     * @return String path
     * Valid for only single file upload
     * */
    public function upload($inputName, $folder = "", $mimeTypes = "") {
        $bucket = $this->CI->config->item('bucket'); //path to save on s3 server

        $file_name = $_FILES[$inputName]['name'];
        $extension = new SplFileInfo($file_name);
        $fileExtension = $extension->getExtension();
        $result = $this->checkExtension($fileExtension, $mimeTypes);

        if ($result) {
            try {
                $temp_file_location = $_FILES[$inputName]['tmp_name'];
                $uniqueName = uniqid() . time() . '.' . $extension->getExtension();
                $result = $this->s3->putObject([
                    'Bucket' => $bucket,
                    'Key' => $folder . "/" . $uniqueName,
                    'SourceFile' => $temp_file_location
                ]);
                return $result->get('ObjectURL');
            } catch (Exception $ex) {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @auther Yogesh Pardeshi 12092019 10:30am
     * @param $fileArray = $_FILES array
     * @param $folder =  destination path to save uploaded file
     * @return false on failure, empty if no files uploaded, on success array of file paths
     * */
    public function multiUpload($fileArray, $folder = "", $mimeTypes = "") {
        $bucket = $this->CI->config->item('bucket'); //path to save on s3 server
        $key = array_keys($fileArray)[0]; //for php  4 ,5 and 7
        //$key = array_key_first($fileArray); for php 7.3
        //get count of files uploaded in array
        $totalFiles = count($fileArray[$key]['name']);
        $returnUploadPaths = array();

        for ($i = 0; $i < $totalFiles; $i++) {
            $file_name = $fileArray[$key]['name'][$i];

            $extension = new SplFileInfo($file_name);
            $fileExtension = $extension->getExtension();
            $result = $this->checkExtension($fileExtension, $mimeTypes);
            if ($result) {
                $temp_file_location = $fileArray[$key]['tmp_name'][$i];
                try {
                    $extension = new SplFileInfo($file_name);
                    $uniqueName = uniqid() . time() . '.' . $extension->getExtension();
                    $result = $this->s3->putObject([
                        'Bucket' => $bucket,
                        'Key' => $folder . "/" . $uniqueName,
                        'SourceFile' => $temp_file_location
                    ]);
                    $returnUploadPaths[] = $result->get('ObjectURL');
                } catch (Exception $ex) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return $returnUploadPaths;
    }

    /**
     * @auther Yogesh Pardeshi 12092019 10:30am
     * @param $fileArray = $_FILES array
     * @param $folder =  destination path to save uploaded file
     * @return false on failure, empty if no files uploaded, on success array of file paths
     * */
    public function manyFilesControlUpload($fileArray, $folder) {
        $bucket = $this->CI->config->item('bucket'); //path to save on s3 server
        $filesKeys = array_keys($fileArray); //for php  4 ,5 and 7
        $returnUploadPaths = array();
        $j = 0;
        foreach ($filesKeys as $key) {
            $totalFiles = count($fileArray[$key]['name']);
            $pathIndex = $folder[$j++];
            for ($i = 0; $i < $totalFiles; $i++) {
                $file_name = $fileArray[$key]['name'][$i];
                $temp_file_location = $fileArray[$key]['tmp_name'][$i];
                try {
                    $extension = new SplFileInfo($file_name);
                    $uniqueName = uniqid() . time() . '.' . $extension->getExtension();
                    $result = $this->s3->putObject([
                        'Bucket' => $bucket,
                        'Key' => $pathIndex . "/" . $uniqueName,
                        'SourceFile' => $temp_file_location
                    ]);
                    $returnUploadPaths[$key][] = $result->get('ObjectURL');
                } catch (Exception $ex) {
                    return false;
                }
            }
        }
        return $returnUploadPaths;
    }

    /**
     * @param $fileContent = file content to write
     * @param $filePath =  name of file to save as with full path
     * @return false on failed
     * @return String path
     * */
    public function filePutContents($filePath, $fileContent, $mimeTypes) {
        $bucket = $this->CI->config->item('bucket'); //path to save on s3 server

        $extension = new SplFileInfo($filePath);
        $fileExtension = $extension->getExtension();
        $result = $this->checkExtension($fileExtension, $mimeTypes);
        if ($result) {

            try {
                $result = $this->s3->putObject([
                    'Bucket' => $bucket,
                    'Key' => $filePath,
                    'Body' => $fileContent,
                ]);
                return $result->get('ObjectURL');
            } catch (Exception $ex) {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $filePath =  name of file to save as with full path
     * @return false on failed
     * @return String path
     * */
    public function streamWrapper($filePath) {
        $bucket = $this->CI->config->item('bucket'); //path to save on s3 server
        try {
            $this->s3->registerStreamWrapper();
            return 'https://' . $bucket . '.s3.ap-south-1.amazonaws.com/' .
                    $filePath;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @auther Yogesh Pardeshi 14092019
     * @param $ext = extension
     * @return unique filename.extension
     * @use
     * */
    public function getUniqueName($ext) {
        $uniqueName = uniqid() . time() . '.' . $ext;
        return $uniqueName;
    }

    private function checkExtension($fileExtension, $mimeType) {
        $fileExtension = strtolower($fileExtension);

        switch ($mimeType) {
            case 'image':
                $allowedTypesArr = array('jpg', 'jpeg', 'png', 'svg');
                if (!in_array($fileExtension, $allowedTypesArr)) {
                    return false;
                } else {
                    return true;
                }
                break;
            case 'document':
                $allowedTypesArr = array('pdf', 'docx', 'doc');
                if (!in_array($fileExtension, $allowedTypesArr)) {
                    return false;
                } else {
                    return true;
                }
                break;
            case 'all_document':
                $allowedTypesArr = array('pdf', 'docx', 'doc', 'jpg', 'jpeg', 'png', 'svg', 'xlsx', 'csv', 'xlx');
                if (!in_array($fileExtension, $allowedTypesArr)) {
                    return false;
                } else {
                    return true;
                }
                break;
            case 'company_docs':
                $allowedTypesArr = array('pdf', 'jpg', 'jpeg');
                if (!in_array($fileExtension, $allowedTypesArr)) {
                    return false;
                } else {
                    return true;
                }
                break;
        }
    }

    /**
     * @auther Yogesh Pardeshi 17092019
     * @param $inputName = name of input control and $image for = uploading image for 
     * product, category....
     * @return returns true on success else error message
     * @use
     * */
    public function checkImageSize($inputName, $imageFor) {
        $allowedSize = $this->getAllowedSizes($imageFor);
        $imageInfo = getimagesize($_FILES[$inputName]["tmp_name"]);
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        
        if ($width > $allowedSize['width'] || $height > $allowedSize['height']) {
            return 'File dimension must be between height =' . $allowedSize['height']
                    . ' and width =' . $allowedSize['width'] . ' pixels';
        }
        $fileSize = round(filesize($_FILES[$inputName]["tmp_name"]) / 1024, 2);
        if ($fileSize > $allowedSize['fileSize']) {
            return 'File size must be less than ' . $allowedSize['fileSize']
                    . 'KB. You uploaded ' . $fileSize . ' KB';
        }
        return true;
    }

    /**
     * @auther Yogesh Pardeshi 17092019
     * @param $choice = image size for type e.g. product, category....
     * @return array of allowed size and dimesions
     * @use to upload image only for category, product and banners
     * */
    public function getAllowedSizes($choice) {
        switch ($choice) {
            case 'product':
                return $allowedSize = array('height' => PD_IMG_HT,
                    'width' => PD_IMG_WT,
                    'fileSize' => PD_IMG_SIZE);
                break;
            case 'category':
                return $allowedSize = array('height' => CAT_IMG_HT,
                    'width' => CAT_IMG_WT,
                    'fileSize' => CAT_IMG_SIZE);
                break;
            case 'category_banner':
                return $allowedSize = array('height' => CAT_BANNER_HT,
                    'width' => CAT_BANNER_WT,
                    'fileSize' => CAT_BANNER_SIZE);
                break;
            case 'web_banner':
                return $allowedSize = array('height' => WEB_IMG_HT,
                    'width' => WEB_IMG_WT,
                    'fileSize' => WEB_IMG_SIZE);
                break;
            case 'app_banner':
                return $allowedSize = array('height' => APP_IMG_HT,
                    'width' => APP_IMG_WT,
                    'fileSize' => APP_IMG_SIZE);
                break;
        }
    }

}
