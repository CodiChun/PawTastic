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
                            <a class="nav-link" href="reminderList.php">Call List</a>
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
                    <form class="d-flex">
                        <input class="form-control me-sm-2" type="search" placeholder="Search">
                        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Nav Bar End-->


        <!--Table Start-->
        <h1>
            Unpaid Service
        </h1>
        <table class="table table-info">
            <thead>
                <tr>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Client's Name</th>
                    <th scope="col">Pet's Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                if ( mysqli_connect_errno() )
                {
                    die( mysqli_connect_error() );
                }
                $sql = "SELECT Appointment_ID, Appointment_date, PET.Name AS PNAME, PET_OWNER.NAME AS CNAME, EMAIL, COST
                        FROM APPOINTMENT
                        LEFT JOIN PET ON APPOINTMENT.Pet_ID = PET.Pet_ID
                        LEFT JOIN PET_OWNER ON PET.Owner_ID = PET_OWNER.CLIENT_ID
                        LEFT JOIN SERVICE ON APPOINTMENT.SERVICE_ID = SERVICE.SERVICE_ID
                        WHERE Appointment_date < CURRENT_DATE;";
                if ($result = mysqli_query($connection, $sql))
                {
                    // loop thrugh the data
                    while($row = mysqli_fetch_assoc($result))
                    {
                ?>
                <tr class="table-danger">
                    <td><?php echo $row['Appointment_ID'] ?></td>
                    <td><?php echo $row['Appointment_date'] ?></td>
                    <td><?php echo $row['CNAME'] ?></td>
                    <td><?php echo $row['PNAME'] ?></td>
                    <td><?php echo $row['EMAIL'] ?></td>
                    <td><?php echo '$'.$row['COST'] ?></td>
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
        

        <div class="jumbotron"> 
            <p class="lead">Select an appointment ID to generate emial<p> 
            <hr class="my-4"> 
            <form method="GET" action="invoice.php"> 
                <select name="aid" onchange='this.form.submit()'> 
                    <option selected>Select an appointment ID</option> 

                    <?php 
                    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
                    if ( mysqli_connect_errno() )  
                    { 
                        die( mysqli_connect_error() );   
                    } 
                    $sql = "SELECT Appointment_ID
                        FROM APPOINTMENT
                        WHERE Appointment_date < CURRENT_DATE;"; 
                    if ($result = mysqli_query($connection, $sql))  
                    { 
                        // loop through the data 
                        while($row = mysqli_fetch_assoc($result)) 
                        { 
                            echo '<option value="' . $row['Appointment_ID'] . '">'; 
                            echo $row['Appointment_ID'];  
                            echo "</option>"; 
                        } 
                        // release the memory used by the result set 
                        mysqli_free_result($result);  
                    }  
                    ?>  
                </select> 
                <?php 
                if ($_SERVER["REQUEST_METHOD"] == "GET")  
                { 
                    if (isset($_GET['aid']) )  
                    { 
                ?> 
                <p>&nbsp;</p>

                    <?php
                        if ( mysqli_connect_errno() )
                        {
                            die( mysqli_connect_error() );
                        }
                        $sql = "
                        SELECT Appointment_ID, APPOINTMENT_Date, Service, PET_OWNER.NAME AS CNAME, EMAIL, COST
                        FROM APPOINTMENT 
                        LEFT JOIN PET ON APPOINTMENT.Pet_ID = PET.Pet_ID
                        LEFT JOIN PET_OWNER 
                        ON PET.Owner_ID = PET_OWNER.CLIENT_ID
                        LEFT JOIN SERVICE 
                        ON APPOINTMENT.SERVICE_ID = SERVICE.SERVICE_ID
                        WHERE Appointment_ID = {$_GET['aid']}
                        ";

                        if ($result = mysqli_query($connection, $sql))  
                        {
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                    ?> 
                <div class="card text-white bg-warning mb-3" style="max-width: 70rem;">
                    <div class="card-header">To:&nbsp;<?php echo $row['EMAIL'] ?></div>
                    <div class="card-body">
                        <p class="card-text">Dear <?php echo $row['CNAME'] ?>, <br><br>

                            Thank you for choosing our pet grooming services. Please find the invoice for your recent pet grooming services below:<br><br>

                            Appointment Number: <?php echo $row['Appointment_ID'] ?><br>
                            Service Date: <?php echo $row['APPOINTMENT_Date'] ?><br>
                            Description of Service: <?php echo $row['Service'] ?><br>
                            Total Amount Due: <?php echo $row['COST'] ?><br><br>

                            Payment is due within 30 days from the date of this email. <br><br>

                            We appreciate your business and look forward to seeing you and your pet again soon.<br><br>

                            Best regards,<br>
                            Paw Tastic</p>
                    </div>
                </div>
                <button type="button" class="btn btn-success">Send</button>
                <button type="button" class="btn btn-danger">Cancel</button>
                    <?php 
                            } 
                            // release the memory used by the result set 
                            mysqli_free_result($result);  
                        }
                    } // end if (isset) 
                } // end if ($_SERVER) 
                    ?> 
            </form> 
        </div> 


    </body>
