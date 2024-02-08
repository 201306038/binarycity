<!DOCTYPE html>
<html>
<head>
    <title>Create Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-primary">


<nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Contact Link System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        <a class="nav-link" href="contact.php">Contact</a>
        <a class="nav-link" href="index.php" aria-disabled="true">Clients</a>
      </div>
    </div>
  </div>
</nav>
<div class="m-3 p-5">
</div>
<div class="row">
<div class="col-6 m-4">
        <h2 class="badge bg-primary">Link Contacts to Clients</h2>
    <form class="form-control" action="link_contacts.php" method="post">
        <label>Select Contact:</label><br>
        <select class="form-control form-control-sm" name="contact_id" required>
            <!-- Populate the options dynamically from your database -->
            <?php
            // Establish connection to the database
            include 'conn.php';

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch contacts from the database
            $sql_contacts = "SELECT id, name FROM contacts";
            $result_contacts = $conn->query($sql_contacts);

            if ($result_contacts->num_rows > 0) {
                while($row_contact = $result_contacts->fetch_assoc()) {
                    echo "<option value='".$row_contact['id']."'>".$row_contact['name']."</option>";
                }
            }

            $conn->close();
            ?>
        </select><br><br>
        <label>Select Clients:</label><br>
        <select class="form-control form-control-sm" name="client_ids[]" multiple required>
            <!-- Populate the options dynamically from your database -->
            <?php
            // Establish connection to the database
            include "conn.php";
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch clients from the database
            $sql_clients = "SELECT * FROM clients";
            $result_clients = $conn->query($sql_clients);

            if ($result_clients->num_rows > 0) {
                while($row_client = $result_clients->fetch_assoc()) {
                    echo "<option value='".$row_client['id']."'>".$row_client['name']."</option>";
                }
            }

            $conn->close();
            ?>
        </select><br><br>
        <input class="form-control btn btn-primary form-control-lg" type="submit" value="Link Contacts to Clients">
    </form>

    </div>

    <div class="col-5 m-4">

    <?php
// Database connection


include 'conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a unique contact ID
function generateContactID() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $contact_id = '';
    for ($i = 0; $i < 6; $i++) {
        $contact_id .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $contact_id;
}

// Function to create a new contact
function createContact($name, $email, $phone) {
    global $conn;
    $contact_id = generateContactID();
    // Insert the contact into the database
    $sql = "INSERT INTO contacts (id, name, email, phone) VALUES ('$contact_id', '$name', '$email', '$phone')";
    if ($conn->query($sql) === TRUE) {
        echo "New contact created successfully with ID: $contact_id";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone'])) {
    // Sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    
    // Create the contact
    createContact($name, $email, $phone);
}
?>

<!-- HTML form for creating a new contact -->
<h2 class="badge bg-primary">Link Contacts to Clients</h2>
<form class="form-control" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Name: <input class="form-control" type="text" name="name" required><br>
    Email: <input class="form-control" type="email" name="email" required><br>
    Phone: <input class="form-control" type="text" name="phone" required><br>
    <input class="form-control btn btn-primary" type="submit" value="Create Contact">
</form>


    </div>
</div>
<div class="row">
    <div class="col-5 m-3 p-4 bg-white">
    <?php
    include 'conn.php';


// Display contacts with the number of clients linked to each contact
$sql = "SELECT * FROM contact_view";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-dark m-4 p-4'><tr><th>Contact ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Number of Clients</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["email"]."</td><td>".$row["phone"]."</td><td>".$row["num_clients"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No contacts found";
}

$conn->close();?>
</div>
</div>
</div>
    
</body>
</html>
