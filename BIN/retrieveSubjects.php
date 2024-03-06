<?php

$projectDir = "../../";
// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/classes/DBconnect.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';


$prevDir = isset($prevDir) ? "" : "../";
$pageName = isset($pageName) ? $pageName : null;
include 'loginControl.php';
 
include_once '../config/config.php';
include_once 'classes/DBconnect.php';
include_once 'utils/executePreparedStatement.php';

$connection = new DatabaseConnect();

$degreeID = $_GET['selectedDegreeIndex'];

$sqlStatement = " SELECT id, name, cfu, year 
                  FROM subject 
                  WHERE degreecourse = ?;";
$parameterType = "i";
$parameters = array($degreeID);
$result = executePreparedStatement(
      $sqlStatement,
      $affectedRows,
      $parameterType,
      $parameters
);

$resultArray = array();

if($affectedRows > 0){
      while($row = $result->fetch_assoc())
            $resultArray[] = $row;
}

echo json_encode($resultArray);

/*
// Connessione al database MySQL
include '../config/config.php';
$conn = mysqli_connect(DB_host, DB_user, DB_pass, DB_name, DB_port);

if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Take the selected degree's ID
$degreeID = $_GET['selectedDegreeIndex'];
$degreeName = $_GET['selectedDegreeName'];

// Query to get all of the selected degree's subjects
$query = "SELECT id, name, cfu, year FROM subject WHERE degreecourse = $degreeID;";
$result = $conn->query($query);

$first = true;
$current = -1;
if (mysqli_affected_rows($conn) > 0) {
    // Default disabled selected option
    echo "<option disabled selected style=\"font-style: italic;\"> -- seleziona una materia --</option>";

    // display all subjects as options to choose from
    while($row = $result->fetch_assoc()) {

        // group subjects by their years
        if($current != $row['year']){
              if(!$first){
                    echo "</optgroup>";
                    $first = false;
              }
              echo "<optgroup label = \"Anno " . $row['year'] . "\">";
              $current = $row['year'];
        }
        
        // print the actual subject options
        echo "<option value = ". $row['id'] .">" . $row['name'] . "</option>";
    }
    echo "</optgroup>";
} 
else {
    // Default option if there isn't any subject for selected degree
    echo "<option disabled selected style=\"font-style: italic;\"> -- nessuna materia in ".$degreeName." --</option>";
}

$conn->close();
*/
?>