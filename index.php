<? php include_once 'head.php'; ?>
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
<div class="row m-5 p-5">
    <div class="col-6">
        <div class="card m-5 p-3 bg-dark text-white">
            <h2 class="badge bg-primary">Create New Client</h2>
            <form action="add_client.php" method="post">
                <label>Name:</label><br>
                <input class="form-control form-control-lg" type="text" name="name" required><br>
                <label>Email:</label><br>
                <input class="form-control form-control-lg" type="email" name="email" required><br>
                <label>Phone:</label><br>
                <input class="form-control form-control-lg" type="text" name="phone"><br>
                <label>Address:</label><br>
                <textarea class="form-control form-control-lg" name="address"></textarea><br>
                <input class="btn btn-lg btn-primary"  type="submit" value="Create Client">
            </form>
        </div>
    </div>

    <div class="col-6">
        <div class="card m-5 p-3 bg-dark text-white">
        <h2 class="badge bg-primary">List of Clients</h2>
        <div class="card m-5 p-3 bg-dark text-white">
            <table border="1" class="table table-striped table-dark table-hover p-3">
                <tr>
                    <th>Name</th>
                    <th>Client Code</th>
                    <th>Linkeded Contacts</th>
                </tr>
                <?php
                include 'conn.php';

                // Select and display clients ordered by name ascending
                $sql = "SELECT
                c.`name` AS client_name, 
                COUNT(cc.contact_id) AS num_contacts, 
                c.id, 
                c.client_code AS client_code
            FROM
                clients AS c
                LEFT JOIN
                contact_client AS cc
                ON 
                    c.id = cc.client_id
            GROUP BY
                c.id ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['client_name']."</td>";
                        echo "<td>".$row['client_code']."</td>";
                        echo "<td>".$row['num_contacts']."</td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "0 results";
                }

                $conn->close();
                ?>
            </table>
        </div>
        </div>
    </div>
</div>





    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>
