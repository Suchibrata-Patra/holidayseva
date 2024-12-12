<?php
require 'database.php' ?>
<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search results
$search_results = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['search'])) {
    $search_query = $conn->real_escape_string($_POST['search']);
    
    // Search the database based on customer_name or mobile_no
    $sql = "SELECT * FROM invoice_data WHERE customer_name LIKE '%$search_query%' OR mobile_no LIKE '%$search_query%' OR id LIKE '%$search_query%' OR id LIKE '%$search_query%'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Fetch all matching rows
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    } else {
        $search_results[] = "No results found for '$search_query'.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>HolidaySeva</title>
</head>

<body>
    <?php include('navigation.php') ?>
    <section class="home">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            .search-bar {
                margin-bottom: 20px;
            }

            .search-results {
                margin-top: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid #ddd;
            }

            th,
            td {
                padding: 10px;
                text-align: left;
            }
        </style>
        </head>

        <body>




            <div class="search-results" style="margin:5%;">

                <center>
                    <form method="POST" action="" class="search-bar" style="margin-bottom: 20px; text-align: center;">
                        <input type="text" name="search" placeholder=" Enter customer name or mobile number" required 
                               style="padding: 10px; font-size: 14px; border: 1.5px solid #0d5d9f; border-radius: 50px; width: 700px;" value='<?php echo $search_query; ?>'>
                        <!-- <button type="submit" style="padding: 13px 20px; background-color: #0d5d9f; color: white; border: none; border-radius: 5px; cursor: pointer;margin-left:-5px;">Search</button> -->
                    </form>
                </center>
                
                <?php if (!empty($search_results)): ?>
                    <?php if (is_array($search_results)): ?>
                        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                            <?php foreach ($search_results as $result): ?>
                                <div style="border: 1px solid #ddd; border-radius: 10px; display: flex; width:90%; padding: 20px; background-color: #ffffff;">
                                    <div style="flex: 1; padding-right: 20px;">
                                        <!-- <h3 style="font-size: 18px; color: #0d5d9f;font-weight:500;"><?php echo $result['customer_name']; ?></h3> -->
                                        <h3 style="font-size: 18px; color: #0d5d9f; font-weight: 500;">
                                                 <?php echo $result['customer_name']; 
                                                            if ($result['booking_status'] === 'Confirmed') { 
                                                    echo ' <span style="font-family: \'Material Icons\'; font-size: 20px; color: #379df0;paddgin-top:1px;">verified</span>'; 
                                                                 } 
                                                 ?></h3>
 
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Customer ID : </strong> <?php echo $result['id']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Mobile : </strong> <?php echo $result['mobile_no']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Pickup : </strong> <?php echo $result['pickup_address']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Drop : </strong> <?php echo $result['drop_address']; ?></p>
                                    </div>
                                    <div style="flex: 1; padding-left: 20px; border-left: 1px solid #ddd;">
                                        <h3 style="font-size: 18px; color: #0d5d9f;"></h3>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Tour Package:</strong> <?php echo $result['tour_package']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Pricing:</strong> <?php echo $result['pricing']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Token Paid:</strong> <?php echo $result['token_paid']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Date of Journey:</strong> <?php echo $result['date_of_journey']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Meal Plan:</strong> <?php echo $result['meal_plan']; ?></p>
                                    </div>
                                    <div style="flex: 1; padding-left: 20px; border-left: 1px solid #ddd;">
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Cars Provided:</strong> <?php echo $result['cars_provided']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">No of Cars:</strong> <?php echo $result['no_of_cars']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Food Included:</strong> <?php echo $result['food_included']; ?></p>
                                        <p><strong style="font-weight:400 !important;color:#0d5d9f;">Booking Status:</strong> <?php echo $result['booking_status']; ?></p>
                                    </div>
                                    
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="font-size: 16px; color: #333;"><?php echo $search_results[0]; ?></p>
                    <?php endif; ?>
                <?php endif; ?>
                
                
            </div>
            <script src="script.js"></script>

        </body>

</html>