<?php 
ob_start();
session_start();
include('../db-new.php');
include('../db.php');
include('../Web-forms/includes/db1.php');
include('../Web-forms/includes/db-new1.php');

if(empty($_SESSION['username'])){
  header('location:../login.php');
}

$bucket="mcabucket";
require_once('../S3.php');         
//AWS access info
require_once('../../configration.php');
//instantiate the class
$s3 = new S3($awsAccessKey, $awsSecretKey);

$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);

$professionalid = $_SESSION['professionalid'];
$user_id = $_SESSION['user_id'];

$updated = date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');

$timezone =  date('d/m/Y H:i:s A');
// echo $timezone . ' IST';

$tableData = isset($_POST['tableData']) ? str_replace("'","\'",$_POST['tableData']) : '';
$messagecount = isset($_POST['messagecount']) ? $_POST['messagecount'] : '0';
$successmessage = isset($_POST['successmessage']) ? $_POST['successmessage'] : '0';
$failedmessage = isset($_POST['failedmessage']) ? $_POST['failedmessage'] : '0';
$caption = isset($_POST['caption']) ? str_replace("'","\'",$_POST['caption']) : '';
$caption_subject = isset($_POST['caption_subject']) ? str_replace("'","\'",$_POST['caption_subject']) : '';
$message = '';
$filename = '';
$path_attach = '';

if (isset($_FILES["file"])) {
    if($_FILES["file"]["name"] !=''){
     $filename = basename($_FILES['file']['name']);
     $filename = str_replace("%", "_", $filename);
     $filename = str_replace(" ", "_", $filename);
     $filename = str_replace("&", "and", $filename);
  //   $filename = $srn.$filename;
     $tmp_file = $_FILES['file']['tmp_name'];
     $path = "Bulk_WhatsApp";
     $path .= "/".strtotime($updated)."_".$professionalid."_".$filename;
     $path_attach = $path;
     $new_image_name = $path;
     if($s3->putObjectFile($tmp_file, $bucket , $new_image_name, S3::ACL_PUBLIC_READ)) {
         $file_upload_message = "File Uploaded Successfully to amazon S3.<br><br>";  
         $uploaded_file_path='http://'.$bucket.'.s3.amazonaws.com/'.$new_image_name;
         $file_upload_message .= '<b>Upload File URL:</b>'.$uploaded_file_path."<br/>";
         $file_upload_message .= "<img src='$uploaded_file_path'/>";
         $message = "File upload Successfully";
     } else { 
         $file_upload_message = "<br>File upload to amazon s3 failed!. Please try again."; 
         $message = "File upload to amazon s3 failed!. Please try again.";              
     }

    }  
} 

if ($tableData!='') {
    $query = "INSERT INTO `gmail_bulk_result`(user_id,professionalid,tableData,messagecount,successmessage,failedmessage,caption,caption_subject,filemessage,`filename`,path_attach,currenttime) VALUES ('".$user_id."','".$professionalid."','".$tableData."','".$messagecount."','".$successmessage."','".$failedmessage."','".$caption."','".$caption_subject."','".$message."','".$filename."','".$path_attach."','".$timezone."'
    )";
    
    $res = $conn->query($query);
}

?>