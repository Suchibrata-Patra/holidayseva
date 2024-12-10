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
 

// Handle Confirm Booking
if (isset($_GET['confirm_booking_id'])) {
    $invoice_id = $_GET['confirm_booking_id'];
    $conn->query("UPDATE invoice_data SET booking_status = 'Confirmed' WHERE id = $invoice_id");
    header("Location: invoice.php");
}

// Handle Delete Booking
if (isset($_GET['delete_booking_id'])) {
    $invoice_id = $_GET['delete_booking_id'];
    $conn->query("UPDATE invoice_data SET booking_status = 'Declined' WHERE id = $invoice_id");
    // $conn->query("DELETE FROM invoice_data WHERE id = $invoice_id");
    header("Location: inquiry.php");
}

// Fetch all records from the database
$records = $conn->query("SELECT * FROM invoice_data WHERE booking_status = 'Confirmed'");

// Close the database connection

// Function to generate the invoice as PDF
function generate_invoice($invoice) {
    // Ensure proper data handling for calculations
    $pricing = isset($invoice['pricing']) ? (float) $invoice['pricing'] : 0;
    $token_paid = isset($invoice['token_paid']) ? (float) $invoice['token_paid'] : 0;
    $pending_amount = $pricing - $token_paid;
    
    // Load HTML template
    $html = file_get_contents('invoice.html');
    
    // Replace placeholders with dynamic values
    $html = str_replace('{{customer_name}}', $invoice['customer_name'], $html);
    $html = str_replace('{{mobile_no}}', $invoice['mobile_no'], $html);
    $html = str_replace('{{pickup_address}}', $invoice['pickup_address'], $html);
    $html = str_replace('{{drop_address}}', $invoice['drop_address'], $html);
    $html = str_replace('{{tour_package}}', $invoice['tour_package'], $html);
    $html = str_replace('{{pricing}}', $pricing, $html);
    $html = str_replace('{{token_paid}}', $token_paid, $html);
    $html = str_replace('{{pending_amount}}', $pending_amount, $html);
    $html = str_replace('{{special_requirements}}', $invoice['special_requirements'], $html);
    $html = str_replace('{{date_of_journey}}', $invoice['date_of_journey'], $html);
    $html = str_replace('{{no_of_adults}}', $invoice['no_of_adults'], $html);
    $html = str_replace('{{cars_provided}}', $invoice['cars_provided'], $html);
    $html = str_replace('{{no_of_cars}}', $invoice['no_of_cars'], $html);
    $html = str_replace('{{meal_plan}}', $invoice['meal_plan'], $html);
    $html = str_replace('{{food_included}}', $invoice['food_included'] ? 'Yes' : 'No', $html);

    // Creating Digital Signature ID [For Authentication Purpose]
    $registrationDate = $invoice['registration_date'];
    $cleanedDate = preg_replace('/\D/', '', $registrationDate);
    $reversedDate = strrev($cleanedDate);  // Reverse the string
    $html = str_replace('{{signature_id}}', $reversedDate, $html);


    // Initialize Dompdf options
    $options = new Options();
    $options->set('fontDir', './fonts');
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('isRemoteEnabled', true); 
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

    // Generate and download the invoice PDF
    generate_invoice($invoice);
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <title>HolidaySeva</title> 
</head>

<body>
    <?php include('navigation.php') ?>
    <section class="home">

        <table style="width: 90%; margin-left:5%; margin-top:40px ;border-collapse: collapse; font-size: 14px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 0px; overflow: hidden;">
            <thead>
                <tr style="background-color:#0648a5; color: white;">
                    <th style="padding: 12px; text-align: left;font-weight:300;">Name</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">Mobile No</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">Pickup Address</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">Tour Package</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">Pricing</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">Extra req.</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">Date of Journey</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">No of Adults</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">Food Included</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">Status</th>
                    <th style="padding: 12px; text-align: left;font-weight:300;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($records->num_rows > 0) {
                    while ($row = $records->fetch_assoc()) {
                        echo "<tr style='border-bottom: 1px solid #ddd;'>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['customer_name'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['mobile_no'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['pickup_address'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['tour_package'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['pricing'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['special_requirements'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['date_of_journey'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['no_of_adults'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . ($row['food_included'] ? 'Yes' : 'No') . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . ($row['booking_status'] 
                        ? '<span style="color: #0648a5; font-weight: bold;">&#x2714;</span>' 
                        : '<span style="color: red; font-weight: bold;">&#x2716;</span>') . "</td>";
                        echo "<td style='padding: 12px;'>
                            <div style='position: relative;'>
                                <button style='background: none; border: none; cursor: pointer; font-size: 20px; color: #555;' 
                                        type='button' id='dropdownMenuButton" . $row['id'] . "' onclick='toggleDropdown(" . $row['id'] . ")'>
                                    &#x2022;&#x2022;&#x2022;
                                </button>
                                <ul id='dropdown" . $row['id'] . "' style='position:fixed; top: 30px; left: 80%; z-index: 1000; display: none; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); padding: 0; list-style: none;z-index: 3000:;'>
                                    <li style='padding: 10px 20px;'><a class='dropdown-item' href='index.php?confirm_booking_id=" . $row['id'] . "' style='text-decoration: none; color: #333;'>Confirm</a></li>
                                    <li style='padding: 10px 20px;'><a class='dropdown-item' href='index.php?delete_booking_id=" . $row['id'] . "' style='text-decoration: none; color: #333;'>Delete</a></li>
                                    <li style='padding: 10px 20px;'><a class='dropdown-item' href='invoice.php?download_invoice_id=" . $row['id'] . "' style='text-decoration: none; color: #333;'><span style='font-size: 16px; vertical-align: middle;'>&#x1F4BE;</span> Download Invoice</a></li>
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

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById('dropdown' + id);
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
        document.addEventListener('click', function (e) {
            const dropdowns = document.querySelectorAll("ul[id^='dropdown']");
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target) && dropdown.previousElementSibling !== e.target) {
                    dropdown.style.display = 'none';
                }
            });
        });
    </script>
</div>

    </section>

    <script src="script.js"></script>

</body>

</html>