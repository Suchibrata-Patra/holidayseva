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
    $drop_address = $_POST['drop_address'];
    $tour_package = $_POST['tour_package'];
    $pricing = $_POST['pricing'];
    $special_requirements = $_POST['special_requirements'];
    $date_of_journey = $_POST['date_of_journey'];
    $no_of_adults = $_POST['no_of_adults'];
    $cars_provided = $_POST['cars_provided'];
    $no_of_cars = $_POST['no_of_cars'];
    $meal_plan = $_POST['meal_plan'];
    $food_included = isset($_POST['food_included']) ? 1 : 0; // True or False

    // Insert data into database
    $stmt = $conn->prepare("
    INSERT INTO invoice_data (
        customer_name, mobile_no, pickup_address,drop_address,
        tour_package, pricing, special_requirements, 
        date_of_journey, no_of_adults, cars_provided, 
        no_of_cars, meal_plan,food_included
    ) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)
");

// Bind the parameters to the query
$stmt->bind_param(
    "sssssissisiss", 
    $customer_name, 
    $mobile_no, 
    $pickup_address, 
    $drop_address, 
    $tour_package, 
    $pricing, 
    $special_requirements, 
    $date_of_journey, 
    $no_of_adults, 
    $cars_provided, 
    $no_of_cars, 
    $meal_plan,
    $food_included
);
    // $stmt->bind_param("ssssdsisisi", $customer_name, $mobile_no, $pickup_address, $tour_package, $pricing, $special_requirements, $date_of_journey, $no_of_adults, $cars_provided, $no_of_cars, $food_included);
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
$records = $conn->query("SELECT * FROM invoice_data WHERE booking_status NOT IN ('Declined')");

// Close the database connection
// $conn->close();

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
    // $conn->close();

    // Generate and download the invoice PDF
    generate_invoice($invoice);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>HolidaySeva</title> 
</head>
<body>
    <?php include('navigation.php') ?>
    <section class="home">
  <br>
  <!-- <center>
  <form action="/search" method="get" style="display: flex; align-items: center; width: 70%;margin-top:5px;margin-bottom:5px;">
    <input type="text" name="query" id="search-box" placeholder="Search..." required 
        style="flex: 1; padding: 6px 10px; border: 1px solid #000000; border-radius: 4px 0 0 4px; font-size: 14px; outline: none;">
    <button type="submit" 
        style="padding: 6px 12px; border: none; background-color: #007BFF; color: white; border-radius: 0 4px 4px 0; cursor: pointer; font-size: 14px; margin-left:-17px">
        Search
    </button>
</form>
  </center> -->
  

       <div class="container" style="margin-left:10%;">
        <?php include('form.php') ?>
       </div>
    </section>

    <script src="script.js"></script>

</body>
</html>