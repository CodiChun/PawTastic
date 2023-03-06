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



        <!--
SELECT APPOINTMENT.APPOINTMENT_DATE AS "Appointment Date", APPOINTMENT.START_TIME AS "Start Time", PET.Name AS "Pet Name", PET_OWNER.NAME AS "Owner Name", PET_OWNER.PHONE AS "Owner Phone Number", PET_OWNER.EMAIL AS "Owner Email" FROM APPOINTMENT JOIN PET ON APPOINTMENT.PET_ID = PET.PET_ID JOIN PET_OWNER ON PET.OWNER_ID = PET_OWNER.CLIENT_ID ORDER BY `Appointment Date` ASC;


-->

        <!--Table Start-->
        <h1>
            Groom Frequency Statistics
        </h1>
        <table class="table table-success">
            <thead>
                <tr>
                    <th scope="col">Frequency</th>
                    <th scope="col">Service ID</th>
                    <th scope="col">Service Name</th>
                    <th scope="col">Service Cost</th>
                    <th scope="col">Service Type</th>
                    <th scope="col">Service Difficulty</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                if ( mysqli_connect_errno() )
                {
                    die( mysqli_connect_error() );
                }
                $sql = "SELECT COUNT(SERVICE.SERVICE_ID) AS 'Frequency',
                            SERVICE.SERVICE_ID AS 'Service ID',
                            SERVICE.SERVICE AS 'Service Name',
                            SERVICE.COST AS 'Service Cost',
                            SERVICE.TYPE AS 'Service Type',
                            SERVICE.DIFFICULTY AS 'Service Difficulty'
                        FROM SERVICE
                        JOIN APPOINTMENT ON APPOINTMENT.SERVICE_ID = SERVICE.SERVICE_ID
                        GROUP BY SERVICE.SERVICE_ID, SERVICE.SERVICE, SERVICE.COST, SERVICE.TYPE, SERVICE.DIFFICULTY
                        ORDER BY COUNT(SERVICE.SERVICE_ID) DESC";
                if ($result = mysqli_query($connection, $sql))
                {
                    // loop thrugh the data
                    while($row = mysqli_fetch_assoc($result))
                    {
                ?>
                <tr class="table-warning">
                    <td><?php echo $row['Frequency'] ?></td>
                    <td><?php echo $row['Service ID'] ?></td>
                    <td><?php echo $row['Service Name'] ?></td>
                    <td><?php echo $row['Service Cost'] ?></td>
                    <td><?php echo $row['Service Type'] ?></td>
                    <td><?php echo $row['Service Difficulty'] ?></td>
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