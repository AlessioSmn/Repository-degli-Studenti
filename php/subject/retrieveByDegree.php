<?php

$projectDir = "../../";
// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';

// $connection = new DatabaseConnect();

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

?>