<?php
require 'vendor/autoload.php';  // Load DOMPDF library
require 'database.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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


// Handle Update Booking
if (isset($_POST['update_invoice_id'])) {
    $id = (int) $_POST['update_invoice_id'];
    $customer_name = $_POST['customer_name'];
    $mobile_no = $_POST['mobile_no'];
    $pickup_address = $_POST['pickup_address'];
    $drop_address = $_POST['drop_address'];
    $tour_package = $_POST['tour_package'];
    $pricing = $_POST['pricing'];
    $token_paid = $_POST['token_paid'];
    $special_requirements = $_POST['special_requirements'];
    $date_of_journey = $_POST['date_of_journey'];
    $no_of_adults = $_POST['no_of_adults'];
    $food_included = isset($_POST['food_included']) ? 1 : 0;

    $sql = "UPDATE invoice_data SET customer_name = '$customer_name', mobile_no = '$mobile_no', pickup_address = '$pickup_address',drop_address = '$drop_address', 
            tour_package = '$tour_package', pricing = '$pricing',token_paid = '$token_paid', special_requirements = '$special_requirements', 
            date_of_journey = '$date_of_journey', no_of_adults = '$no_of_adults', food_included = $food_included WHERE id = $id";

    $conn->query($sql);
    header("Location: invoice.php");
    exit;
}

// Fetch all confirmed records
$records = $conn->query("SELECT * FROM invoice_data WHERE booking_status = 'Confirmed'");
function generate_invoice($invoice) {
    $html = file_get_contents('invoice.html');
    $html = str_replace('{{customer_name}}', $invoice['customer_name'], $html);
    $html = str_replace('{{mobile_no}}', $invoice['mobile_no'], $html);
    $html = str_replace('{{pickup_address}}', $invoice['pickup_address'], $html);
    $html = str_replace('{{drop_address}}', $invoice['drop_address'], $html);
    $html = str_replace('{{tour_package}}', $invoice['tour_package'], $html);
    $html = str_replace('{{pricing}}', $invoice['pricing'], $html);
    $html = str_replace('{{token_paid}}', $invoice['token_paid'], $html);

    $price = isset($invoice['pricing']) ? (float)$invoice['pricing'] : 0;
    $token_paid = isset($invoice['token_paid']) ? (float)$invoice['token_paid'] : 0;
    $pending_amount = $price - $token_paid;

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
    <?php include('navigation.php'); ?>
    <section class="home">
        <table style="width: 90%; margin: 40px auto; border-collapse: collapse; font-size: 14px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <thead>
                <tr style="background-color:#0648a5; color: white;">
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
                    <!-- <th style="padding: 12px; text-align: left;font-weight:300;">Action</th> -->
                    <th style="padding: 12px; text-align: left;font-weight:300;">More</th>
                </tr>
            </thead>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($records && $records->num_rows > 0) {
                    while ($row = $records->fetch_assoc()) {
                        echo "<tr style='border-bottom: 1px solid #ddd;'>";
                        echo "<td style='padding: 12px;font-weight: 300;'>{$row['customer_name']}</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>{$row['mobile_no']}</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>{$row['pickup_address']}</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>{$row['tour_package']}</td>";

                        // echo "<td style='padding: 12px;font-weight: 300;'>{$row['pricing']}</td>";
                        
                        echo "
                        <td style='padding: 12px;font-weight: 300;font-size:0.8rem !important;'>
                          <span style='display: inline-block; text-align: center; color: " . 
                          (($row['token_paid'] == $row['pricing']) ? 'green' : 'red') . ";'>
                            <span style='display: block; font-weight: 500;'>{$row['token_paid']}</span>
                            <span style='display: block; font-weight: 500; border-top: 1px solid #000;'>{$row['pricing']}</span>
                          </span>
                        </td>";
                        
                        




                        echo "<td style='padding: 12px;font-weight: 300;'>{$row['special_requirements']}</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>{$row['date_of_journey']}</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>{$row['no_of_adults']}</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . ($row['food_included'] ? 'Yes' : 'No') . "</td>";
                        echo "<td style='padding: 12px;font-weight: 300;'>" . ($row['booking_status'] ? '<span style="color: #0648a5; font-weight: bold;">&#x2714;</span>' : '<span style="color: red; font-weight: bold;">&#x2716;</span>') . "</td>";
                        // echo "<td style='padding: 12px;font-weight: 300;'><button onclick='openEditModal({$row['id']})' style='color:black;background:white;border:0.5px solid grey;padding:3px 9px;border-radius:50px;'>Edit</button></td>";
                        
                        echo "<td style='padding: 12px;'>
                            <div style='position: relative;'>
                                <button style='background: none; border: none; cursor: pointer; font-size: 20px; color: #555;' 
                                        type='button' id='dropdownMenuButton" . $row['id'] . "' onclick='toggleDropdown(" . $row['id'] . ")'>
                                    &#x2022;&#x2022;&#x2022;
                                </button>
                                <ul id='dropdown" . $row['id'] . "' style='position:fixed; top: 30px; left: 80%; z-index: 1000; display: none; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); padding: 0; list-style: none;z-index: 3000:;'>

                                    <li style='padding: 10px 20px;'><button onclick='openEditModal({$row['id']})' style='color:black;background:white;border:0.5px solid black;padding:6px 15px;border-radius:0px;'>Edit</button></li>
                                    
                                    <li style='padding: 10px 20px;'><a class='dropdown-item' href='inquiry.php?confirm_booking_id=" . $row['id'] . "' style='text-decoration: none; color: #333;'>Confirm</a></li>

                                    <li style='padding: 10px 20px;'><a class='dropdown-item' href='inquiry.php?delete_booking_id=" . $row['id'] . "' style='text-decoration: none; color: #333;'>Delete</a></li>

                                    <li style='padding: 10px 20px;'><a class='dropdown-item' href='invoice.php?download_invoice_id=" . $row['id'] . "' style='text-decoration: none; color: #333;'> Download Invoice</a></li>

                                </ul>
                            </div>
                        </td>";


                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12' style='text-align: center;'>No records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- Edit Modal -->
    <?php include'invoice_moal_edit_form.php' ?>



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
    

    function openEditModal(id) {
    document.getElementById('editModal').style.display = 'block';
    
    fetch(`fetch_invoice_data.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('update_invoice_id').value = data.id;
            document.getElementById('user_id').value = data.id;
            document.getElementById('customer_name').value = data.customer_name;
            document.getElementById('mobile_no').value = data.mobile_no;
            document.getElementById('pickup_address').value = data.pickup_address;
            document.getElementById('drop_address').value = data.drop_address;
            document.getElementById('tour_package').value = data.tour_package;
            document.getElementById('pricing').value = data.pricing;
            document.getElementById('token_paid').value = data.token_paid;
            document.getElementById('special_requirements').value = data.special_requirements;
            document.getElementById('date_of_journey').value = data.date_of_journey;
            document.getElementById('date_of_return').value = data.date_of_return;
            document.getElementById('no_of_adults').value = data.no_of_adults;
            document.getElementById('no_of_children').value = data.no_of_children;
            document.getElementById('cars_provided').value = data.cars_provided;
            document.getElementById('no_of_cars').value = data.no_of_cars;
            document.getElementById('food_included').checked = data.food_included === "1";
            document.getElementById('meal_type').value = data.meal_plan;
            document.getElementById('hotel_used').value = data.hotel_used;
            document.getElementById('hotel_room_details').value = data.hotel_room_details;
        })
        .catch(error => console.error('Error fetching data:', error));
}


function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
  }
    </script>
        <script src="script.js"></script>

</body>

</html>
