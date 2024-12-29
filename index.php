<?php 
session_start(); // Starts the session

// Ensure the user is logged in
if (!isset($_SESSION['UserData']['Username'])) {
    header("Location: login.php");
    exit;
}

require 'vendor/autoload.php';  // Load DOMPDF library
require 'database.php';         // Assuming database.php handles DB connection

use Dompdf\Dompdf;
use Dompdf\Options;

// Database connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data to avoid SQL injection and XSS
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $mobile_no = mysqli_real_escape_string($conn, $_POST['mobile_no']);
    $pickup_address = mysqli_real_escape_string($conn, $_POST['pickup_address']);
    $drop_address = mysqli_real_escape_string($conn, $_POST['drop_address']);
    $tour_package = mysqli_real_escape_string($conn, $_POST['tour_package']);
    $pricing = mysqli_real_escape_string($conn, $_POST['pricing']);
    $date_of_journey = mysqli_real_escape_string($conn, $_POST['date_of_journey']);
    $date_of_return = mysqli_real_escape_string($conn, $_POST['date_of_return']);
    $no_of_adults = intval($_POST['no_of_adults']);
    $no_of_children = intval($_POST['no_of_children']);
    $cars_provided = mysqli_real_escape_string($conn, $_POST['cars_provided']);
    $no_of_cars = intval($_POST['no_of_cars']);
    $hotel_used = mysqli_real_escape_string($conn, $_POST['hotel_used']);
    $hotel_room_details = mysqli_real_escape_string($conn, $_POST['hotel_room_details']);
    $special_requirements = mysqli_real_escape_string($conn, $_POST['special_requirements']);
    $meal_plan = mysqli_real_escape_string($conn, $_POST['meal_plan']);
    $food_included = isset($_POST['food_included']) ? 1 : 0;  // True or False
    
    // Insert data into database with error checking
    $stmt = $conn->prepare("
        INSERT INTO invoice_data (
            customer_name, mobile_no, pickup_address, drop_address,
            tour_package, pricing, date_of_journey, date_of_return,
            no_of_adults, no_of_children, cars_provided, no_of_cars,
            hotel_used, hotel_room_details, special_requirements,
            meal_plan, food_included
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // Check if the prepare statement is successful
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters for prepared statement
    $stmt->bind_param(
        "sssssissiisisssss", 
        $customer_name, $mobile_no, $pickup_address, $drop_address, $tour_package, 
        $pricing, $date_of_journey, $date_of_return, $no_of_adults, $no_of_children, 
        $cars_provided, $no_of_cars, $hotel_used, $hotel_room_details, $special_requirements, 
        $meal_plan, $food_included
    );
    
    // Execute the query
    if ($stmt->execute()) {
        header("Location: inquiry.php");
        exit;  // Prevent further code execution after redirect
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Handle Confirm Booking
if (isset($_GET['confirm_booking_id'])) {
    $invoice_id = intval($_GET['confirm_booking_id']);
    $conn->query("UPDATE invoice_data SET booking_status = 'Confirmed' WHERE id = $invoice_id");
    header("Location: index.php");
    exit;
}

// Handle Delete Booking
if (isset($_GET['delete_booking_id'])) {
    $invoice_id = intval($_GET['delete_booking_id']);
    $conn->query("UPDATE invoice_data SET booking_status = 'Declined' WHERE id = $invoice_id");
    header("Location: index.php");
    exit;
}

// Fetch records excluding declined bookings
$records = $conn->query("SELECT * FROM invoice_data WHERE booking_status NOT IN ('Declined')");
if (!$records) {
    die("Error fetching records: " . $conn->error);
}

// Function to generate the invoice as PDF
function generate_invoice($invoice) {
    // Check if the invoice.html file exists
    if (!file_exists('invoice.html')) {
        die("Error: invoice.html file is missing.");
    }
    
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
    $options->set('fontDir', './fonts');  // Ensure the font directory exists
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);

    // Load HTML content
    $dompdf->loadHtml($html);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render PDF (first pass)
    $dompdf->render();

    // Output the generated PDF (force download)
    $dompdf->stream('invoice.pdf', array('Attachment' => 0));
}

// Check if the download button was clicked
if (isset($_GET['download_invoice_id'])) {
    $invoice_id = intval($_GET['download_invoice_id']);

    // Fetch the invoice data based on the ID
    $result = $conn->query("SELECT * FROM invoice_data WHERE id = $invoice_id");
    if (!$result) {
        die("Error fetching invoice: " . $conn->error);
    }
    
    $invoice = $result->fetch_assoc();

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
    <?php include('navigation.php'); ?>
    <section class="home">
        <br>
        <div class="container" style="margin-left:10%;">
            <?php include('form.php'); ?>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
