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
$GroupId = isset($_GET["GroupId"]) ? $_GET["GroupId"] : null;

// Ottengo lo statement SQL
$sqlStatement = StatisticQuery::GetStatisticQuery($Target, $Group);

// Imposto i parametri se presenti
$parameters = array();
$parameterTypes = "";
if(isset($_GET["GroupId"])){
      $parameterTypes = "i";
      $parameters[] = $GroupId;
}

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

?>