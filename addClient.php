<?php require_once('config.php');?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel= "stylesheet" href = ./bootstrap.min.css>
        <title>Pawtastic</title>
    </head>




    <!-- Nav Bar Start-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Paw Tastic</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor03">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Appointment.php">Shedule an Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addClient.php">Add A New Client</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="newPet.php">Add A New Pet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="viewCutCards.php">View Cut Cards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="invoice.php">Invoice</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stats.php">Stats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- Nav Bar End-->
    <body>


        <!--
`INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
VALUES ('Thomas Hills', '(888)456-7891', 'thill91@gmail.com', '10 Street SW Kent, WA', '');
-->
        <form id="leform" action="addClient.php" method = "POST">
            <div class="form-group">
                <label for="clname">Full Name</label>
                <input type="text" id="clname" name="clname" placeholder="Enter Full Name" required>


                <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                <input type="email" placeholder="Enter email" required name = "email">


                <label for="phone" class="form-label mt-4" >Phone Number</label>
                <input type="tel" id="phone" name="phone"
                       pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                       placeholder="Enter Phone Number"
                       required>
                <label>Adress</label>
                <input id="address" name = "address" type="text" placeholder="Enter Address" required>
                <label>Notes</label>
                <input id="notes" name = "notes" type="text" placeholder="Any Notes?" required>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>




        <?php
        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if ( mysqli_connect_errno() )
        {
            die( mysqli_connect_error() );
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {

            if ( mysqli_connect_errno() )
            {
                die( mysqli_connect_error() );
            }

            $sql = "INSERT INTO PET_OWNER (Name, Phone, Email, Address, Note)  
                VALUES ('{$_POST['clname']}', '{$_POST['phone']}', '{$_POST['email']}', '{$_POST['address']}', '{$_POST['notes']}');";
            echo $sql;
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                die('Error: ' . mysqli_error($connection));
            }

            echo '<div class="alert alert-dismissible alert-success">
  <strong>Client Added!!</strong><a href="newPet.php">would you like to attach a pet</a>
</div>
';
        }
        ?>


















    </body>


</html>