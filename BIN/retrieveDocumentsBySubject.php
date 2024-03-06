<?php
$prevDir = isset($prevDir) ? "" : "../";
$pageName = isset($pageName) ? $pageName : null;
include 'loginControl.php';

include_once '../config/config.php';
include_once 'classes/DBconnect.php';
include_once 'utils/executePreparedStatement.php';

// Ricavo l'ID della materia selezionata
$type = "i";
$subjectID = $_GET['selectedSubjectId'];
$order = $_GET['orderField'];
$asc = $_GET['asc'] == "ASC" ? "ASC" : "DESC";

// Query per ricavare tutte i idocumenti di una data materia
$query = "  SELECT 
                  document.id as id, 
                  document.title as title, 
                  document.subtitle as subtitle, 
                  document.extension as extension,
                  document.downloadCounter as downloads,
                  document.lastModified as lastModifiedDate,
                  document.uploadDate as uploadDate,
                  user.name as owner 
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
            WHERE document.subject = ? ";
$query = $query . prepareMySQLorderByClause($order, $asc);

$result = executePreparedStatement($query, $a, $type, array($subjectID));

$resultArray = array();

if ($a > 0) {
      // display all subjects as options to choose from
      while($row = $result->fetch_assoc()) {
            $resultArray[] = $row;
      }
}
echo json_encode($resultArray);

function prepareMySQLorderByClause($orderField, $asc){
      $str = " ORDER BY ";
      return $str . orderField($orderField) . " ". $asc . "; ";
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

?>