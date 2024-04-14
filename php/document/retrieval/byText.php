<?php

$projectDir = "../../../";

// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';
include_once $projectDir.'php/utils/prepareMySQLorderByClause.php';

include_once $projectDir.'php/classes/MySQLSelectionFilter.php';
include_once $projectDir.'php/classes/SQLselection/SubjectElement.php';
include_once $projectDir.'php/classes/SQLselection/DocumentElement.php';
include_once $projectDir.'php/classes/SQLselection/userElement.php';

// Prendo tutte le informazioni presenti

// Generico testo inserito, potrà fare match con diversi campi
$text = $_GET['text'];

// Nome della materia
$subName = isset($_GET['subName']) ? $text : null;

// Nome del corso di studi
$degName = isset($_GET['degName']) ? $text : null;

// Limite inferiore di CFU
$minCFU = isset($_GET['minCFU']) ? $_GET['minCFU'] : NO_CFU_MARGIN;

// Limite superiore di CFU
$maxCFU = isset($_GET['maxCFU']) ? $_GET['maxCFU'] : NO_CFU_MARGIN;

// Nome dle documento
$docTitle = isset($_GET['docTitle']) ? $text : null;

// Sottotitolo del documento
$docSubtitle = isset($_GET['docSubtitle']) ? $text : null;

// Sottotitolo del documento
$docExtension = isset($_GET['docExtension']) ? $text : null;

// Username
$userName = isset($_GET['userName']) ? $text : null;

// Mail dell'autore
$userMail = isset($_GET['userMail']) ? $text : null;

// Query MySQL
$sqlStatement = "  SELECT 
                  document.id as id, 
                  document.title as title, 
                  document.subtitle as subtitle, 
                  document.extension as extension,
                  document.downloadCounter as downloads,
                  document.lastModified as lastModifiedDate,
                  document.uploadDate as uploadDate,
                  user.email as owner, 
                  subject.name as subjectName,
                  degreecourse.name as degreeName
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
                  INNER JOIN subject ON document.subject = subject.id 
                  INNER JOIN degreecourse ON subject.degreecourse = degreecourse.id 
            WHERE "; // lascio vuoti i vincoli di selezione, verranno creati da prepareMySQLwhereClause()

// Oggetti materia, doucmento e utente, per la creazione dei vincoli
$subject = new SubjectElement($subName, $degName, $minCFU, $maxCFU);
$document = new DocumentElement($docTitle, $docSubtitle, $docExtension);
$user = new UserElement($userName, $userMail);

// Aggiungo i vincoli di selezione
$sqlStatement = $sqlStatement . prepareMySQLwhereClause($subject, $document, $user);

// Array dei paramteri per la bind_param in executePreparedStatement
// prima unisco tutti i vincoli di match in OR, poi di essi faccio un unico gruppo e li metto in and con i vincoli di filtro
$parametersMatch = array_merge($subject->getMatchParameters(), $document->getMatchParameters(), $user->getMatchParameters());
$parametersFiler = array_merge($subject->getFilterParameters());
$parameters = array_merge($parametersMatch, $parametersFiler);

// Tipi dei parametri per la bind_param in executePreparedStatement
$parameterTypesMatch = $subject->getMatchParameterTypes() . $document->getMatchParameterTypes() . $user->getMatchParameterTypes();
$parameterTypesFilter = $subject->getFilterParameterTypes();
$parameterTypes = $parameterTypesMatch . $parameterTypesFilter;

// Eseguo la ricerca
$result = executePreparedStatement(
      $sqlStatement, 
      $affectedRows, 
      $parameterTypes,
      $parameters
);

$resultArray = array();

if ($affectedRows > 0) {
      while($row = $result->fetch_assoc()) {
            $resultArray[] = $row;
      }
}
echo json_encode($resultArray);


function prepareMySQLwhereClause(SubjectElement $sub, DocumentElement $doc, UserElement $usr){
      // 1) Concateno tutte le selezioni di match
      $strMatch = "";
      if($sub->getMatchNumParameters() > 0)
            $strMatch = $sub->getQueryMatches();

      if($doc->getMatchNumParameters() > 0){
            if($strMatch == "") $strMatch = $doc->getQueryMatches();
            else $strMatch = $strMatch. " OR " . $doc->getQueryMatches();
      }
      if($usr->getMatchNumParameters() > 0){
            if($strMatch == "") $strMatch = $usr->getQueryMatches();
            else $strMatch = $strMatch. " OR " . $usr->getQueryMatches();     
      }

      // 2) Concateno tutte le selezioni di filter
      $strFilter = "";
      if($sub->getFilterNumParameters() > 0)
            $strFilter = $sub->getQueryFilters();

      // Se il match è vuoto, ritorno solo il filter
      if($strMatch == "")
            return ($strFilter == "") ? " NULL IS NOT NULL " : $strFilter;

      // Se il filter è vuoto (ma il match no), ritorno il match
      if($strFilter == "")
            return $strMatch;

      // Entrmabi non vuoti, quindi metto tutto strMatch in AND con i filtri
      return " ( " . $strMatch . " ) AND " . $strFilter;
}
?>