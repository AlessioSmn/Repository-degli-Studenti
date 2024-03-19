<?php

$projectDir = "../../";

// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';
include_once $projectDir.'php/utils/prepareMySQLorderByClause.php';
include_once $projectDir.'php/classes/StatisticsQuery.php';

// Ricavo il target delle statistiche ed il gruppo
$Target = isset($_GET["Target"]) ? $_GET["Target"] : "Degree";
$Group = isset($_GET["Group"]) ? $_GET["Group"] : "All";

// Ottengo lo statement SQL
$sqlStatement = StatisticQuery::GetStatisticQuery($Target, $Group);

$parameterTypes = "";
$parameters = array();

// Eseguo lo statement per ricavare le finormazioni richieste
$result = executePreparedStatement(
      $sqlStatement, 
      $affectedRows, 
      $parameterTypes, 
      $parameters
);

$resultArray = array();

if($affectedRows > 0){
      while($row = $result->fetch_assoc()){
            $resultArray[] = $row;
      }
}

echo json_encode($resultArray);
               
function getInfo(&$sqlStatement, &$index){
      switch($index){
            case "USRACT":
                  $sqlStatement = StatisticQuery::UsersMostActive;
                  return;

            case "USRDOW":
                  $sqlStatement = StatisticQuery::UsersMostDownload;
                  return;

            case "SUBALL":
                  $sqlStatement = StatisticQuery::SubjectsAllMostDownload;
                  return;

            // TODO CAMBIA, sistema sta cosa
            case "SUBDEG":
                  $sqlStatement = StatisticQuery::SubjectsAllMostActive;
                  return;
                  
            case "DEG":
                  $sqlStatement = StatisticQuery::DegreesMostDownload;
                  return;
            
            default:
                  $sqlStatement = "";
      }
}
?>