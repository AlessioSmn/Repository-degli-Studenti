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

// Limite inferiore di CFU
$minCFU = isset($_GET['minCFU']) ? $_GET['minCFU'] : NO_CFU_MARGIN;

// Limite superiore di CFU
$maxCFU = isset($_GET['maxCFU']) ? $_GET['maxCFU'] : NO_CFU_MARGIN;

// Nome dle documento
$docTitle = isset($_GET['docTitle']) ? $text : null;

// Sottotitolo del documento
$docSubtitle = isset($_GET['docSubtitle']) ? $text : null;

// Username
$userName = isset($_GET['userName']) ? $text : null;

// Mail dell'autore
$userMail = isset($_GET['userMail']) ? $text : null;

// Campo di ordinamento
$order = $_GET['orderField'];
// Ordine crescente o decrescente
$asc = $_GET['asc'] == "ASC" ? "ASC" : "DESC";

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
$subject = new SubjectElement($subName, $minCFU, $maxCFU);
$document = new DocumentElement($docTitle, $docSubtitle);
$user = new UserElement($userName, $userMail);

// Aggiungo incoli di selezione
$sqlStatement = $sqlStatement . prepareMySQLwhereClause($subject, $document, $user);

// Impongo un ordinamento al result set
$sqlStatement = $sqlStatement . prepareMySQLorderByClause($order, $asc);

// Parametri e tipi dei parametri per la executePreparedStatement
$parameterTypes = $subject->getParameterTypes().$document->getParameterTypes().$user->getParameterTypes();
$parameters = array_merge($subject->getParameters(), $document->getParameters(), $user->getParameters());

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
/*

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

*/
?>