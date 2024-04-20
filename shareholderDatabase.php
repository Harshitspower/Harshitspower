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
$professionalid = $_SESSION['professionalid'];
//if (isset($_POST['imprtdirector'])) {
  // Execute the query to fetch data from the database
$query = "SELECT id, email FROM `shareholder` WHERE status = 'Active' AND professionalid = '$professionalid' AND email <> '' ORDER BY id ASC";

$result = $conn->query($query);

include('../headerrun.php');
?>
<style>
#example tbody tr td {
    color: green;
}   

#example1 tbody tr td {
    color: red;
}   

.hintsending{
    font-weight: bold;
    color: red;
    font-size: 13px;
    text-align: justify;
}

.row {
    margin-right: -30px;
    margin-left: -25px;
    margin-bottom: 16px;
}

.container-fluid {
    overflow: hidden;
} 
</style>


    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <!-- Page header -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- Page header content can be added here if needed -->
                </div>
            </div>
            <!-- End page header -->

            <div class="product-sales-area mg-tb-30">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Validation form -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="product-sales-chart">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <ul style="position: relative; right: -13px;">
                                            <li style="float: left;"><a href="gmailbulk.php">Bulk-Gmail</a> <span class="bread-slash"> / </span></li>
                                            <li style="float: left;"><span class="bread-blod">Shareholder database</span></li>
                                        </ul>
                                        <div style="position: absolute; right: 440px;">
                                            <h4>Shareholder database for bulk Gmail</h4>
                                        </div>
                                        <div style="float: right; position: relative; top: -2px; right: 17px;">
                                            <a href="index.php" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-title">
                                    <div class="row" style="height: auto; width: 112%;">
                                        <div class="col-xs-12 col-sm-12 col-md-5 form-row" style="height: 24rem; overflow-x: hidden; margin-left: 28px;">
                                            <div id="masterdatabase">
                                                <table border="1" class="table table-bordered table-hover table-striped" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr No.</th>
                                                            <th>Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $srNo = 1;
                                                        while ($row = $result->fetch_assoc()) {
                                                            // Check if mobile number starts with "+91"
                                                            $email = $row['email'];
                                                            // if (!preg_match('/^\+91/', $mobile)) {
                                                            //     // If not, add "+91" prefix
                                                            //     $mobile = '+91' . $mobile;
                                                            // }
                                                        ?>
                                                            <tr>
                                                                <td><input type='checkbox' name='selectRow' value='<?php echo $row['id']; ?>' data-id='<?php echo $row['id']; ?>'> <?php echo $srNo; ?></td>
                                                                <!-- <td><?php echo $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']; ?></td> -->
                                                                <td><?php echo $email; ?></td>
                                                            </tr>
                                                        <?php
                                                            $srNo++;
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-1" style="align-items: center; justify-content: center; margin-top: 11rem;">
                                            <button type="submit" id="moveCheckedRowsBtn" class="btn btn-primary" style="height: 34px; margin: 7px -3px;"><h4><i class="fa fa-arrow-right" aria-hidden="true"></i></h4></button>
                                            <button type="submit" id="resetCheckedRowsBtn" class="btn btn-primary" style="height: 34px; margin: 0px -3px;"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i></h4></button>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-5 form-row" style="height: 24rem; overflow-x: hidden; margin-left: -30px;">
                                            <div id="checkedata">
                                                <table border="1" class="table table-bordered table-hover table-striped" id="example1">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr No.</th>
                                                            <th>Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $p = 1;
                                                        $sql5 = "SELECT * FROM `directordatabasefill` WHERE `professionalid` = '$professionalid' AND `type` = 'shareholder'";
                                                        $result5 = $conn->query($sql5);

                                                        while ($row5 = mysqli_fetch_assoc($result5)) {
                                                        ?>
                                                            <tr>
                                                                <td><input type='checkbox' name='selectRow[]' value='<?php echo $row5['srNo']; ?>'> &nbsp; <?php echo $p ?></td>
                                                                <!-- <td><?php echo $row5['name']; ?></td> -->
                                                                <td><?php echo $row5['email']; ?></td>
                                                            </tr>
                                                        <?php
                                                            $p++;
                                                        } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="hintsending">Quick hint:
                                                To move a contact from the "Send" list to the "Do Not Send" list or vice versa, please select the contact and click on the arrow button accordingly. This action will either include them in the list to receive messages or exclude them from receiving further communication.
                                            </p>
                                        </div>
                                    </div>
                                    <div align="right">
                                        <input type="submit" id="transferrows" type="button" value="Import" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End validation form -->
            </div>
        </div>
        <div style="display: none;">
            <div id="transferForm" style="padding: 10px; background: #fff; overflow: hidden;">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header" style="margin-top: 0px;">
                            <small>Transfer rows</small>
                        </h1>
                    </div>
                </div>
                <form id="rangeForm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row" style="overflow: hidden; display: flex; align-items: center; margin-left: 8px;">
                                <div style="width: 287px; margin-right: 10px;">
                                    <label for="startRow" style="padding-inline: 0% 1%;">From Row:</label>
                                    <input type="number" id="startRow" name="startRow" min="1">
                                </div>
                                <div style="margin-right: 145px;">
                                    <label for="endRow" style="padding-inline: 0px 5px;">To Row:</label>
                                    <input type="number" id="endRow" name="endRow" min="1">
                                </div>
                                <div style="width: 100px;">
                                    <input type="submit" id="submitRange" class="btn btn-default" value="Submit" style="width: 100px; font-weight: bold;">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include('../footer2.php');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx-populate/1.21.0/xlsx-populate.min.js" integrity="sha512-JVBz6zJ6cvcRjn7GayGJ/dsfYmykXq/O+BG5jqvCotbSkRd7pD/k0q/wqoIKEgXTh9lBxWoInk0DgrDhpXc9JA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.4/purify.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../ageless-js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="../ageless-js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="../ageless-js/buttons.flash.min.js" type="text/javascript"></script>
<script src="../ageless-js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/example1/colorbox.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js"></script>
<link rel="stylesheet" type="text/css" href="../ageless-js/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="../ageless-js/buttons.dataTables.min.css">

<script>
$(document).ready(function () {
// DataTable initialization for both tables
var masterTable = $('#example').DataTable({
    dom: 'Bfrtip',
    lengthMenu: [
        [-1],
        ['Show all']
    ],
    buttons: [
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
    
    ],
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Search..."
    },
    paging: false,
    columnDefs: [
        {
            targets: 0,
            orderable: false 
        }
    ]
});

var searchContainer = $('<div class="search-container"></div>');

// Move the DataTable search input to the container
searchContainer.append($('#example_filter'));

// Add WhatsApp label to the container
searchContainer.prepend('<span class="Email-label">Send Email</span>');

// Append the container to the DataTable wrapper
$('.dataTables_wrapper').prepend(searchContainer);

// Apply styles to the WhatsApp label
$('.Email-label').css({
    'font-weight': 'bold',
    'font-size': 'larger',
    'float': 'left',
    'text-align': 'left'
});

var srNoTh = $('#example thead th:first-child');

// Update the width in the style attribute
srNoTh.attr('style', 'width: 52.3438px !important;');

$('#example thead th:first-child').html('<input type="checkbox" id="selectAll" style="margin-left: -7px;"> <span>Sr No.</span>');

$('#selectAll').on('change', function () {
    var checked = $(this).prop('checked');
    $('#example tbody input[type="checkbox"]').prop('checked', checked);
});


var checkedTable = $('#example1').DataTable({
    dom: 'Bfrtip',
    lengthMenu: [
        [-1],
        ['Show all']
    ],
    buttons: [
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
    
    ],
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Search..."
    },
    paging: false,
    columnDefs: [
        {
            targets: 0,
            orderable: false 
        }
    ]
});

var searchContainerwhatsapp = $('<div class="search-Email"></div>');

// Move the DataTable search input to the container
searchContainerwhatsapp.append($('#example1_filter'));

// Add WhatsApp label to the container
searchContainerwhatsapp.prepend('<span class="no-Email-label">Do not Send Email</span>');

// Append the container to the DataTable wrapper
$('#example1_wrapper').prepend(searchContainerwhatsapp);

// Apply styles to the WhatsApp label
$('.no-Email-label').css({
    'font-weight': 'bold',
    'font-size': 'larger',
    'float': 'left',
    'text-align': 'left'
});

var srNoTh = $('#example1 thead th:first-child');

// Update the width in the style attribute
srNoTh.attr('style', 'width: 52.3438px !important;');


$('#example1 thead th:first-child').html('<input type="checkbox" id="selectAllcheckbox" style="margin-left: -11px;"> <span>Sr No.</span>');

$('#selectAllcheckbox').on('change', function () {
    var checked = $(this).prop('checked');
    $('#example1 tbody input[type="checkbox"]').prop('checked', checked);
});


function removeCommonRows() {
var masterData = masterTable.rows().data().toArray();
var checkedData = checkedTable.rows().data().toArray();

// Find common rows between masterTable and checkedTable
var commonRows = masterData.filter(function (masterRow) {
    return checkedData.some(function (checkedRow) {
        return masterRow[1] === checkedRow[1] && masterRow[2] === checkedRow[2];
    });
});

// Remove common rows from the masterTable
commonRows.forEach(function (commonRow) {
    var index = masterTable.column(1).data().indexOf(commonRow[1]);
    masterTable.row(index).remove().draw();
});

// Reorder rows in the masterTable based on "Sr No."
masterTable.order([0, 'asc']).draw();
updateSrNoColumn(masterTable, 1);
}

function initialization(){
removeCommonRows();

masterTable.order([0, 'asc']).draw();
updateSrNoColumn(masterTable, 1);

checkedTable.order([0, 'asc']).draw();
updateSrNoColumn(checkedTable, 1);
}

initialization();


function updateSrNoColumn(table, counter) { 
    table
        .column(0)
        .nodes()
        .each(function (cell, i) {
            cell.innerHTML = '<input type="checkbox" name="selectRow" value="' + counter + '"> ' + counter++;
        });
}

function getMaxSrNo(table) {
    var maxSrNo = 0;
    table
        .column(0)
        .nodes()
        .each(function (cell, i) {
            var srNo = parseInt(cell.innerText);
            if (!isNaN(srNo) && srNo > maxSrNo) {
                maxSrNo = srNo;
            }
        });
    return maxSrNo;
}

$('#moveCheckedRowsBtn').on('click', function () {
var checkedCheckboxe = $('#example tbody input[type="checkbox"]:checked');

if (checkedCheckboxe.length === 0) {
    alert('Please select at least one row');
    return;
}

var checkedRowsData = [];
$('#example tbody input[type="checkbox"]:checked').each(function () {
    var row = $(this).closest('tr');
    var rowData = masterTable.row(row).data();
    var checkboxAndSrNo = rowData[0];
    var srNoMatch = checkboxAndSrNo.match(/value="(\d+)"/);
    var srNo = srNoMatch ? srNoMatch[1] : '';
    var id = rowData[0].match(/value="(\d+)"/)[1];
    var Gmail = rowData[1];
    var type = 'Shareholder'; 

    checkedRowsData.push({
        srNo:srNo,
        id: id,
        Gmail: Gmail,
        type: type
    });
    checkedTable.row.add(rowData).draw();
    masterTable.row(row).remove().draw();
});

// console.log("checkedRowsData",checkedRowsData);
masterTable.order([0, 'asc']).draw();
updateSrNoColumn(checkedTable, 1);
updateSrNoColumn(masterTable, 1);

var jsonData = JSON.stringify(checkedRowsData);
// console.log(jsonData);

$.ajax({
    type: 'POST',
    url: 'recivemasterdatabase.php',
    data: {
        jsonData: jsonData
    },
    success: function (response) {
        console.log('Data transferred successfully');
    },
    error: function (xhr, status, error) {
        console.error(error);
        alert('Error transferring data to the database.');
    }
});

// Reset the "Select All" checkbox
$('#selectAll').prop('checked', false);
});

$('#resetCheckedRowsBtn').on('click', function () {
    var checkedRowsData = [];
    var checkedRowsIndexes = [];

    var checkedCheckboxe = $('#example1 tbody input[type="checkbox"]:checked');

    if (checkedCheckboxe.length === 0) {
       alert('Please select at least one row');
       return;
    }

$('#example1 tbody input[type="checkbox"]:checked').each(function () {
    var row = $(this).closest('tr');
    var rowData = checkedTable.row(row).data();
    var checkboxAndSrNo = rowData[0];
    var srNoMatch = checkboxAndSrNo.match(/value="(\d+)"/);
    var srNo = srNoMatch ? srNoMatch[1] : '';

    checkedRowsData.push({
        srNo: srNo,
        email: rowData[1],
    });
    checkedRowsIndexes.push(row.index());
});

    // Add the rows to the masterTable with updated Sr No.
for (var i = 0; i < checkedRowsData.length; i++) {
    var maxSrNo = getMaxSrNo(masterTable);
    var newRowData = [
        '<input type="checkbox" name="selectRow" value="' + (maxSrNo + 1) + '"> ' + (maxSrNo + 1),
        // checkedRowsData[i].name,
        checkedRowsData[i].email
    ];

    masterTable.row.add(newRowData).draw();
}

// Remove rows from checkedTable after moving to masterTable
for (var i = checkedRowsIndexes.length - 1; i >= 0; i--) {
    checkedTable.row(checkedRowsIndexes[i]).remove().draw();
}

// Reorder rows in the masterTable based on "Sr No."
masterTable.order([0, 'asc']).draw();
updateSrNoColumn(masterTable, 1);
updateSrNoColumn(checkedTable, 1);

// Now, proceed to delete rows from the database
$.ajax({
    url: 'deleteshareholder.php',
    method: 'POST',
    data: {
        primaryKey: checkedRowsData.map(row => row.srNo),
        name: checkedRowsData.map(row => row.email),
    },
    success: function (response) {
        // Assuming the server returns a success message
        console.log(response);
    },
    error: function (error) {
        console.error('Error deleting row:', error);
        // Handle error, if needed
    }
});

$('#selectAllcheckbox').prop('checked', false);
});

$('#transferrows').on('click', function () {
    $('#startRow').val('');
    $('#endRow').val('');
    masterTableData = [];
    // Iterate over each row in the masterTable
    masterTable.rows().data().each(function (rowData) {
    // Extract Sr No., name, and phone number from the row data
    var srNo = rowData[0].match(/value="(\d+)"/)[1];
    var Gmail = rowData[1];
    // Create an object with extracted data
    var rowObject = {
        srNo: srNo,
        Gmail: Gmail,
    };

    // Add the object to the masterTableData array
    masterTableData.push(rowObject);
});

    // Check if the number of rows exceeds 300
if (masterTableData.length > 300) {
    // Open Colorbox popup
    $.colorbox({
        inline: true,
        width: "60%",
        height: "60%",
        href: "#transferForm",
        onComplete: function () {
            // Populate the select dropdown with options
            populateSelectDropdown(masterTableData.length);
        },
    });

    // Prevent the default form submission
    event.preventDefault();
} else {
    // If fewer than or equal to 300 rows, proceed with the form submission
    submitFormData(masterTableData);
}
});

// Function to populate the select dropdown with row ranges
function populateSelectDropdown(totalRows) {
    // Assuming batchSize is 300, adjust as needed
    var batchSize = 300;
    var options = '';
    
    for (var i = 0; i < totalRows; i += batchSize) {
        var start = i + 1;
        var end = Math.min(i + batchSize, totalRows);
        options += '<option value="' + start + '-' + end + '">Rows ' + start + ' to ' + end + '</option>';
    }

    // Set the options in the select dropdown
    $('#rowRangeSelect').html(options);
}

// Event handler for the form submission inside the Colorbox popup
$('#rangeForm').on('submit', function (e) {
    e.preventDefault();

    // Get the start and end row numbers from the input boxes
    var start = parseInt($('#startRow').val());
    var end = parseInt($('#endRow').val());

    // Validate the input values
    if (isNaN(start) || isNaN(end) || start < 1 || end < start || end > masterTableData.length || (end - start + 1) < 300) {
        alert('Please enter valid row numbers.');
        $('#startRow').val('');
        $('#endRow').val('');
        return;
    }

    var selectedRows = masterTableData.slice(start - 1, end);

    // Call the function to submit form data to index.php
    submitFormData(selectedRows);
});

function submitFormData(selectedRows) {
    var form = $('<form action="gmailbulk.php" method="post"></form>');
    var input = $('<input type="hidden" name="masterTableData">');
    input.val(JSON.stringify(selectedRows));
    form.append(input);
    $('body').append(form);
    form.submit();
}
});
   
   
</script>