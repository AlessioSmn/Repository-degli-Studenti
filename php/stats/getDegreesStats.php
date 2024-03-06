<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$prevDir = isset($prevDir) ? "" : "../";
$pageName = isset($pageName) ? $pageName : null;
include '../logControl/loginControl.php';
include_once '../../config/config.php';
include_once "../utils/executePreparedStatement.php";
include_once "../classes/StatisticsQuery.php";

// get selected mode
$mode = isset($_GET["mode"]) ? strtoupper($_GET["mode"]) : "DEG";
$par = isset($_GET["par"]) ? $_GET["par"] : null;

// include_once "stats.php";
getInfo($sqlStatement, $parameterTypes, $parameters, $mode, $par);

$result = executePreparedStatement($sqlStatement, $affectedRows, $parameterTypes, $parameters);

$resArray = array();
// echo json_encode($affectedRows);
if($affectedRows > 0){
      while($row = $result->fetch_assoc()){
            $resArray[] = $row;
      }
      echo json_encode($resArray);
}
               
function getInfo(&$sqlStatement, &$parameterTypes, &$parameters, $index, $par = null){
      switch($index){
            case "USRACT":
                  $sqlStatement = StatisticQuery::UsersMostActive;
                  $parameterTypes = "";
                  $parameters = array();
                  return;
            case "USRDOW":
                  $sqlStatement = StatisticQuery::UsersMostDownload;
                  $parameterTypes = "";
                  $parameters = array();
                  return;
            case "SUBALL":
                  $sqlStatement = StatisticQuery::SubjectsAllMostDownload;
                  $parameterTypes = "";
                  $parameters = array();
                  return;
            // TODO CAMBIA, sistema sta cosa
            case "SUBDEG":
                  $sqlStatement = StatisticQuery::SubjectsAllMostActive;
                  $parameterTypes = "";
                  $parameters = array();
                  return;
            default:
            case "DEG":
                  $sqlStatement = StatisticQuery::DegreesMostDownload;
                  $parameterTypes = "";
                  $parameters = array();
                  return;
      }
}
?>