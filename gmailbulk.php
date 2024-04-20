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

//   echo "<pre>";
//   print_r($_SESSION);exit;

$limitcount = 0;
$remainingLimitCount = 10 - $limitcount;
$paiduser = "true";
$professionalid = $_SESSION['professionalid'];

include('../headerrun.php');

?>

<link rel="stylesheet" href="../ageless-js/buttons.dataTables.min.css">
<link rel="stylesheet" href="../ageless-js/jquery.dataTables.min.css">
<style>

#imageForm {
    justify-content: space-between;
    background-color: rgba(255, 255, 255, 0.9);
    padding: 20px;
    width: 100%;
}

#caption_subject {
    margin: -2px;
    font-size: 16px;
    padding: 6px 10px;
    border-radius: 5px;
    cursor: pointer;
    height: 40px;
    width: 92%;
    color: black;
    margin-left: 23px;
}

#caption_message {
    margin: -1px 3px;
    font-size: 16px;
    padding: 6px 10px;
    border-radius: 5px;
    cursor: pointer;
    height: 173px;
    width: 95%;
    color: black;
    margin-left: 14px;
}

.submit {
    height: 3rem;
    margin-top: 41rem;
}

.block {
    display: block;
    color: white;
    font-size: 15px;
    text-decoration: none;
    position: relative;
    cursor: pointer;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s, font-size 0.3s, font-weight 0.3s, color 0.3s;
    background-color: #141c27;
}

#imagePreview {
    max-width: 100%;
    max-height: 100%;
}

#right-section img {
    max-width: 100%;
    height: 82vh;
}

#excelPreview {
    overflow: auto;
    width: 100%;
}

#excelPreview table {
    width: 100%;
    border-collapse: collapse;
}

#excelPreview td, #excelPreview th {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
    overflow: auto;
    font-size:medium;
}

#excelPreview th {
    background-color: #f2f2f2;
    overflow: auto;
    font-weight:bold;
}

.message-placeholder {
    margin-bottom: 10px;
}

.message-status {
    font-weight: bold;
    margin-left: 10px;
}

.success {
    color: green;
}

.failure {
    color: red;
}

#sjs-A1,#sjs-B1,#sjs-C1{
    color: black;
}

#clearExcelDataContainer {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    transition: opacity 0.2s;
    }

.modal-content {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    max-width: 400px;
    overflow: hidden;
}

#qrImage {
    max-width: 100%;
    max-height: 300px;
    display: block;
    margin: 0 auto;
}



/* .loader-container {
position: fixed;
z-index: 2;
background-color: rgba(0, 0, 0, 0.7);
width: 100%;
height: 100%;
} */

.loader-qrcode {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 50px;
    height: 50px;
    border: 6px solid #f3f3f3;
    border-top: 6px solid #3498db;
    border-radius: 50%;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

.loader-color-loader{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 50px;
    height: 50px;
    border: 6px solid #f3f3f3;
    border-top: 6px solid #3498db;
    border-radius: 50%;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

.closeButton{
    float: right;
    font-size: 21px;
    font-weight: 1700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: .2;
    cursor: pointer;
    font-size: 39px;
    margin: -21px -12px;
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

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

#progressbar-container {
    display: none;
    height: 20px;
    background-color: #f1f1f1;
    border-radius: 5px;
    margin-bottom: 20px;
}

#progressbar {
height: 83%;
width: 0;
background-color: #4caf50;
border-radius: 5px;
}

.row {
    margin-right: -28px;
    margin-left: -28px;
    margin-bottom: 15px;
}




.box {
  border: 1px solid #ccc;
  padding: 20px;
  width: 98%;
  margin: 8px;
  overflow-x: hidden;
}

.input-container {
  margin-bottom: 15px;
}

.input-container label {
  display: block;
  width: 100px;
}

.input-container input[type="text"],
.input-container textarea {
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.input-container textarea {
  height: 175px;
}
.ql-toolbar.ql-snow {
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
    padding: 8px;
    height: 45px;
}

</style>
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
        <div class="row">
            <div class="col-md-4">
                 <h4 style=""><i class="fa fa-envelope"></i> Bulk Gmail Sender</h4>
            </div>
            <div class="col-md-8" align="right">
            <button id="improtDirector" type="button" class="btn btn-primary">Director Database</button> 
            <button id="importshareholder" type="button" class="btn btn-primary">Shareholder Database</button> 
            <button id="logoutButton" type="button" class="btn btn-primary">Log out</button>

            <button id="authenticateButton" type="button" class="btn btn-primary">Authentication</button> 
            </div>
        </div> 
        <div class="portlet-title">
    <form id="imageForm" action="sendgmail.php" method="POST" enctype="multipart/form-data">
        <div class="row" style="height:auto;width:105%;">
            <div class="col-md-6 form-row" style="height: 35rem;overflow-x: hidden;">
                <label for="excelFile" class="block">Upload Excel of Gmail </label>
                <div class="row">
                    <div class="col-md-12 form-row" style="margin-left: 29px;width: 90%;">
                        <input type="file" name="excelFile" id="excelFile" accept=".xlsx" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-left: 16px;">
                        <button id="downloadTemplate" type="button" class="btn btn-primary">Excel Template</button>
                        <button id="clearExcelData" type="button" class="btn btn-primary">Clear Mails</button>
                    </div>
                </div>
                <div id="excelPreview">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Check if the 'masterTableData' key is present in the POST data
                        if (isset($_POST['masterTableData'])) {
                            // Decode the JSON data sent from the JavaScript
                            $masterTableData = json_decode($_POST['masterTableData'], true);

                            // Check if there is any data
                            if (!empty($masterTableData)) {
                                // Output the table with header row
                                echo '<table border="1">';
                                echo '<tbody>';
                                echo '<tr>';
                                echo '<th style="width: 12%;">Sr No.</th>';
                                echo '<th>Gmail</th>';
                                echo '</tr>';

                                // Output the data rows
                                if (is_array($masterTableData)) {
                                    // Ensure sequential order starting from 1
                                    $counter = 1;
                                    foreach ($masterTableData as $row) {
                                        echo '<tr>';
                                        echo '<td>' . $counter++ . '</td>';
                                        echo '<td>' . $row['Gmail'] . '</td>';
                                        echo '</tr>';
                                    }
                                }
                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo 'No data received.';
                            }
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="col-md-6 form-row" style="height: 35rem;overflow-x: hidden;" >
                    <label for="subject" class="block">Subject</label>
                <div class="row">
                    <div class="col-md-12 form-row" >
                    <textarea name="caption_subject" id="caption_subject" placeholder="Type your message here..." required></textarea>
                    </div>
                </div>
                <label for="caption" class="block" style="margin-top: -10px; !important;">Message</label>
                <div class="row">
                    <div class="col-md-12">
                        <div id="editor" style="height: 100px;">
                        <textarea name="caption_message" id="caption_message" placeholder="Type your message here..." required></textarea>
                        </div>
                    </div>
                </div>
                <label for="attachmentFile" class="block" style="margin-top: -10px" >Attachment</label>
                <div class="row">
                    <div class="col-md-12 form-row" style="margin-left: 29px; width: 529.3438px !important;">
                        <input type="file" name="attachmentFile" id="attachmentFile" accept=".jpg, .jpeg, .png, .pdf, .zip, .doc, .docx, .xls, .xlsx">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="right">
                <input type="submit" id="Send-Message" type="button"  value="Send Message" class="btn btn-primary">
            </div>
        </div>

        <?php if ($paiduser != 'true') {
            $limitbulk = 10;
            ?>
            <div class="col-md-12" align="center" style = "font-weight: bold;">
           <span id="remainingLimit"><?php echo $remainingLimitCount; ?></span>/<span id="totalCount"><?php echo $limitbulk; ?></span> Free Gmail Campaign Available.
        </div>
        <?php } ?>
    </form>


    <h4>Previous Gmail Campaigns</h4>
    <div class="table-responsive">
    <table class="table table-bordered table-hover" id="example1">
        <thead>
            <th style="text-align: center; font-size: inherit;">Sr. No.</th>
            <th style="text-align: center;">Date of Sending Message</th>
            <th style="text-align: center;">Sent By</th>
            <th style="text-align: center;">Total mails</th>
            <th style="text-align: center;">Sent</th>
            <th style="text-align: center;">Failed</th>
            <th style="text-align: center;">Message</th>
            <th style="text-align: center;">Attachment</th>
            <th style="text-align: center; vertical-align: middle;">Export Result</th>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT gmail_bulk_result.*,CONCAT(users.first_name,' ',users.last_name) AS uploadby FROM gmail_bulk_result LEFT JOIN users ON users.id = gmail_bulk_result.user_id WHERE gmail_bulk_result.professionalid = '" . $_SESSION['professionalid'] . "'";
            $result = $conn->query($sql);
            $i = 1;
            $limitcount = mysqli_num_rows($result);
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td style="text-align: center; font-size: inherit;"><?php echo $i; ?></td>
                    <td style="text-align: center; font-size: inherit;"><?php echo $row['currenttime']; ?></td>
                    <td style="text-align: center; font-size: inherit;"><?php echo $row['uploadby']; ?></td>
                    <td style="text-align: center; font-size: inherit;"><?php echo $row['messagecount']; ?></td>
                    <td style="text-align: center; font-size: inherit;"><?php echo $row['successmessage']; ?></td>
                    <td style="text-align: center; font-size: inherit;"><?php echo $row['failedmessage']; ?></td>
                    <td style="text-align: center; font-size: inherit;">
                        <input type="hidden" name="caption" id="caption_<?php echo $row['id']; ?>" value="<?php echo $row['caption']; ?>">
                        <input type="hidden" name="caption_subject" id="caption_subject_<?php echo $row['id']; ?>" value="<?php echo $row['caption_subject']; ?>">
                        <input type="hidden" name="tableData" id="tableData_<?php echo $row['id']; ?>" value='<?php echo $row['tableData']; ?>'>
                        <a id="<?php echo $row['id']; ?>" class="showcaption"><i class="fa fa-eye"></i></a>
                    </td>
                    <td style="text-align: center; font-size: inherit;"><a href="https://mcabucket.s3.ap-south-1.amazonaws.com/<?php echo $row['path_attach']; ?>"><?php echo $row['filename']; ?></a></td>
                    <td style="text-align: center; font-size: inherit;"><a id="<?php echo $row['id']; ?>" class="btn btn-primary exportsentresult">Export</a></td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
</div>


    </div>
    
  </div>
</div>
<!-- ============================================================== -->
<!-- end validation form -->
<!-- ============================================================== -->
</div>

</div>


<div style="display: none;">
    <div id="showcaptionmessage">
        <div class="loader-container" id="loadercolorboxcontainer" style="display: none">
         <div class="loader-color-loader" id="loader-color-loader"></div>
        </div> 


 <div style="text-align: center;"><span id="initalcount">0</span>/<span id="finalcount">0</span></div>
 <div id="progressbar-container" style="display: none;">
        <div id="progressbar"></div>
        
    </div>

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
    <div id='showcaption' style='padding:10px; background:#fff; overflow-x:hidden;'>
      <div class="row">
          <div class="col-lg-12">
             <h1 class="page-header" style="margin-top:0px;text-align:center">
             <small><h4 style="color: black;">Message</h4></small>
           </h1>
       <form action="" method="post" id="fupForm1" enctype="multipart/form-data">


<div class="box">
  <div class="input-container">
    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject" readonly>
  </div>
  <div class="input-container">
    <label for="message">Message:</label>
    <textarea id="message" name="message" readonly></textarea>
  </div>
</div>
</div>           
       </form>

         </div>
       </div>
      </div>
</div>
<?php include('../footernew.php');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx-populate/1.21.0/xlsx-populate.min.js" integrity="sha512-JVBz6zJ6cvcRjn7GayGJ/dsfYmykXq/O+BG5jqvCotbSkRd7pD/k0q/wqoIKEgXTh9lBxWoInk0DgrDhpXc9JA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.4/purify.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/example1/colorbox.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js"></script>
<script src="../ageless-js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="../ageless-js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js" type="text/javascript"></script>
<script src="../ageless-js/buttons.flash.min.js" type="text/javascript"></script>
<script src="../ageless-js/jszip.min.js" type="text/javascript"></script>
<script src="../ageless-js/pdfmake.min.js" type="text/javascript"></script>
<script src="../ageless-js/vfs_fonts.js" type="text/javascript"></script>
<script src="../ageless-js/buttons.html5.min.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.5/dist/quill.snow.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/example1/colorbox.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.5/dist/quill.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">


<script>


document.getElementById('excelFile').addEventListener('change', handleFile);

    function validateExcel(workbook) {
        const sheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[sheetName];
        const cellA1 = (worksheet.A1 && worksheet.A1.v) || "";
        const cellB1 = (worksheet.B1 && worksheet.B1.v) || "";
        return (
            cellA1.trim().toLowerCase() === 'sr no.' &&
            cellB1.trim().toLowerCase() === 'email'
        );
    }

    function updateRemainingLimitCount() {
    var rowCount = $("#example1 tbody tr").length;
    var remainingLimit = 10 - rowCount; 
    $("#remainingLimit").text(remainingLimit);
}

updateRemainingLimitCount();

    function handleFile(e) {
        const file = e.target.files[0];
        const reader = new FileReader();

        var paiduser = '<?php echo $paiduser; ?>';
        var limitcount = '<?php echo $limitcount?>';
        var remainingLimit = <?php echo $remainingLimitCount; ?>;

        if (paiduser != 'true' && limitcount > 9) {
            alert('10 Attempt only for free version');
            $("#excelFile").val('');
            return false;
        }

        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            if (!validateExcel(workbook)) {
                alert("Invalid Excel format");
                document.getElementById('excelPreview').innerHTML = ''; // Clear the preview
                document.getElementById('excelFile').value = ''; // Clear the input
                return false;
            }

            const sheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[sheetName];

            // Check if professionalid is not 3 before applying row count limit
            if (<?php echo $professionalid; ?> !== 3) {
                // Check if row count is greater than 301
                const lastCell = worksheet['!ref'].split(':').pop();
                const rowNumber = parseInt(lastCell.replace(/\D/g, ''), 10);

                if (rowNumber > 301) {
                    alert("Excel file contains more than 300 rows. Please make sure the file has at most 300 rows.");
                    document.getElementById('excelPreview').innerHTML = '';
                    document.getElementById('excelFile').value = '';
                    return;
                }
            }

            if (paiduser == 'false'){
             
                const checkrowincell = worksheet['!ref'].split(':').pop();
                const rownumbervlue = parseInt(checkrowincell.replace(/\D/g, ''), 10);

                if (rownumbervlue > 31){
                    alert ('you are not a paid user');
                    document.getElementById('excelPreview').innerHTML = '';
                    document.getElementById('excelFile').value = '';
                    return false;
                } 
            }

            const excelHTML = XLSX.write(workbook, { bookType: 'html', type: 'string' });
            document.getElementById('excelPreview').innerHTML = excelHTML;
        };
        reader.readAsArrayBuffer(file);
    }

//for clear the preview
document.getElementById('clearExcelData').addEventListener('click', function() {
    // Clear the content of the #excelPreview element
    document.getElementById('excelPreview').innerHTML = '';
    document.getElementById('excelFile').value = '';
    return false;
});


//for downloading the excel file

document.getElementById("downloadTemplate").addEventListener("click", function () {
    XlsxPopulate.fromBlankAsync()
        .then(workbook => {
            const sheet = workbook.sheet(0);
            sheet.cell("A1").value('Sr No.');
            sheet.cell("B1").value('Email');
            return workbook.outputAsync();
        })
        .then(data => {
            const blob = new Blob([data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "Bulk Gmail Sheet Template.xlsx";
            a.click();
        })
        .catch(error => {
            console.error(error);
        });
});


async function authenticateWithNodeServer() {
    try {
        const response = await fetch('authenticate.php', {
            method: 'GET',
            credentials: 'include',
        });
        const data = await response.json();
        console.log('Received response from the Node.js server:', data);
        if (data.authUrl) {
            // Redirect to the authentication URL
            window.location.href = data.authUrl;
        } else {
            alert('You are already authenticated');
        }
    } catch (error) {
        console.error('Error authenticating with Node.js server:', error);
        alert('An error occurred while authenticating. Please try again later.');
    }
}

const authenticationButton = document.getElementById('authenticateButton');
authenticationButton.addEventListener('click', async () => {
    try {
        const response = await fetch('check_authentication.php', {
            method: 'GET',
            credentials: 'include',
        });
        const data = await response.json();
        console.log('Received response from the server:', data);
        if (data.authenticated) {
            alert('You are already authenticated');
        } else {
            authenticateWithNodeServer();
        }
    } catch (error) {
        console.error('Error checking authentication status:', error);
        alert('An error occurred while checking authentication status. Please try again later.');
    }
});

$(document).ready(function () {
        $("#Send-Message").on("click", function () {
            submitform();
        });
    });
    
function submitform() {
        const excelPreviewdataTable = document.getElementById("excelPreview");
        if (!excelPreviewdataTable || excelPreviewdataTable.querySelectorAll("tr").length <= 1) {
            $("#excelFile").prop("required", true);
            return false;
        }
    }

    document.getElementById("imageForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const attachmentFileInput = document.getElementById("attachmentFile");
    const attachmentFile = attachmentFileInput.files[0];
    const captionSubject = document.getElementById("caption_subject").value;
    const captionMessage = document.getElementById("caption_message").value;

    if (!captionSubject || !captionMessage) {
        alert("Please provide any one input");
        return false;
    }

    const isAuthenticated = await checkAuthenticationStatus();
    if (!isAuthenticated) {
        alert("You are not authenticated. Please authenticate first.");
        return;
    }

    const excelPreviewTable = document.getElementById("excelPreview");
    const rows = excelPreviewTable.querySelectorAll("tr");
    const totalMessages = rows.length - 1; // Excluding header row
    let successCounter = 0;

    colorboxpopuploaderdisplay(totalMessages);

    for (let rowIndex = 1; rowIndex < rows.length; rowIndex++) {
        const row = rows[rowIndex];
        const emailCell = row.cells[1].textContent.trim(); // Assuming email is in the second cell (B cell) of each row
        if (isValidEmail(emailCell)) {
            try {
                const formData = new FormData();
                formData.append("caption_subject", captionSubject);
                formData.append("caption_message", captionMessage);
                formData.append("attachmentFile", attachmentFile);
                formData.append("recipientEmail", emailCell); // Send individual recipient email

                const response = await fetch("sendgmail.php", {
                    method: "POST",
                    body: formData,
                });

                if (response.ok) {
                    const responseData = await response.json();
                    const status = responseData.success ? "Sent" : "Failed";
                    await updateColorboxTable({ email: emailCell, status });
                    if (responseData.success) {
                        successCounter++;
                        updateProgressCounter(successCounter, totalMessages);
                        const progress = (rowIndex / totalMessages) * 100;
                        updateProgressBar(progress);
                    }
                } else {
                    const errorData = await response.json();
                    if (response.status === 403) {
                        alert(errorData.error);
                    } else {
                        console.error("Error response from server:", response);
                    }
                }
            } catch (error) {
                console.error("Error sending data to the server:", error);
            }
        } else {
            alert("Invalid email address");
        }
    }
    setTimeout(() => {
        alert("Message sent successfully!");
        updatedatabase();
        // window.location.reload();
    }, 1000);

    updateProgressCounter(successCounter, totalMessages);
});

async function checkAuthenticationStatus() {
    try {
        const response = await fetch("check_authentication.php", {
            method: "GET",
            credentials: "include",
        });
        const data = await response.json();
        return data.authenticated;
    } catch (error) {
        console.error("Error checking authentication status:", error);
        return false;
    }
}


async function updateColorboxTable(data) {
    const colorboxTable = document.getElementById("updatecss");

    // Check if the table has rows, and if not, add a header row
    if (colorboxTable.children.length === 0) {
        const headerRow = document.createElement("tr");
        headerRow.innerHTML = "<th>Sr no.</th><th>Email</th><th>Status</th>";
        colorboxTable.appendChild(headerRow);
    }

    // Create a new row
    const row = document.createElement("tr");
    const srNoCell = document.createElement("td");
    const emailCell = document.createElement("td");
    const statusCell = document.createElement("td");

    srNoCell.textContent = colorboxTable.children.length; // Incremental serial number starting from 1
    emailCell.textContent = data.email;
    statusCell.textContent = data.status;

    row.appendChild(srNoCell);
    row.appendChild(emailCell);
    row.appendChild(statusCell);

    // Append the new row
    colorboxTable.appendChild(row);
}

function isValidEmail(email) {
    // Simple email validation, you may need to enhance it according to your requirements
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function colorboxpopuploaderdisplay(totalMessages) {
    $.colorbox({
        inline: true,
        width: "70%",
        height: "70%",
        href: "#showcaptionmessage",
        scrolling: true,
        onComplete: function () {
            document.getElementById("progressbar-container").style.display = "block";
            updateProgressBar(0);
            updateProgressCounter(0, totalMessages);
        },
    });
}

function updateProgressBar(progress) {
    const progressBar = document.getElementById("progressbar");
    progressBar.style.width = progress + "%";
}

function updateProgressCounter(successCounter, totalMessages) {
    const initialCountSpan = document.getElementById("initalcount");
    const finalCountSpan = document.getElementById("finalcount");
    
    initialCountSpan.textContent = successCounter;
    finalCountSpan.textContent = totalMessages;
}

// Function to handle logout
// Function to handle logout
function logout() {
    if (confirm("Are you sure you want to logout?")) {
        checkAuthenticationStatus()
            .then(isAuthenticated => {
                if (isAuthenticated) {
                    // User is authenticated, proceed with logout
                    fetch('logout.php', {
                        method: 'POST', // Or 'GET' if your logout.php file accepts GET requests
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.alert) {
                            // Show alert to the user
                            alert(data.alert);
                        } else if (data.success) {
                            // Logout successful
                            console.log('Logout successful');
                            alert('Logout successful');
                            // Perform any other actions after logout
                        } else {
                            // Logout failed
                            console.error('Logout failed');
                            alert('Logout failed');
                            // Handle logout failure
                        }
                    })
                    .catch(error => {
                        // Error logging out
                        console.error('Error logging out:', error);
                        alert('Error logging out');
                        // Handle error
                    });
                } else {
                    // User is not authenticated
                    alert("You are not authenticated yet.");
                }
            })
            .catch(error => {
                // Error checking authentication status
                console.error('Error checking authentication status:', error);
                alert('Error checking authentication status');
                // Handle error
            });
    }
}

async function checkAuthenticationStatus() {
    try {
        const response = await fetch("check_authentication.php", {
            method: "GET",
            credentials: "include",
        });
        const data = await response.json();
        return data.authenticated;
    } catch (error) {
        console.error("Error checking authentication status:", error);
        throw error;
    }
}




// Add event listener to logout button
const logoutButton = document.getElementById('logoutButton');
logoutButton.addEventListener('click', logout);
function updatedatabase(){
var excelPreviewDiv = document.getElementById('colorboxTable');
// Get the table element within the div
var table = excelPreviewDiv.querySelector('tbody');
// Create an empty array to store the table data
var tableData = [];

// Get the table rows
var rows = table.querySelectorAll('tr');
var successmessage = 0;
var failedmessage = 0; 
// Loop through each row (skipping the header row at index 0)
for (var i = 1; i < rows.length; i++) {
  var row = rows[i];
  var rowData = {};

  // Get the cells in the row
  var cells = row.querySelectorAll('td');

  // Extract data from each cell and store it in the rowData object
  rowData['SNo'] = cells[0].textContent;
  rowData['Email'] = cells[1].textContent;
  rowData['Status'] = cells[2].textContent;

  if (cells[2].textContent.trim() == 'Sent') {
    successmessage++;
  }else{
    failedmessage++;
  }

  // Add the rowData object to the tableData array
  tableData.push(rowData);
}

var caption = $("#caption_message").val();  
var caption_subject = $("#caption_subject").val();

var formData = new FormData();
formData.append('tableData', JSON.stringify(tableData));
formData.append('messagecount', tableData.length);
formData.append('successmessage', successmessage);
formData.append('failedmessage', failedmessage);
formData.append('caption', caption);
formData.append('caption_subject', caption_subject);
// Encode the tableData as JSON
var fileInput = document.getElementById('attachmentFile');
if (fileInput.files.length > 0) {
    formData.append('file', fileInput.files[0]);
}
    $.ajax({
        type: "POST",
        url: "updategmaildatabase.php",
        data: formData,
        datatype: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function( response ) {
            console.log(response);
        }
    });

}

$(".exportsentresult").click(function(){
    var id = this.id;
    var xlsRowsData2 = [];
    var tableData = $("#tableData_"+id).val();

    if (tableData != '') {
        JSON.parse(tableData).forEach(function (temp) {
            xlsRowsData2.push({
                "Sr No.": temp.SNo ? temp.SNo !== "" ? temp.SNo : "" : "",
                "Email": temp.Email ? temp.Email !== "" ? temp.Email : "" : "",
                "Status": temp.Status ? temp.Status !== "" ? temp.Status : "" : "",
            });
        });

        var tempAllColumnsns = {
            "Sr No.": "",
            "Email": "",
            "Status": ""
        };

        for (var i = 0; i < 300; i++) {
            xlsRowsData2.push(tempAllColumnsns);
        }

        (function () {
            var worksheet = XLSX.utils.json_to_sheet(xlsRowsData2);

            worksheet['!cols'] = [
                { wch: 10 },
                { wch: 30 }, 
                { wch: 21 }
            ];

            var range = XLSX.utils.decode_range(worksheet['!ref']);

            for (var r = range.s.r; r <= range.e.r; r++) {
                for (var c = range.s.c; c <= range.e.c; c++) {
                    var cellName = XLSX.utils.encode_cell({ c: c, r: r });
                    worksheet[cellName].z = '@';
                }
            }

            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, worksheet, "Email Results");
            XLSX.writeFile(wb, "Email Results.xlsx");
        })();
    }
});


$(document).ready(function() {
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        // Configure the drop down options.
        lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
        'pageLength',
             {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
               'colvis'
        ]
    } );
} );

$(".showcaption").click(function(){
 var id = this.id;
 var caption = $("#caption_"+id).val();
 var caption_subject = $("#caption_subject_"+id).val();
  $("#message").html(caption);
  $("#subject").val(caption_subject);
 $.colorbox({inline:true, width:"800px", height:"500px", href:"#showcaption" , scrolling:true});

});

document.getElementById('improtDirector').addEventListener('click', function () {
            document.getElementById('excelFile').value='';
            window.location.href = 'directorGmailbulk.php';
     });

     document.getElementById('importshareholder').addEventListener('click', function () {
        document.getElementById('excelFile').value='';
        window.location.href = 'shareholderDatabase.php';

    });


    var toolbarOptions = [
    [{ 'header': [1, 2, 3, false] }],
    ['bold', 'italic', 'underline', 'size', 'color'],
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    [{ 'align': [] }],
    ['undo', 'redo']
];

// Add font selector
// Add font selector
var toolbarOptions = [
    [{ 'font': [] }],
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block'],

    [{ 'header': 1 }, { 'header': 2 }],

    ['clean']                          
];

var quill = new Quill('#editor', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow'
});
</script>
