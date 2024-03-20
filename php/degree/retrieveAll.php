<?php 

$projectDir = "../../";
// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';


// Ottengo tutti i corsi di laurea, prima triennali e poi magitsrali, ordinati per gruppi
$query = "  SELECT id, name, area, level   
            FROM degreecourse 
            ORDER BY level DESC, area ASC; ";

$result = executePreparedStatement($query, $affectedRows);

$resultArray = array();

if ($affectedRows > 0) {
      while($row = $result->fetch_assoc()) {
            $resultArray[] = $row;
      }
}
echo json_encode($resultArray);

?>