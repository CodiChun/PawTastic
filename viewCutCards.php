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
                    <form class="d-flex">
                        <input class="form-control me-sm-2" type="search" placeholder="Search">
                        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Nav Bar End-->

        <!-- END -- Add HTML code for the top menu section (navigation bar) --> 

        <div class="jumbotron"> 
            <p class="lead">Select a pet's name or ID<p> 
            <hr class="my-4"> 
            <form method="GET" action="viewCutCards.php"> 
                <select name="vcc" onchange='this.form.submit()'> 
                    <option selected>Select a pet's name or ID</option> 

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
                <?php 
                if ($_SERVER["REQUEST_METHOD"] == "GET")  
                { 
                    if (isset($_GET['vcc']) )  
                    { 
                ?> 
                <p>&nbsp;</p> 
                <table class="table table-hover"> 
                    <thead> 
                        <tr class="table-success"> 
                            <th scope="col">Pet's Name</th> 
                            <th scope="col">Owner</th> 
                            <th scope="col">Bath Brush Notes</th> 
                            <th scope="col">Trim Tidy Notes</th> 
                            <th scope="col">Full Groom Notes</th>
                            <th scope="col">Nail Clip Notes</th>
                        </tr> 
                    </thead> 
                    <?php            
                        if ( mysqli_connect_errno() )
                        {
                            die( mysqli_connect_error() );
                        }
                        $sql = "
                        SELECT PET.Name AS PNAME, PET_OWNER.NAME AS ONAME, Bath_Brush_Notes, Trim_Tidy_Notes, Full_Groom_Notes, Nail_Clip_Notes
                        FROM PET
                        LEFT JOIN CUT_CARD
                        ON Cut_Card = Card_ID
                        LEFT JOIN PET_OWNER
                        ON Client_ID = Owner_ID
                        WHERE Pet_ID = {$_GET['vcc']}";

                        if ($result = mysqli_query($connection, $sql))  
                        { 
                            while($row = mysqli_fetch_assoc($result)) 
                            { 
                    ?> 
                    <tr> 
                        <td><?php echo $row['PNAME'] ?></td> 
                        <td><?php echo $row['ONAME'] ?></td> 
                        <td><?php echo $row['Bath_Brush_Notes'] ?></td> 
                        <td><?php echo $row['Trim_Tidy_Notes'] ?></td> 
                        <td><?php echo $row['Full_Groom_Notes'] ?></td>
                        <td><?php echo $row['Nail_Clip_Notes'] ?></td>
                    </tr> 
                    <?php 
                            } 
                            // release the memory used by the result set 
                            mysqli_free_result($result);  
                        }  
                    } // end if (isset) 
                } // end if ($_SERVER) 
                    ?> 
                </table> 
            </form> 
        </div> 

    </body> 
</html> 