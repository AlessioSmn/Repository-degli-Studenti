<?php
$prevDir = isset($prevDir) ? "" : "../";
$pageName = isset($pageName) ? $pageName : null;
include 'loginControl.php';

include_once '../config/config.php';
include_once 'classes/DBconnect.php';
include_once 'utils/executePreparedStatement.php';

// Take the selected degree's ID
$type = "i";
$subjectID = $_GET['selectedSubjectId'];
$order = $_GET['orderField'];
$asc = $_GET['asc'] == "ASC" ? "ASC" : "DESC";

// Query to get all of the selected degree's subjects
$query = "  SELECT 
                  document.id as id, 
                  document.title as title, 
                  document.subtitle as subtitle, 
                  document.extension as extension,
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
            default:
                  return 'document.title';
      }
}

?>