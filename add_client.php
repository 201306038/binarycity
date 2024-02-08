<?php
// Establish connection to the database
include 'conn.php';
// Fetch form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Function to generate client ID
function generateClientID($name) {
    $nameParts = preg_split('/\s+/', $name); // Split name by spaces
    $initials = strtoupper(substr($nameParts[0], 0, 3)); // Get first three letters of first name or first word after space
    $digits = sprintf("%03d", rand(0, 999)); // Generate random 3-digit number
    return $initials . $digits;
}


// Insert client data into database
$clientId = generateClientId($name);
$sql = "INSERT INTO clients (name, email, phone, address, client_code) VALUES ('$name', '$email', '$phone', '$address','$clientId')";

if ($conn->query($sql) === TRUE) { 
    echo "<script> arlet 'Added'<script>";
    header("Location: index.php");
   

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
