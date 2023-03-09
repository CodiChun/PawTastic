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
INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note) 
VALUES ('Tarzan', 1001, 'Tabby', DATE '2011-1-11', 6, 2005, 'Yes', 'Yes', 'Friendly old orange cat');

-->


<h1>
    Enter New Pet's Info
        </h1>
        <form id="leform" action="newPet.php" method = "POST">
            <label for="petOwner" >Owner</label>
            <select name="petOwner" id="petOwner" required >
                <?php
                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                if ( mysqli_connect_errno() ){
                    die( mysqli_connect_error() );
                }
                $sql = "SELECT * FROM PET_OWNER ORDER BY Name";
                if ($result = mysqli_query($connection, $sql))
                {
                    // loop through the data
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '<option value="' . $row['Client_ID'] . '">';
                        echo $row['Name']. ', '. $row['Client_ID'];
                        echo "</option>";
                    }
                    // release the memory used by the result set
                    mysqli_free_result($result);
                }
                ?>
            </select>
            <div class="form-group">
                <label for="clname">Pets Name</label>
                <input type="text" id="pname" name="pname" placeholder="Enter Pet's Name" required>


                <label for="breed" class="form-label mt-4">Breed</label>
                <input type="text" placeholder="Enter Animal Breed" required name = "breed">

                <div>
                    <label for="date">Date Of Birth:</label>
                    <input type="date" id="Date" name="apptDate" required>
                    <label for="weight" class="form-label mt-4" >Weight</label>
                    <input type="number" id="weight" name="weight"
                       placeholder="Enter Pet's weight"required>
                </div>
                <div>
                    <label for="cutcard">Cut card</label>
                    <input id="cutcard" name = "cutcard" type="number" placeholder="Assign Cut Card" required>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="chip">
                    <label class="form-check-label" for="chip">
                        Microchiped?
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rab">
                    <label class="form-check-label" for="rab">Vacinated Aganst Rabbies?</label>
                </div>
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

           // $sql = "INSERT INTO PET(Name, Owner_id, Breed, Birthday, Weight, Cut_Card, Microchipped, Rabies_Vaccine, Note)
          //          VALUES ('Tarzan', 1001, 'Tabby', DATE '2011-1-11', 6, 2005, 'Yes', 'Yes', 'Friendly old orange cat');";
           //echo $sql;
            //$result = mysqli_query($connection, $sql);
            //if (!$result) {
              //  die('Error: ' . mysqli_error($connection));
            //}

            echo '<div class="alert alert-dismissible alert-success">
  <strong>Client Added!!</strong><a href="newPet.php">would you like to attach a pet</a>
</div>
';
        }
        ?>


    </body>


</html>