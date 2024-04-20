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
require_once('../function-list.php');

$professionalid = $_SESSION['professionalid'];


 $sql112 ="SELECT * FROM `mca_v3` WHERE professionalid = '$professionalid'";
 $result112 = $conn->query($sql112);
 $mca_user_dropdown = '';
 while ($row112=mysqli_fetch_assoc($result112)) {
  $value = $row112['user'].'_break_sring_'.$row112['password'];
  $mca_user_dropdown .= '<option value="'.$value.'">'.$row112['user'].'</option>';
 }

$sqluser ="SELECT `tca_mdb_plans`.eform FROM `users` LEFT JOIN `tca_mdb_visitors_plan` ON `tca_mdb_visitors_plan`.email = `users`.email LEFT JOIN `tca_mdb_plans` ON `tca_mdb_plans`.id = `tca_mdb_visitors_plan`.plan_id WHERE `users`.subscription = 'yes' AND `users`.professionalid= '$professionalid' ";
$resultuser = $conn->query($sqluser);
$rowuser = mysqli_fetch_assoc($resultuser);
$eform = $rowuser['eform'];
if($eform == 'yes') {   
  $tag = 'true';
}else{
  $tag = 'false';
}

$sql5 ="SELECT * FROM `free_trial` WHERE professionalid = '$professionalid'";
$result5 = $conn1->query($sql5);
$rowcount =mysqli_num_rows($result5);
if ($rowcount>0) {
$row5 = mysqli_fetch_assoc($result5);
$due_date = $row5['due_date'];
$subscription = $row5['subscription'];
$today = date('d M Y');
//$today = '18 Dec 2021';
  if (strtotime($today) <= strtotime($due_date)) {
   $show_forms = 'true';
  }else{
   $show_forms = 'false';   
  }
}else{
$show_forms = 'false';     
}
$professionalid_array =array(1,3,4,6,7,63,65,69,88,249,103,2018,317);

if($tag =='true' || in_array($professionalid, $professionalid_array)){
  $eformshow = 'true';
}else{
  $eformshow = 'false';
}

if (isset($_GET['startdate']) && $_GET['startdate']!='') {
  $startfrom = $_GET['startdate'];
  $startfromcon = date('Y-m-d',strtotime(str_replace("/","-",$_GET['startdate'])));
}else{
  if (date('m') > 3) {
    $startfrom = '01/04/'.date('Y');
    $startfromcon = date('Y').'-04-01';
  }else{
    $startfrom = '01/04/'.(date('Y')-1);
    $startfromcon = (date('Y')-1).'-04-01';
  }
}

if (isset($_GET['enddate']) && $_GET['enddate']!='') {
  $enddatecon = date('Y-m-d',strtotime(str_replace("/","-",$_GET['enddate'])));
  $enddate = $_GET['enddate'];
}else{
  $enddate = date('d/m/Y');
  $enddatecon = date('Y-m-d');
}


$where = " AND updated BETWEEN '$startfromcon' AND '$enddatecon' ";


include('../headerrun.php');
?>
<link rel="stylesheet" href="../ageless-js/buttons.dataTables.min.css">
<link rel="stylesheet" href="../ageless-js/jquery.dataTables.min.css">
<style type="text/css">
  /* td{
  border:solid black 1.0pt;
  color: #000;
  padding: 5px;
  font-size: 14pt;
} */
.guideServiceLoading {
    background: url(busy-state.gif) no-repeat fixed center;
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    cursor: wait;
    z-index: 100000;
}

#updatecss {
    width: 100%;
    margin-top: 20px; 
}

#updatecss th, #updatecss td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    width: 11%;
}

#updatecss th {
    background-color: #f2f2f2;
}

</style>

<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
  <div class="container-fluid  dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    
  <div class="product-sales-area mg-tb-30">
    <div class="container-fluid">   
    <div class="row">
      <!-- ============================================================== -->
      <!-- validation form -->
      <!-- ============================================================== -->
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="product-sales-chart">
          <div class="card-body">
         
               <div class="table-responsive1">
                 <div class="guideLoading guideServiceLoading" id="dvloader" style="display: none;"></div>
                <h4>Particulars of DIR-3 KYC (Web)</h4>
                <div style="text-align:right; margin-top: -32px;">                  
                 <?php if ($eformshow=='true' || $show_forms == 'true') { ?>
                        <a id="generatelink" class="btn btn-primary generatelink">Generate Link</a> &nbsp; <a href="dir3kyc-web.php" class="btn btn-primary" >Prepare DIR-3 KYC (Web)</a>
                      <?php }else{ ?>
                          <a onclick="alert('For accessing the feature of E-form Preparation please obtain the paid version.')" class="btn btn-primary" >Prepare DIR-3 KYC (Web)</a>
                   <?php } ?>  
                &nbsp; &nbsp; <a href="../admin/dir3-kyc.php" class="btn btn-primary" ><i class="fa fa-arrow-circle-left"></i> Back</a>
                 </div><br>
                <p style="text-align: right;">To download the email id list of pending DIR3 KYC <a href="exportdirectoremail.php">Click here.</a></p>
                <div class="row">
                  <div class="col-md-6"></div>
                  <div class="col-md-2">
                    <label for="startdate">From Date</label>
                      <input type="text" name="startdate" id="startdate" class="form-control datepicker" value="<?php echo $startfrom; ?>" placeholder="From Date" onchange="checkForm(this); return false;">
                  </div>
                  <div class="col-md-2">
                      <label for="enddate">To Date</label>
                      <input type="text" name="enddate" id="enddate" class="form-control datepicker" value="<?php echo $enddate; ?>" placeholder="End Date" onchange="checkForm(this); return false;">
                  </div>
                  <div class="col-md-2">
                    <a class="btn btn-primary" id="addfilter" style="margin-top: 14%;">Update</a>
                  </div>
                </div>
               <table border="1" class="table table-bordered table-hover"  id="example1" style="width: 99%">
                <thead>
                  <th style="text-align: center;font-size: inherit;vertical-align: middle;">Sr. No.</th>    
                  <th style="text-align: center;vertical-align: middle;">DIN</th>              
                  <th style="text-align: center;vertical-align: middle;">Name</th>
                  <th style="text-align: center;vertical-align: middle;">SRN of form</th>
                  <th style="text-align: center;vertical-align: middle;">MCA User</th>
                  <th style="text-align: center;vertical-align: middle;">Last updated on</th>
                  <th style="text-align: center;vertical-align: middle;">Action</th>
                  <th style="text-align: center;vertical-align: middle;">Submit on MCA</th> 
                </thead>
                <tbody>
                    <?php 
                  $sql4 ="SELECT id,updated,DIN,directorname,login,srNumber,form_filled,referenceNumber,downloaddmsid,transactionId,confirmation_label FROM `dir3_kyc_web` WHERE professionalid = '".$professionalid."' $where ORDER BY updated DESC";
                  $result4 = $conn1->query($sql4);
                  $i = 1;
                  while($row12=mysqli_fetch_assoc($result4)){
                    $form_id = $row12['id'];

                    if($row12['updated'] == "" || $row12['updated'] == "0000-00-00" || $row12['updated'] == "0000-0-0" || empty($row12['updated']) || !isset($row12['updated']))  
                      { 
                        $updated = '';
                      }else{
                        $updated = str_replace("-", "/", date('d-m-Y',strtotime($row12['updated'])));
                      } 
                      if ($row12['login']!='') {
                        $username_array = explode("_break_sring_", $row12['login']);
                        $username = $username_array[0];
                      }else{
                        $username = '';
                      }
                  $status = get_srn_status($row12['srNumber']);
                  if ($status=='') {
                    $status = 'Pay Fees From MCA Portal';
                  }
                  
                   ?>
                   <tr id="<?php echo $row12['id']; ?>">
                     <td style="text-align: center;font-size: inherit;"><?php echo $i; ?></td>
                     <td style="text-align: center;font-size: inherit;"><input type="hidden" name="username_upload" id="username_upload_<?php echo $row12['id']; ?>" value="<?php echo $row12['login']; ?>"><input type="hidden" name="refrence_id" id="refrence_id_<?php echo $row12['id']; ?>" value="<?php echo $row12['referenceNumber']; ?>"><input type="hidden" name="srn_value" id="srn_value_<?php echo $row12['id']; ?>" value="<?php echo $row12['srNumber']; ?>"><?php echo $row12['DIN']; ?></td>
                     <td style="text-align: center;font-size: inherit;"><?php echo $row12['directorname']; ?></td>
                     <td style="text-align: center;font-size: inherit;"><?php echo $row12['srNumber']; ?></td>              
                     <td style="text-align: center;font-size: inherit;"><?php echo $username; ?></td>
                     <td style="text-align: center;font-size: inherit;"><?php echo $updated; ?></td> 
                     <?php
                      if ($row12['downloaddmsid']!='') { ?>
                        <td style="text-align: center;font-size: inherit;"><?php echo $status; ?></td>
                        <td style="text-align: center;font-size: inherit;"><a class="btn btn-primary downloaddocument" id="<?php echo $row12['downloaddmsid']; ?>">Download</a>
                        </td>

                      <?php }else{ ?>
                          <td style="text-align: center;font-size: inherit;"><a href="dir3kyc-web.php?form_id=<?php echo $row12['id']; ?>" ><i class="fa fa-pencil"></i></a> &nbsp; / &nbsp; <a  class="remove delete"><i class="fa fa-trash" style="color: blue;"></i></a></td>
                      <?php if ($row12['confirmation_label']=='Y') { ?>
                          <td style="text-align: center;font-size: inherit;"><a id="submitform" class="btn btn-primary generate">Submit</a>
                             <?php if ($row12['downloaddmsid']!='') { ?>
                              <a class="btn btn-primary downloaddocument" id="<?php echo $row12['downloaddmsid']; ?>">Download</a>
                            <?php } ?>
                          </td>
                        <?php }else{ ?> 
                             <td style="text-align: center;font-size: inherit;"><a id="showresponse" class="btn btn-primary">Response</a>
                          </td>
                        <?php } ?>
                     <?php } ?> 

                   </tr>
                   <?php $i++; }?> 
                </tbody>
                  
                </table>
                  
  </div>
<div style='display:none'>
<div id='dscInForm' style='padding:10px; background:#fff;'>
  <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header" style="margin-top:0px;text-align:center">
         <small><h4 style="color: black;">Select MCA User ID</h4></small>
       </h1>
   <form action="" method="post" id="fupForm" enctype="multipart/form-data">
    <input type="hidden" name="web_form_id" id="web_form_id">
    <input type="hidden" name="web_form_type" id="web_form_type">
    <div class="row" style="margin-left: 0px;">
      <div class="col-xs-12 col-sm-3 col-md-9 form-row">
        <select name="mca_user" id="mca_user" style="width: 100%;">
          <option value="">Select MCA User</option>
          <?php echo $mca_user_dropdown; ?>                                          
        </select>
      </div> 
      <div class="col-xs-12 col-sm-3 col-md-2" style="padding: 6px;">
         <a href="javascript:void(0)" class="btn btn-primary fill_form" style="margin-left: 10px;">Submit</a>   
      </div>    
    </div>
       
   </form>


     </div>
   </div>
  </div>
  </div>

<div style='display:none'>
<div id='dir3kyclink' style='padding:10px; background:#fff;'>
  <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header" style="margin-top:0px;text-align:center">
         <small><h4 style="color: black;">Generate Automated KYC Link for your clients</h4></small>
       </h1>
   <form action="" method="post" id="fupForm" enctype="multipart/form-data">
    <div class="row" style="height: auto;">
      <div class="col-xs-12 col-sm-12 col-md-12" style="height: auto;">
              <p style="text-align: justify;padding: 2%;">Dear User, <br><br>You can share this link with your clients for updating the KYC automatically. The client will enter the OTPs and confirm the details and the KYC will be updated on MCA. The status will be updated alongwith this in your KYC list.<br> <br>The MCA user you select here will be used for updating the KYC on MCA.</p>

      </div>
    </div>
    <div class="row" style="margin-left: 0px;">
      <div class="col-xs-12 col-sm-3 col-md-6 form-row">
        <select name="genrateuser" id="genrateuser" style="width: 100%;">
          <option value="">Select MCA User</option>
          <?php echo $mca_user_dropdown; ?>                                          
        </select>
      </div> 
      <div class="col-xs-12 col-sm-3 col-md-2" style="padding: 6px;">
         <a href="javascript:void(0)" class="btn btn-primary generatelinks" style="margin-left: 10px;">Generate Link</a>   
      </div>    
    </div>
    <label class="generatedlink" style="display: none;">Email Subject</label>
    <div class="row generatedlink" style="margin-left: 0px;height: auto;width: 99%;display: none;" id="copytemplate">
      <input type = "text" name="caption_subject" id ="caption_subject" style="width:100%;" required>
  </textarea>
</div>
<label class="generatedlink" style="display: none;">Email Template</label>
    <div class="row generatedlink" style="margin-left: 0px;height: auto;width: 99%;display: none;" id="copytemplate">
    <div id="caption_message_container" style="font-family: Times New Roman;">
    <p>Dear Sir/Ma'am,</p><br/>
    <p style="text-align: justify;font-family: Times New Roman">As per the provisions of Companies Act, 2013, the KYC details of every DIN are required to be updated for the Financial Year 2023-24.</p><br/>
    <p style="text-align: justify;font-family: Times New Roman">We are sharing a link herewith for updating the information.</p><br/>
    <p style="text-align: justify;font-family: Times New Roman">Process to be followed:</p><br/>
    
        <li><p style="text-align: justify;font-family: Times New Roman">1. After opening the link, you will need to enter your name and date of birth. You will be displayed with the result out of which you have to select your DIN.</p></li><br/>
        <li><p style="text-align: justify;font-family: Times New Roman">2. Click on the send OTP button, you will receive OTP on your registered mobile number and Email ID.</p></li><br/>
        <li><p style="text-align: justify;font-family: Times New Roman">3. Enter the OTPs and click on verify OTP button.</p></li><br/>
        <li><p style="text-align: justify;font-family: Times New Roman">4. When you click on next button you will be displayed with the information of your DIN.</p></li><br/>
        <li><p style="text-align: justify;font-family: Times New Roman">5. Verify if all the data is correct, click on verification checkbox and submit.</p></li><br/>
        <li><p style="text-align: justify;font-family: Times New Roman">6. If there is any change in your data, then select the change information checkbox.</p></li><br/>
        <li><p style="text-align: justify;font-family: Times New Roman">7. System will ask you to enter the changed information.</p></li><br/>
        <li><p style="text-align: justify;font-family: Times New Roman">8. Enter the information and attach necessary attachment and submit.</p></li><br/>
          <p style="text-align: justify;font-family: Times New Roman">{kyc_link}
        </p><br/>

    <p style="text-align: justify;font-family: Times New Roman">Please connect with us if you have any questions.</p><br/>
    <p style="font-family: Times New Roman;font-weight: bold;">Contact person: [Name] <br/>Email: [Email] <br/>Mobile Number: [Mobile Number] <br/> <br/>Thanks & Regards</p>
</div>
    </div>
    <div class="row generatedlink" style="display: none;width: 99%;margin-left: 0px;">
       <div class="col-xs-12 col-sm-12 col-md-12" align="right">
       <a class="btn btn-primary" id="authenticateandsendmail">Send mail</a>
         <a onclick="copyToClipboard()" class="btn btn-primary copytemplate"><i class="fa fa-clone" aria-hidden="true"></i> Copy Template</a>
       </div>      
    </div>
   </form>
     </div>
   </div>
  </div>
  </div>


  <div style='display:none'>
    <div id='dscInForm3' style='padding:10px; background:#fff;'>
      <div class="row">
          <div class="col-lg-12">
             <h1 class="page-header" style="margin-top:0px;text-align:center">
             <small><h4 style="color: black;">Error Log</h4></small>
           </h1>
           <div>
            <ol id="errorlog">
              
            </ol>
             
           </div>
          </div>
       </div>
      </div>
  </div>

   <div style='display:none'>
    <div id='directorresponse' style='padding:10px; background:#fff;'>
      <div class="row">
          <div class="col-lg-12">
             <h1 class="page-header" style="margin-top:0px;text-align:center">
             <small><h4 style="color: black;">Director's Response</h4></small>
           </h1>
           <div>
            <div class="directorresponse" style="padding: 2%;padding-top: 0%;"></div>
              <table  border="1" class="table table-bordered table-hover" style="width: 99%">
                  <thead>
                     <th style="text-align:center;">Sr. No.</th>
                     <th>Type of Change</th>
                     <th>Description</th>
                     <th>Attachments</th>
                  </thead>
                  <tbody id="gettablebody">
                    
                  </tbody>
              </table>
           </div>
          </div>
       </div>
      </div>
  </div>

  
</div>
</div>
<!-- ============================================================== -->
<!-- end validation form -->
<!-- ============================================================== -->
</div>


</div>

 <!-- <div style="text-align: center;"><span id="initalcount">0</span>/<span id="finalcount">0</span></div>
 <div id="progressbar-container" style="display: none;">
        <div id="progressbar"></div>
        
    </div> -->

       <table id="colorboxTable">
                <thead>
                    <tr>
                    </tr>
                </thead>
                <tbody id="updatecss"></tbody>
            </table>
        </div>
    </div>

<div style='display:none'>
    <div id='showcaption' style='padding:10px; background:#fff;'>
      <div class="row">
          <div class="col-lg-12">
             <h1 class="page-header" style="margin-top:0px;text-align:center">
             <small><h4 style="color: black;">Message</h4></small>
           </h1>
       <form action="" method="post" id="fupForm1" enctype="multipart/form-data">
        <div class="row" style="margin-left: 0px;">
          <div class="col-xs-12 col-sm-3 col-md-11">
               <p id="putcaption" style="text-align:justify;padding:10px;"></p>
          </div>
        </div>
           
       </form>

         </div>
       </div>
      </div>
</div>


<?php include('../footernew.php');?>
<script src="../Web-forms/includes/etc.clientlibs\mca\clientlibs\clientlib-user--registration.min.js"></script>
<script src="../Web-forms/includes/etc.clientlibs\mca\clientlibs\clientlib-runllp.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>

<script src="../admin/sha1.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
  // Array holding selected row IDs
  var rows_selected = [];
  var table = $('#example1').DataTable({
    'dom': 'Bfrtip',
      // Configure the drop down options.
      lengthMenu: [
      [ 10, 25, 50, -1 ],
      [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      // Add to buttons the pageLength option.
      buttons: [
      'pageLength',{
      extend: 'excel',
      exportOptions: {
      columns: [0,1,2,3,4,5] 
      }
      }  
      ]
  });
});

$(".datepicker").datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    yearRange: "c-50:c+50"
  });

function copyToClipboard() {
    // Get the div element
    const div = document.getElementById("copytemplate");
    
    // Select the text content of the div
    const range = document.createRange();
    range.selectNodeContents(div);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    
    // Copy the selected content to the clipboard
    document.execCommand("copy");
    
    // Deselect the content
    window.getSelection().removeAllRanges();
  }

$("#addfilter").click(function(){

  var startdate = $("#startdate").val();
  var enddate = $("#enddate").val();

  if (startdate!='' && enddate!='') {
    window.location.href = 'home.php?startdate='+startdate+'&enddate='+enddate;
  }

});

$("#startdate,#enddate").change(function(){
  var startdate = $("#startdate").val();
  var enddate = $("#enddate").val();

  if (startdate!='' && enddate!='') {
    startdate = change_format(startdate);
    enddate = change_format(enddate);
    if (startdate > enddate) {
      alert('Invalid Date!');
      this.value = '';
    }
  }

});

  $( ".generate" ).click(function() {
    var id =  $(this).parents("tr").attr("id");
    var classname = $(this).attr("id");
    $("#web_form_id").val(id);
    $("#web_form_type").val(classname);
    $.colorbox({inline:true, width:"600px", height:"200px", href:"#dscInForm" , scrolling:false});
});

$( "#showresponse" ).click(function() {
    var form_id =  $(this).parents("tr").attr("id");
    
    $.ajax({
       url: 'getreponsedata.php',
       type: 'POST',
       data: {form_id: form_id},
       success: function(data) {
            $("#gettablebody").html(data);  
       }
    });

   $.colorbox({inline:true, width:"800px", height:"400px", href:"#directorresponse" , scrolling:'auto'});
});

$( ".generatelink" ).click(function() {
    $.colorbox({inline:true, width:"1000px", height:"500px", href:"#dir3kyclink" , scrolling:true});
});

$( ".upload" ).click(function() {
    var id =  $(this).parents("tr").attr("id");
    $("#uploadid").val(id);
    $.colorbox({inline:true, width:"600px", height:"200px", href:"#dscInForm2" , scrolling:false});
});

 function clearFileInput(ctrl) {
  try {
    ctrl.value = null;
  } catch(ex) { }
  if (ctrl.value) {
    ctrl.parentNode.replaceChild(ctrl.cloneNode(true), ctrl);
  }
}

$.get("https://ipinfo.io", function(response) {
           localStorage.setItem("clientIp",response.ip);
        }, "json")


$(".delete").click(function(){
    var form_id = $(this).parents("tr").attr('id');
      if(confirm('Are you sure you want to remove this record ?'))
        {
            $.ajax({
               url: 'deleteform.php',
               type: 'POST',
               data: {form_id: form_id},
               success: function(data) {
                    $("#"+form_id).remove();
                    alert("Record removed successfully");  
               }
            });
        }
  });
  

  $(".generatelinks").click(function(){
    var value = $('#genrateuser').val();
    var professionalid = '<?php echo $professionalid; ?>';
    if (value != '') {
        var split_sting = value.split("_break_sring_");
        if (split_sting.length != 2) {
            alert('Invalid UserId.');
        } else {
            var username = split_sting[0].toUpperCase();   

            var post_data = "data=" + btoa(username) + "&key=" + btoa(professionalid);
            var link = 'https://complyrelax.com/Dashboard-CS/DIR3-KYC(Web)/dir3kyc.php?' + post_data;

            // Update the HTML content with the generated link
            const htmlContent = quill.root.innerHTML;
            const modifiedHtmlContent = htmlContent.replace('{kyc_link}', link);
            quill.root.innerHTML = modifiedHtmlContent;

            // Show the generated link
               $(".generatedlink").show();
        }
    } else {
        alert('Select MCA User.');
    }
});

$(".fill_form").click(function(){
$.colorbox.close();
$('#dvloader').show();
var web_form_id = $("#web_form_id").val();
var value = $('#mca_user').val();
  if (value!='') {
     var split_sting = value.split("_break_sring_");
     if (split_sting.length!=2) {
       alert('Invalid UserId.');
     }else{
      var username = split_sting[0].toUpperCase();
      var password = split_sting[1];
      var password13 = calcSHA1(password);
      var clientIp = localStorage.getItem("clientIp");
      var deviceId = localStorage.getItem("deviceId");
      if(deviceId === null){
        //deviceId = Math.random().toString(36).slice(2) +      
        deviceId = Math.random().toString(36).slice(2);     
        localStorage.setItem("deviceId",deviceId);     
      }     
    //var folder = getRandomString(5) + uniqueID();
    var data = "requestType=" + "login" + "&userName=" + username + "&password=" + password13 + "&deviceId=" + deviceId + "&clientIp=" + clientIp;
    var post_data = "data=" + encrypt(data);
    var integrationId = parseInt(Math.random() * 10000000);
    var loginurl = 'get_form_query.php';

    $.ajax( {
      type: "POST",
      url: loginurl,
      data: {web_form_id:web_form_id,username:username,integrationId:integrationId,post_data:post_data},
      success: function( response ) {
       console.log(response);
       var form_query = encodeURIComponent(response);
        $.ajax({
               url: 'fill_dir3kyc.php',
               type: 'POST',
               data: {post_data: post_data,form_query:form_query},
               success: function(data) {
                console.log(data);
                var form_data = JSON.parse(data).resStr;
                var response_data = JSON.parse(form_data).data;
                console.log(response_data);
                var applicationId = parseInt(Math.random(200000)*1000000);
                 if (typeof response_data.srn !== 'undefined') {
                  var srn = response_data.srn;
                }else{
                  var srn = response_data.srNumber;
                }
                var afSubmissionTime = new Date().valueOf();
                if (JSON.parse(form_data).message.toLowerCase() == "data added successfully") {
                    $.ajax({
                       url: 'update_form_srn.php',
                       type: 'POST',
                       data: {web_form_id: web_form_id,response_data:response_data,username:username,afSubmissionTime:afSubmissionTime,applicationId:applicationId,srn:srn,value:value},
                       success: function(data_response) {
                        console.log(data_response);
                          var form_query1 = encodeURIComponent(data_response.data_quary);
                          var form_query2 = encodeURIComponent(data_response.metadata);
                          var formName = 'DIR-3KYC';
                          var totalamount = 0;
                          var intId = response_data.integrationId;
                          var CIN = '';
                          $.ajax({
                               url: 'downloadpdf.php',
                               type: 'POST',
                               data: {form_query1: form_query1,post_data:post_data,srn:srn,form_query2:form_query2,web_form_id:web_form_id,value:value},
                               success: function(data1) {
                                    console.log(data1);
                                    $('#dvloader').hide();                                  
                                   window.open('https://www.mca.gov.in/bin/mca/dms/dmsdownloadmultipledocuments?mds='+encrypt(data1)+'&type=download&action=downloaddocument');
                                   alert('KYC has been submited on MCA, you are requested to go to MCA for confiming the same using the \'pay fees\' option.');  
                                   location.reload();                                  
                               }
                            });
                       }
                    });
                }else{
                 var validationResponse = JSON.parse(form_data);
                 var validationResponce1 = validationResponse.validationResponce;
                 if (validationResponce1.submissionRestricted=='Y') {
                  var error = validationResponce1.validationResponseBody;
                   $.ajax({
                               url: 'showerror.php',
                               type: 'POST',
                               data: {error: error,response_data:response_data,web_form_id:web_form_id},
                               success: function(data1) {
                                    console.log(data1);
                                  $("#errorlog").html(data1);
                                  $('#dvloader').hide();
                                $.colorbox({inline:true, width:"auto", height:"auto", href:"#dscInForm3" , scrolling:false});
                               }
                            });
                 }else{
                   alert('Something went wrong.');
                 }
                }        
               }
            });
      }
    });

    }
  }else{
    alert('Select MCA User.');
  }
});

$("#fupForm1").on('submit', function(e){
e.preventDefault();
$.colorbox.close();
$('#dvloader').show();
var uploadid = $("#uploadid").val();
var value = $('#username_upload_'+uploadid).val();
var refrence_id = $('#refrence_id_'+uploadid).val();
var srn_value = $('#srn_value_'+uploadid).val();

var split_sting = value.split("_break_sring_");
var username = split_sting[0].toUpperCase();
var password = split_sting[1];
var password13 = calcSHA1(password);
var clientIp = localStorage.getItem("clientIp");
var deviceId = localStorage.getItem("deviceId");
if(deviceId === null){
  //deviceId = Math.random().toString(36).slice(2) + clientIp;
  deviceId = Math.random().toString(36).slice(2);
  localStorage.setItem("deviceId",deviceId);
}

var data = "requestType=" + "login" + "&userName=" + username + "&password=" + password13 + "&deviceId=" + deviceId + "&clientIp=" + clientIp;

var post_data = "data=" + encrypt(data);
var dmsfolder = parseInt(Math.random() * 100000000);
var formdata = new FormData(this);
formdata.append('post_data',post_data);
formdata.append('dmsfolder',dmsfolder);
formdata.append('refrence_id',refrence_id);
formdata.append('srn_value',srn_value);
formdata.append('username',username);
$.ajax({
   url: 'uploadpdf.php',
   type: 'POST',
   enctype: 'multipart/form-data',
   data: formdata,
   processData: false,
   contentType: false,
   success: function(data1) {
        console.log(data1);
        $('#dvloader').hide();
        if (data1.SubmissionRestricted=='Y') {
         $("#errorlog").html(data1.message);
          $.colorbox({inline:true, width:"auto", height:"auto", href:"#dscInForm3" , scrolling:false});
        }else{
          alert(data1.message);
          location.reload();
        } 
   }
});

});

$('#uploadchg4').on('change', function() {
  var file_size = (this.files[0].size / 1024 / 1024).toFixed(2)
  if (file_size>10) {
    alert("File size cannot be greater than 10 MB.");
    clearFileInput(document.getElementById("uploadchg4"));
  }
});

$(".downloaddocument").click(function(){
  $('#dvloader').show();
  window.open('https://www.mca.gov.in/bin/mca/dms/dmsdownloadmultipledocuments?mds='+encrypt(this.id)+'&type=download&action=downloaddocument');
  $('#dvloader').hide();
});

function change_format(madte){
  from = madte.split("/");
    f = new Date(from[2], from[1] - 1, from[0]);
   return f;
}


async function Sendgmailauthentication(originUrl) {
    try {
        const response = await fetch(`../gmailbulk/authenticate.php?originUrl=${encodeURIComponent(originUrl)}`, {
            method: 'GET',
            credentials: 'include',
        });
        const data = await response.json();
        console.log('Received response from the server:', data);
        
        if (data.authUrl) {
            // If authentication is needed, redirect user to the authentication URL
            window.location.href = data.authUrl;
        } else {
            openColorboxPopup();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Function to retrieve subject and message from the database and open Colorbox popup
function openColorboxPopup() {
    // Retrieve subject and message from the database
    $.ajax({
        url: 'retrivemessage.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var subject = data.subject;
            var message = data.message;

            // Construct table HTML
            var manualRowHTML = '<tr><td>1</td><td>Harshit</td><td>singhalharshit721@gmail.com</td></tr>';
            var tableHTML = '<table id="colorboxTable">';
            tableHTML += '<thead><tr></tr></thead>';
            tableHTML += '<tbody id="updatecss"><tr><th>Sr. No.</th><th>Name</th><th>Email</th></tr>' + manualRowHTML + '</tbody></table>';

            // Display the Colorbox popup
            $.colorbox({
                html: tableHTML,
                width: "65%",
                height: "65%",
                onComplete: function() {
                    // Call sendmail.php API with required data
                    var emailAddresses = ['singhalharshit721@gmail.com']; // Manually added email address
                    var data = {
                        captionSubject: subject,
                        captionMessage: message,
                        emails: emailAddresses
                    };

                    $.ajax({
                        url: '../gmailbulk/sendgmail.php',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function(response) {
                            console.log('Emails sent successfully:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error sending emails:', error);
                        }
                    });
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error retrieving data from database:', error);
        }
    });
}


function saveDataToDatabase(subject, message, professionalId) {
    return new Promise((resolve, reject) => {
      
        $.ajax({
            url: 'savemessage.php',
            type: 'POST',
            data: {
                subject: subject,
                message: message,
                professionalId: professionalId 
            },
            success: function(response) {
                console.log('Data saved to database successfully:', response);
                resolve(); // Resolve the promise after successfully saving data
            },
            error: function(xhr, status, error) {
                console.error('Error saving data to database:', error);
                reject(error); // Reject the promise if there's an error
            }
        });
    });
}

// Event listener for the button click
const authenticateandsendmail = document.getElementById('authenticateandsendmail');
authenticateandsendmail.addEventListener('click', async () => {
    const originUrl = window.location.href;
    const subject = $('#caption_subject').val();
    const message = quill.root.innerHTML; // Get Quill editor content

    try {
      var professionalId = '<?php echo $professionalid; ?>';
      console.log('professionalId', professionalId);
        // Save data to the database
        await saveDataToDatabase(subject, message, professionalId);

        // Proceed with authentication
        await Sendgmailauthentication(originUrl);
    } catch (error) {
        console.error('Error:', error);
    }
});

// Check if the page was redirected back after authentication
window.addEventListener('load', () => {
    // Check if there is a query parameter indicating authentication success
    const params = new URLSearchParams(window.location.search);
    if (params.has('authenticated')) {
        // If authenticated, open Colorbox popup
        openColorboxPopup();
        // Remove the query parameter to prevent opening the popup multiple times
        history.replaceState(null, document.title, window.location.pathname);
    }
    
    // Check if there is a query parameter for authentication type
    const authenticationTypeParam = params.get('authenticationtype');
    if (authenticationTypeParam === 'DIR3-KYC(Web)') {
        // If authentication type is DIR3-KYC(Web), open Colorbox popup
        openColorboxPopup();
    }
});

const toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],     // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent                  // text direction

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
  [{ 'font': [] }],                                    
];

const quill = new Quill('#caption_message_container', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});


</script>

 




<!-- function openColorboxPopup() {
    $.ajax({
        url: 'exportdirectoremail.php',
        type: 'GET',
        success: function(response) {
            // Extract names and emails from the response
            var rows = $(response).find('tr').not(':first'); // Exclude the first row (header row)
            var emailHTML = '';
            var serialNumber = 1;
            var emailAddresses = []; // Array to store email addresses

            rows.each(function() {
                var columns = $(this).find('td');
                var name = columns.eq(1).text().trim();
                var email = columns.eq(3).text().trim();
                // Check if the email is not empty before adding the row
                if (email !== '') {
                    emailHTML += '<tr><td>' + serialNumber + '</td><td>' + name + '</td><td>' + email + '</td></tr>';
                    serialNumber++;
                    emailAddresses.push(email); // Add email to the array
                }
            });

            // Construct table HTML with headers and data
            var tableHTML = '<table id="colorboxTable">';
            tableHTML += '<thead><tr></tr></thead>';
            tableHTML += '<tbody id="updatecss"><tr><th>Sr. No.</th><th>Name</th><th>Email</th></tr>' + emailHTML + '</tbody></table>';

            // Display the Colorbox popup
            $.colorbox({
                html: tableHTML,
                width: "65%",
                height: "65%",
                onComplete: function() {
                    // Call sendmail.php API with required data
                    var captionSubject = document.getElementById('caption_subject');
                    var captionMessage = document.getElementById('caption_message');
                    var data = {
                        captionSubject: captionSubject,
                        captionMessage: captionMessage,
                        emails: emailAddresses
                    };
                    $.ajax({
                        url: 'sendmail.php',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function(response) {
                            console.log('Emails sent successfully:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error sending emails:', error);
                        }
                    });
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data from exportdirectoremail.php:', error);
        }
    });
} -->