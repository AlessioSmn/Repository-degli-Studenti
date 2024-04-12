<?php

// Se la sessione non è già attiva la faccio partire
if(session_status() != PHP_SESSION_ACTIVE)
      session_start();

$projectDir = "../../../";

// File di configurazione per la connessione con il DB
include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';

// Prendo tutte le informaizoni necessarie
$title = $_POST['title'];
$subjectId = $_POST['subjectId'];
$ownerId = $_SESSION['user_id'];
$extension = pathinfo($_FILES["fileContent"]["name"], PATHINFO_EXTENSION);
if($extension != null) $extension = "." . $extension;

// 1) Salvo il documento nel database (un nuovo record)
$newDocId = uploadNewDocumentToDB($title, $extension, $subjectId, $ownerId);
if($newDocId === false){
      echo json_encode([false, "Errore nel salvataggio del nuovo documento nel database | " . $newDocId]);
      exit();
}

// 2) Salvo il documento nella cartella docs/
$docsDirectory = $projectDir . "docs/";
if(!saveDocumentInFiles($docsDirectory, $newDocId, $extension)){
      echo json_encode([false, "Errore nel salvataggio del nuovo documento nella cartella /docs"]);
      exit();
}

echo json_encode([true, "Documento " . $newDocId . $extension . " caricato correttamente"]);
exit();

/**
 * Salva un nuovo documento nel database, ne restituisce l'id se l'inserimento è avvenuto correttamente
 * @param string $title Il titolo del documento
 * @param string $extension L'estensione del documento
 * @param integer $subjectId L'identificatore numerico della materia del documento
 * @param integer $ownerId L'identificatore numerico dell'utente che sta caricando il Documento
 * @return integer|boolean
 */
function uploadNewDocumentToDB($title, $extension, $subjectId, $ownerId){

      // Controllo che i campi siano del tipo corretto e non nulli
      if(is_null($title) || $title == "") return false;
      if(is_null($subjectId) || is_nan($subjectId)) return false;
      if(is_null($ownerId) || is_nan($ownerId)) return false;

      $sqlStatement = " INSERT INTO document (title, subject, owner, extension) 
                        VALUES (?, ?, ?, ?);";

      $parameterTypes = "siis"; // String, int, int , string
      $parameters = array($title, $subjectId, $ownerId, $extension);
      
      executePreparedStatement(
            $sqlStatement,
            $affectedRows,
            $parameterTypes,
            $parameters,
            $insertedRecordId
      );
      
      // Se c'è stato un errore
      if($affectedRows != 1)
            return false;

      // Ricava l'id del documento appena inserito
      return $insertedRecordId;
}

/**
 * Salva un file nella cartella dei documenti /docs
 * @param string $targetDirectory La direcotry in cui salvare il file
 * @param integer $docId L'identifiativo del documento (Si salvano con l'id per evitare conflitti sul nome)
 * @param string $docExtension Estensione del documento
 * @return boolean true se il salvataggio è avvenuto con successo, false altrimenti
 */
function saveDocumentInFiles($targetDirectory, $docId, $docExtension){
      // Path finale: docs/ID.ext
      $finalPath = $targetDirectory . $docId . $docExtension;
      
      // Salvo il file
      return move_uploaded_file($_FILES["fileContent"]["tmp_name"], $finalPath);
}

?>
