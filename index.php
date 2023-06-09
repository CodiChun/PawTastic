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

    <!--Table Start-->
    <h1>
        Upcoming Appointments
    </h1>
    <table class="table table-danger">
        <thead>
            <tr>
                <th scope="col">Appointment Date</th>
                <th scope="col">Start Time</th>
                <th scope="col">Pet Name</th>
                <th scope="col">Owner Name</th>
                <th scope="col">Owner Phone Number</th>
                <th scope="col">Owner Email</th>
            </tr>
        </thead>
        <tbody>
                <?php
                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                if ( mysqli_connect_errno() )
                {
                    die( mysqli_connect_error() );
                }
            $sql = "SELECT APPOINTMENT.APPOINTMENT_DATE AS 'Appointment Date', APPOINTMENT.START_TIME AS 'Start Time', PET.Name AS 'Pet Name', PET_OWNER.NAME AS 'Owner Name', PET_OWNER.PHONE AS 'Owner Phone Number', PET_OWNER.EMAIL AS 'Owner Email' 
                    FROM APPOINTMENT 
                    JOIN PET ON APPOINTMENT.PET_ID = PET.PET_ID 
                    JOIN PET_OWNER ON PET.OWNER_ID = PET_OWNER.CLIENT_ID
                    WHERE Appointment_date > CURRENT_DATE
                    ORDER BY `Appointment Date` ASC;";
                if ($result = mysqli_query($connection, $sql))
                {
                    // loop thrugh the data
                    while($row = mysqli_fetch_assoc($result))
                    {
                ?>
            <tr class="table-success">
                <td><?php echo $row['Appointment Date'] ?></td>
                <td><?php echo $row['Start Time'] ?></td>
                <td><?php echo $row['Pet Name'] ?></td>
                <td><?php echo $row['Owner Name'] ?></td>
                <td><?php echo $row['Owner Phone Number'] ?></td>
                <td><?php echo $row['Owner Email'] ?></td>
            </tr>
            <?php
                    }
                    // release the memory used by the result set
                    mysqli_free_result($result);
                }
            ?>
        </tbody>
    </table>
    <!--Table End-->
</body>
</html>