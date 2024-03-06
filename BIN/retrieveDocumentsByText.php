<?php
$prevDir = isset($prevDir) ? "" : "../";
$pageName = isset($pageName) ? $pageName : null;
include 'loginControl.php';

include_once '../config/config.php';
include_once 'classes/DBconnect.php';
include_once 'utils/executePreparedStatement.php';

include 'classes/MySQLSelectionFilter.php';
include 'classes/SQLselection/SubjectElement.php';
include 'classes/SQLselection/DocumentElement.php';
include 'classes/SQLselection/userElement.php';

// Take the text
$text = $_GET['text'];
$subName = isset($_GET['subName']) ? $text : null;
$minCFU = isset($_GET['minCFU']) ? $_GET['minCFU'] : NO_CFU_MARGIN;
$maxCFU = isset($_GET['maxCFU']) ? $_GET['maxCFU'] : NO_CFU_MARGIN;
$docTitle = isset($_GET['docTitle']) ? $text : null;
$docSubtitle = isset($_GET['docSubtitle']) ? $text : null;
$userName = isset($_GET['userName']) ? $text : null;
$userMail = isset($_GET['userMail']) ? $text : null;

$order = $_GET['orderField'];
$asc = $_GET['asc'] == "ASC" ? "ASC" : "DESC";

// Query to get all documents of searched subjects
$sqlStatement = "  SELECT 
                  document.id as id, 
                  document.title as title, 
                  document.subtitle as subtitle, 
                  document.extension as extension,
                  document.downloadCounter as downloads,
                  document.lastModified as lastModifiedDate,
                  document.uploadDate as uploadDate,
                  user.name as owner, 
                  subject.name as subjectName,
                  degreecourse.name as degreeName
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
                  INNER JOIN subject ON document.subject = subject.id 
                  INNER JOIN degreecourse ON subject.degreecourse = degreecourse.id 
            WHERE ";

$subject = new SubjectElement($subName, $minCFU, $maxCFU);
$document = new DocumentElement($docTitle, $docSubtitle);
$user = new UserElement($userName, $userMail);

$sqlStatement = $sqlStatement . prepareMySQLwhereClause($subject, $document, $user);
$sqlStatement = $sqlStatement . prepareMySQLorderByClause($order, $asc);

$parameterTypes = $subject->getParameterTypes().$document->getParameterTypes().$user->getParameterTypes();

$parameters = array_merge($subject->getParameters(), $document->getParameters(), $user->getParameters());

// echo json_encode($sqlStatement);
$result = executePreparedStatement(
      $sqlStatement, 
      $affectedRows, 
      $parameterTypes,
      $parameters
);

$resultArray = array();

if ($affectedRows > 0) {
      // display all subjects as options to choose from
      while($row = $result->fetch_assoc()) {
            // echo "<p> ". $row['title'] ." di " . $row['owner'] . " - " . $row['subjectName'] ." nel corso di " . $row['degreeName'] . "</p>";
            $resultArray[] = $row;
      }
}
echo json_encode($resultArray);


function prepareMySQLwhereClause(SubjectElement $sub, DocumentElement $doc, UserElement $usr){
      $str = "";
      // $str = $sub->stringQueryConstraint();
      if($sub->numParameters() > 0)
            $str = $sub->stringQueryConstraint();

      if($doc->numParameters() > 0){
            if($str == "") $str = $doc->stringQueryConstraint();
            else $str = $str. " OR " . $doc->stringQueryConstraint();
      }
      if($usr->numParameters() > 0){
            if($str == "") $str = $usr->stringQueryConstraint();
            else $str = $str. " OR " . $usr->stringQueryConstraint();     
      }
      return (($str == "") ? " NULL IS NOT NULL " : $str);
}

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
            case 'sub': 
                  return 'subject.name';
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