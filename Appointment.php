<!DOCTYPE html>
<?php require_once('config.php');?>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" href = ./bootstrap.min.css>
    <title>Pawtastic</title>
</head>
<body>
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
                    <a class="nav-link" href="reminderList.php">Call List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stats.php">Stats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>
                <!--
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
<div class="dropdown-menu">
<a class="dropdown-item" href="#">Action</a>
<a class="dropdown-item" href="#">Another action</a>
<a class="dropdown-item" href="#">Something else here</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#">Separated link</a>
</div>
</li>
-->
            </ul>
            <form class="d-flex">
                <input class="form-control me-sm-2" type="search" placeholder="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
<!-- Nav Bar End-->

    <form action="Appointment.php" method = "POST" >
    <label for="pet" >Pet</label>
        <select name="pet" id="pet" required>
        <?php
        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if ( mysqli_connect_errno() )
        {
            die( mysqli_connect_error() );
        }
        $sql = "SELECT * FROM PET ORDER BY Name"; 
        if ($result = mysqli_query($connection, $sql))  
        {
            // loop through the data 
            while($row = mysqli_fetch_assoc($result)) 
            {
                echo '<option value="' . $row['Pet_ID'] . '">';
                echo $row['Name']. ', '. $row['Pet_ID'];
                echo "</option>";
            }
            // release the memory used by the result set
            mysqli_free_result($result);
        }

        ?>
    </select>
    <label for="serv" >Service</label>
        <select name="serv" id="serv" required>
        <?php 
        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if ( mysqli_connect_errno() )
        {
            die( mysqli_connect_error() );
        }
        $sql = "SELECT * FROM SERVICE ORDER BY Service, Difficulty";
        if ($result = mysqli_query($connection, $sql))  
        {
            // loop through the data 
            while($row = mysqli_fetch_assoc($result)) 
            {
                echo '<option value="' . $row['Service_ID'] . '">';
                echo $row['Service']. ', '. $row['Service_ID'];
                echo ' Difficulty' . ', '. $row['Difficulty'];;
                echo "</option>";
            }
            // release the memory used by the result set
            mysqli_free_result($result);
        }

        ?>
    </select>


    <label for="apptStart">Start Time:</label>
        <input type="time" id="apptStart" name = "apptStart"
               min="09:00" max="18:00" required>
     <label for="apptEnd">End Time:</label>
        <input type="time" id="apptEnd" name = "apptEnd"
               min="09:00" max="18:00" required>
        <label for="date">Apppointment Date:</label>

        <input type="date" id="Date" name="apptDate" required>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<!--

INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Client_id, Pet_id, Service_id)
VALUES (DATE '2023-3-2', '14:30', '15:00', 1008, 3003, 4001);

POST METHOD GOES HERE
FORM SQL QUIRY FROM FORM XD on submit

echo a card or something saying sucsess

-->

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

        if ( mysqli_connect_errno() )
        {
            die( mysqli_connect_error() );
        }
        $sql = "INSERT INTO APPOINTMENT (Appointment_Date, Start_Time, End_Time, Pet_id, Service_id)
        VALUES (DATE '{$_POST['apptDate']}', '{$_POST['apptStart']}','{$_POST['apptEnd']}', '{$_POST['pet']}', '{$_POST['serv']}');";
        echo $sql;
       mysqli_query($connection, $sql);
        //echo $_POST['apptStart'];
        //echo $_POST['apptEnd'];
       // echo $_POST['apptDate'];
      //  echo $_POST['pet'];
       // echo $_POST['serv'];
        echo '<div class="alert alert-dismissible alert-success">
  <strong>Appointmnet Has been made!</strong><a href="index.php"> Please See All Appointments</a>
</div>
';
    }
    ?>














    </body>
</html>