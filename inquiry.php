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
    header("Location: inquiry.php");
}

// Handle Delete Booking
if (isset($_GET['delete_booking_id'])) {
    $invoice_id = $_GET['delete_booking_id'];
    $conn->query("UPDATE invoice_data SET booking_status = 'Declined' WHERE id = $invoice_id");
    // $conn->query("DELETE FROM invoice_data WHERE id = $invoice_id");
    header("Location: inquiry.php");
}

// Fetch all confirmed records
$records = $conn->query("SELECT * FROM invoice_data WHERE booking_status = 'Confirmed'");
function generate_invoice($invoice) {
    $html = file_get_contents('generate.html');
    if ($invoice['tour_package'] == 'GangaSagar Tour Package 1 Night 2 Days') {
        $tour_details_html = '<div class="important">
      <div class="text">
        <strong>GangaSagar Tour Package 1 Night 2 Days</strong>
        <br />
        <br />
        <strong> Day 01: Kolkata to Ganga Sagar Yatra package(130Kms/5:00 Hrs) : </strong><br>Meet and greet upon arrival at the airport, station, city, or hotel, followed by the start of the journey to Ganga Sagar. Ganga Sagar is an island at the confluence of the Ganges River and the Bay of Bengal, renowned for the Kapil Muni Ashram, which holds immense religious significance. Spend the entire day exploring Ganga Sagar, followed by an overnight stay at a Ganga Sagar accommodation.
        <br />
        <br />
        <strong> Day 02: Ganga Sagar to Kolkata Drop : </strong><br>In the morning, visit Ganga Sagar for darshan, complete your puja and rituals, and take a holy bath. Return to the accommodation, collect your luggage, and check out. Proceed for a transfer to Kolkata, carrying sweet memories of your time at Ganga Sagar.
              <!-- <strong>Day 02:</strong> Ganga Sagar to Kolkata - Complete your puja
        and take a holy bath. After checkout, return to Kolkata.
        <br />
        <strong>Note:</strong> Exclusive AC Vehicle Service from Kolkata to
        Ferry Ghat. -->
        <br />
      </div>
    </div>';
}
    
    $html = str_replace('{{tour_details}}', $tour_details_html, $html);
    $html = str_replace('{{customer_name}}', $invoice['customer_name'], $html);
    $html = str_replace('{{mobile_no}}', $invoice['mobile_no'], $html);
    $html = str_replace('{{customer_email_id}}', $invoice['customer_email_id'], $html);
    $html = str_replace('{{pickup_address}}', $invoice['pickup_address'], $html);
    $html = str_replace('{{drop_address}}', $invoice['drop_address'], $html);
    $html = str_replace('{{tour_package}}', $invoice['tour_package'], $html);
    $html = str_replace('{{pricing}}', $invoice['pricing'], $html);
    $html = str_replace('{{token_paid}}', $invoice['token_paid'], $html);

    $price = isset($invoice['pricing']) ? (float)$invoice['pricing'] : 0;
    $token_paid = isset($invoice['token_paid']) ? (float)$invoice['token_paid'] : 0;
    $pending_amount = $price*0.5;

    $html = str_replace('{{pending_amount}}', $pending_amount, $html);
    $html = str_replace('{{special_requirements}}', $invoice['special_requirements'], $html);
    $html = str_replace('{{date_of_journey}}', $invoice['date_of_journey'], $html);
    $html = str_replace('{{date_of_return}}', $invoice['date_of_return'], $html);
    $html = str_replace('{{no_of_adults}}', $invoice['no_of_adults'], $html);
    $html = str_replace('{{no_of_children}}', $invoice['no_of_children'], $html);
    $html = str_replace('{{cars_provided}}', $invoice['cars_provided'], $html);
    $html = str_replace('{{no_of_cars}}', $invoice['no_of_cars'], $html);
    $html = str_replace('{{meal_plan}}', $invoice['meal_plan'], $html);
    $html = str_replace('{{hotel_used}}', $invoice['hotel_used'], $html);
    $html = str_replace('{{hotel_room_details}}', $invoice['hotel_room_details'], $html);


    // Get the registration_date value
    $registration_date = $invoice['registration_date'];
    $cleaned_registration_date = preg_replace('/[^A-Za-z0-9]/', '', $registration_date);
    $reversed_registration_date = strrev($cleaned_registration_date);
    $html = str_replace('{{signature_id}}', $reversed_registration_date, $html);


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
    // $dompdf->stream('invoice.pdf', array('Attachment' => 0));

    $fullName = $invoice['customer_name'];
    $firstName = strtok($fullName, ' ');
    $firstName = preg_replace('/[^a-zA-Z0-9]/', '', $firstName);
    $filename = 'Let the Adventure begin ' . $firstName . '.pdf';
    $dompdf->stream($filename, array('Attachment' => 0));


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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <title>HolidaySeva</title> 
</head>

<body>
    <!-- <?php include('navigation.php') ?> -->
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
                        echo "<td style='padding: 12px;font-weight: 200;font-size:0.9rem;'>" . $row['pickup_address'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['tour_package'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['pricing'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;font-size:0.9rem;'>" . $row['special_requirements'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;font-size:0.9rem;'>" . $row['date_of_journey'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . $row['no_of_adults'] . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . ($row['food_included'] ? 'Yes' : 'No') . "</td>";
                        echo "<td style='padding: 12px; font-weight: 300;'>" . 
     ($row['booking_status'] === 'Confirmed' 
        ? '<span style="color: #0648a5; font-weight: bold;">&#x2714;</span>'  // Tick mark for confirmed
        : '<span style="color: orange; font-weight: bold;">&#x26A0;</span>') .   // Warning sign for pending
     "</td>";

                        echo "<td style='padding: 12px;'>
                            <div style='position: relative;'>
                                <button style='background: none; border: none; cursor: pointer; font-size: 20px; color: #555;' 
                                        type='button' id='dropdownMenuButton" . $row['id'] . "' onclick='toggleDropdown(" . $row['id'] . ")'>
                                    &#x2022;&#x2022;&#x2022;
                                </button>
                                <ul id='dropdown" . $row['id'] . "' style='position:fixed; top: 30px; left: 80%; z-index: 1000; display: none; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); padding: 0; list-style: none;z-index: 3000:;'>
                                    <li style='padding: 10px 20px;'><a class='dropdown-item' href='inquiry.php?confirm_booking_id=" . $row['id'] . "' style='text-decoration: none; color: #333;'>Confirm</a></li>
                                    <li style='padding: 10px 20px;'><a class='dropdown-item' href='inquiry.php?delete_booking_id=" . $row['id'] . "' style='text-decoration: none; color: #333;'>Delete</a></li>
                                    <li style='padding: 10px 20px;'><a class='dropdown-item' href='inquiry.php?download_invoice_id=" . $row['id'] . "' style='text-decoration: none; color: #333;'> Download Itinery</a></li>
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