<?php

$projectDir = "../../../";

// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';
include_once $projectDir.'php/utils/prepareMySQLorderByClause.php';

// Ricavo l'ID della materia selezionata
$type = "i";
$subjectID = $_GET['selectedSubjectId'];

// Query per ricavare tutte i idocumenti di una data materia
$query = "  SELECT 
                  document.id as id, 
                  document.title as title, 
                  document.subtitle as subtitle, 
                  document.extension as extension,
                  document.downloadCounter as downloads,
                  document.lastModified as lastModifiedDate,
                  document.uploadDate as uploadDate,
                  user.email as owner 
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
            WHERE document.subject = ? ";

// Eseguo al query
$result = executePreparedStatement(
      $query, 
      $affectedRows, 
      $type, 
      array($subjectID));

$resultArray = array();

// Restituisco il risultato come un array di record
if ($affectedRows > 0) {
      while($row = $result->fetch_assoc()) {
            $resultArray[] = $row;
      }
}

echo json_encode($resultArray);

/*
function prepareMySQLorderByClause($orderField, $order){
      $orderByKeyword = " ORDER BY ";

      // In questa maniera evito keyword errate per l'ordinamento
      $order = ($order == "ASC" ? "ASC" : "DESC");

      return $orderByKeyword . orderField($orderField) . " ". $order . "; ";
}

function orderField($orderField){
      switch($orderField){
            case 'usrName': 
                  return 'user.name';
            case 'usrMail': 
                  return 'user.email';
            case 'sub': // non si fa il join su subject in questo caso, e la materia è sempre la stessa
            case 'doc': 
                  return 'document.title';
            case 'up':
                  return 'document.uploadDate';
            case 'lastMod':
                  return 'document.lastModified';
            case 'download':
            default:
                  return 'document.downloadCounter';
      }
}
*/
?>