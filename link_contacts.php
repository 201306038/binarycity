<?php
// Establish connection to the database
include 'conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form data
$contact_id = $_POST['contact_id'];
$client_ids = $_POST['client_ids'];    

// Insert new links
foreach ($client_ids as $client_id) {
    $sql_insert = "INSERT INTO contact_client (contact_id, client_id) VALUES ($contact_id, $client_id)";
    $conn->query($sql_insert);
}

header("Location: index.php");
echo "Contacts linked successfully";



$conn->close();
?>
