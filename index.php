<?php
require 'vendor/autoload.php';  // Load DOMPDF library
require 'database.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Database connection
// $conn = new mysqli('localhost', 'root', 'root', 'Invoice');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $mobile_no = $_POST['mobile_no'];
    $pickup_address = $_POST['pickup_address'];
    $tour_package = $_POST['tour_package'];
    $pricing = $_POST['pricing'];
    $special_requirements = $_POST['special_requirements'];
    $date_of_journey = $_POST['date_of_journey'];
    $no_of_adults = $_POST['no_of_adults'];
    $cars_provided = $_POST['cars_provided'];
    $no_of_cars = $_POST['no_of_cars'];
    $food_included = isset($_POST['food_included']) ? 1 : 0; // True or False

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO invoice_data (customer_name, mobile_no, pickup_address, tour_package, pricing, special_requirements, date_of_journey, no_of_adults, cars_provided, no_of_cars, food_included) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdsisisi", $customer_name, $mobile_no, $pickup_address, $tour_package, $pricing, $special_requirements, $date_of_journey, $no_of_adults, $cars_provided, $no_of_cars, $food_included);
    if ($stmt->execute()) {
        // After successful insert, redirect to prevent resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;  // Ensure no further code is executed after the redirect
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Handle Confirm Booking
if (isset($_GET['confirm_booking_id'])) {
    $invoice_id = $_GET['confirm_booking_id'];
    $conn->query("UPDATE invoice_data SET booking_status = 'Confirmed' WHERE id = $invoice_id");
    header("Location: index.php");
}

// Handle Delete Booking
if (isset($_GET['delete_booking_id'])) {
    $invoice_id = $_GET['delete_booking_id'];
    $conn->query("UPDATE invoice_data SET booking_status = 'Declined' WHERE id = $invoice_id");
    // $conn->query("DELETE FROM invoice_data WHERE id = $invoice_id");
    header("Location: index.php");
}

// Fetch all records from the database
$records = $conn->query("SELECT * FROM invoice_data WHERE booking_status NOT IN ('Declined') ORDER BY registration_date DESC");

// Close the database connection

// Function to generate the invoice as PDF
function generate_invoice($invoice) {
    $html = file_get_contents('invoice.html');
    $html = str_replace('{{customer_name}}', $invoice['customer_name'], $html);
    $html = str_replace('{{mobile_no}}', $invoice['mobile_no'], $html);
    $html = str_replace('{{pickup_address}}', $invoice['pickup_address'], $html);
    $html = str_replace('{{tour_package}}', $invoice['tour_package'], $html);
    $html = str_replace('{{pricing}}', $invoice['pricing'], $html);
    $html = str_replace('{{special_requirements}}', $invoice['special_requirements'], $html);
    $html = str_replace('{{date_of_journey}}', $invoice['date_of_journey'], $html);
    $html = str_replace('{{no_of_adults}}', $invoice['no_of_adults'], $html);
    $html = str_replace('{{cars_provided}}', $invoice['cars_provided'], $html);
    $html = str_replace('{{no_of_cars}}', $invoice['no_of_cars'], $html);
    $html = str_replace('{{food_included}}', $invoice['food_included'] ? 'Yes' : 'No', $html);

    $options = new Options();
    $options->set('fontDir', './fonts');  // Set your font directory path here
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('isRemoteEnabled', true); // Enable remote file access
    $dompdf = new Dompdf($options);
    

    // Load HTML content
    $dompdf->loadHtml($html);

    // Set paper size
    $dompdf->setPaper('A4', 'portrait');

    // Render PDF (first pass)
    $dompdf->render();

    // Output the generated PDF (force download)
    $dompdf->stream('invoice.pdf', array('Attachment' => 0));
}

// Check if the download button was clicked
if (isset($_GET['download_invoice_id'])) {
    $invoice_id = $_GET['download_invoice_id'];

    // Fetch the invoice data based on the ID
    // $conn = new mysqli('localhost', 'root', 'root', 'Invoice');
    $result = $conn->query("SELECT * FROM invoice_data WHERE id = $invoice_id");
    $invoice = $result->fetch_assoc();
    $conn->close();

    // Generate and download the invoice PDF
    generate_invoice($invoice);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Management</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=download" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=check" />    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-left:2%;">
    <a class="navbar-brand" href="#">
        <img src="https://holidayseva.com/wp-content/uploads/2024/06/cropped-holidayseva.com_favicon-1.png" width="30" height="30" class="d-inline-block align-top" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="#">Powered By - <strong>Holidayseva.com</strong></a>
            <a class="nav-item nav-link disabled" href="#">Version : <strong>1.php_dompdf.ß1</strong></a>
            
        </div>
    </div>
</nav>
<a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
  Link with href
</a>
<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
  Button with data-bs-target
</button>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>
      Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
    </div>
    <div class="dropdown mt-3">
      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Dropdown button
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="container">
    <div class="row">
        <!-- Left Column - Form Section -->
        <?php include('form.php') ?>
        <!-- Right Column - Existing Invoices Section -->
        <div class="col-md-9">
            <h2 class="text-center mt-5">Existing Invoices</h2>
            <center>
    <a href="index.php" style="text-decoration: none;">
        <button style="background-color: black; color: white; border: none; border-radius: 5px; padding: 12px 30px; font-size: 16px; font-weight: bold; cursor: pointer;  transition: all 0.3s ease;">
            Itinery Mode
        </button>
    </a>
    <a href="invoice.php" style="text-decoration: none; margin-left: 10px;">
        <button style="background-color: white; color: black;  border-radius: 5px; padding: 12px 30px; font-size: 16px; font-weight: bold; cursor: pointer;  transition: all 0.3s ease;">
            Invoice Mode
        </button>
    </a>
</center>

            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Mobile No</th>
                        <th>Pickup Address</th>
                        <th>Tour Package</th>
                        <th>Pricing</th>
                        <th>Special Requirements</th>
                        <th>Date of Journey</th>
                        <th>No of Adults</th>
                        <!-- <th>Cars Provided</th> -->
                        <!-- <th>No of Cars</th> -->
                        <th>Food Included</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($records->num_rows > 0) {
                            while ($row = $records->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['customer_name'] . "</td>";
                                echo "<td>" . $row['mobile_no'] . "</td>";
                                echo "<td>" . $row['pickup_address'] . "</td>";
                                echo "<td>" . $row['tour_package'] . "</td>";
                                echo "<td>" . $row['pricing'] . "</td>";
                                echo "<td>" . $row['special_requirements'] . "</td>";
                                echo "<td>" . $row['date_of_journey'] . "</td>";
                                echo "<td>" . $row['no_of_adults'] . "</td>";
                                echo "<td>" . $row['cars_provided'] . "</td>";
                                // echo "<td>" . $row['no_of_cars'] . "</td>";
                                echo "<td>" . ($row['food_included'] ? 'Yes' : 'No') . "</td>";
                                echo "<td>" . 
                                ($row['booking_status'] === 'Confirmed' 
                                    ? '<span class="material-icons" style="color: green;">check_circle</span>' 
                                    : '<span class="material-icons" style="color: red;">cancel</span>') . 
                                "</td>";
                            
                                                            echo "<td>
        <div class='dropdown'>
            <button class='btn btn-link btn-sm' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false' style='font-size:1.5rem;text-decoration:none;'>
                &#x2022;&#x2022;&#x2022;
            </button>
            <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                <li><a class='dropdown-item' href='index.php?confirm_booking_id=" . $row['id'] . "'>Confirm</a></li>
                <li><a class='dropdown-item' href='index.php?delete_booking_id=" . $row['id'] . "'>Delete</a></li>
                <li><a class='dropdown-item' href='index.php?download_invoice_id=" . $row['id'] . "'><span class='material-symbols-outlined'>download</span>Download Invoice</a></li>
            </ul>
        </div>
    </td>";

                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
