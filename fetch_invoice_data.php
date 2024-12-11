<?php
require 'database.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "SELECT * FROM invoice_data WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "No record found"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}

$conn->close();
?>
