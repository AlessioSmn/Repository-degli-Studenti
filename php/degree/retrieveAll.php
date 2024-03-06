<?php 

$projectDir = "../../";
// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';

// $connection = new DatabaseConnect();

$query = "  SELECT id, name 
            FROM degreecourse;";

$result = executePreparedStatement($query, $affectedRows);

$resultArray = array();

if ($affectedRows > 0) {
      while($row = $result->fetch_assoc()) {
            $resultArray[] = $row;
      }
}
echo json_encode($resultArray);

?>