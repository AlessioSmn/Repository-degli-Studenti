<?php

$projectDir = "../../../";

// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';

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

$parameterTypes = "s";
// Eseguo la query (l'unic parametro è la mail dell'utente)
$result = executePreparedStatement(
      $query, 
      $affectedRows, 
      $parameterTypes,
      array($_SESSION['user_email'])
);

$resultArray = array();

if ($affectedRows > 0) {
      while($row = $result->fetch_assoc()) {
            $resultArray[] = $row;
      }
}
echo json_encode($resultArray);

?>