<?php
$prevDir = isset($prevDir) ? "" : "../";
$pageName = isset($pageName) ? $pageName : null;
include 'loginControl.php';

include_once '../config/config.php';
include_once 'utils/executePreparedStatement.php';

$sqlStatement = " UPDATE document
                  SET downloadCounter = downloadCounter + 1
                  WHERE document.id = ?;";
$parameterType = "i";

executePreparedStatement(
      $sqlStatement, 
      $affectedRows, 
      $parameterType, 
      array($documentId));
?>