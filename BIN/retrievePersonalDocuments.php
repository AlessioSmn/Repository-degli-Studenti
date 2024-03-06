<?php
$prevDir = isset($prevDir) ? "" : "../";
$pageName = isset($pageName) ? $pageName : null;
include 'loginControl.php';

include_once '../config/config.php';
include_once 'classes/DBconnect.php';
include_once 'utils/executePreparedStatement.php';

$query = "  SELECT 
            document.id as id,
            document.title as title,
            document.subtitle as subtitle,
            document.extension as extension,
            document.lastModified as lastModifiedDate,
            document.uploadDate as uploadDate,
            document.downloadCounter as downloads,
            user.name as owner,
            subject.name as subjectName,
            degreecourse.name as degreeName
      FROM document 
            INNER JOIN user on document.owner = user.id
            INNER JOIN subject ON document.subject = subject.id 
            INNER JOIN degreecourse ON subject.degreecourse = degreecourse.id 
      WHERE user.email = ?;";

$resArray = array();
$parameterTypes = "s";
$result = executePreparedStatement($query, $n, $parameterTypes, array($_SESSION['user_email']));
if($result){
      while($row = mysqli_fetch_assoc($result)){
            $resArray[] = $row;
      }  
}         

echo json_encode($resArray);

?>