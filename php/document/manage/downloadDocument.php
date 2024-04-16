
<?php 

$projectDir = "../../../";
// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';

// Indiviuo il documento da scaricare
$filePath = $projectDir . 'docs/' . $_GET['id'] . $_GET['ext'];

// Se non esiste esco
if(!file_exists($filePath)){
      echo json_encode('File non trovato: ' . $filePath);
      exit();
}

// Imposto i vari campi necessari per un corretto download / visualizzazione

// File name
$fileName = $_GET['title'] . $_GET['ext'];

// Content-Type
header('Content-Type: ' . getContentType($_GET['ext']));

// Content-Disposition

// Download
if(isset($_GET['mode']) && $_GET['mode'] == 1) $contentDisp = 'attachment';
// Visualizzazione in una nuova pagina
else $contentDisp = 'inline';

header('Content-Disposition: '.$contentDisp.'; filename="'.$fileName.'"');

// Prendo il file
readfile($filePath);


// Incremento il counter dei download sul documento
if($contentDisp == 'attachment'){
      
      $sqlStatement = " UPDATE document
                        SET downloadCounter = downloadCounter + 1
                        WHERE document.id = ?;";
      $parameterType = "i";
      
      executePreparedStatement(
            $sqlStatement, 
            $affectedRows, 
            $parameterType, 
            array($_GET['id']));
}


/**
 * @param string $extension L'estensione del file
 * @return string Restituisce il corretto Content-type per la data estensione
 */
function getContentType($extension){
      switch($extension){
            case '.pdf':
                  return 'application/pdf';
            case '.rtf':
                  return 'application/rtf';
            case '.js':
                  return 'application/javascript';
            case '.doc':
                  return 'application/msword';
            case '.docx':
                  return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            case '.ppt':
                  return 'application/vnd.ms-powerpoint';
            case '.pptx':
                  return 'application/vnd.openxmlformats-officedocument.presentationml.presentation';

            case '.txt':
                  return 'text/plain';
            case '.css':
                  return 'text/css';
            case '.html':
                  return 'text/html';
            case '.rtx':
                  return 'text/richtext';

            default:
                  return '';
      }
}
?>