<?php

// Se la sessione non è già attiva la faccio partire
if(session_status() != PHP_SESSION_ACTIVE)
      session_start();

$projectDir = "../../";

// File di configurazione per la connessione con il DB
include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';

// Quando viene effettuato il login si elimina la sessione corrente
session_unset();
session_destroy();

// Prendo le informazioni passate
$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];

// 1) Controllo che non sia già stato registrato un account con la stessa mail
if(alreadyRegistered($email)){
      echo json_encode([false, "Account già presente"]);
      exit();
}

// 2) Controllo che la password rispetti i requisiti necessari
if(!passwordPatternOk($password)){
      echo json_encode([false, "Password non rispetta i requisiti minimi di sicurezza"]);
      exit();
}

// 3) Registro il nuovo utente 
signUpNewUser($email, $password, $name, $surname);

// 4) Salvo alcune variabili utili in sessione
fillNewSession($email);

echo json_encode([true]);
/**
 * Prende in input una email e verifica se è già stato registrato un account con quella mail
 * @param string $email L'email da verificare
 * @return boolean True se è già registrato un account, false altrimenti
 */
function alreadyRegistered($email){
      $sqlStatement = " SELECT COUNT(*) as count 
                        FROM user 
                        WHERE email = ?";
                        
      $parameterTypes = "s"; // Stringa
      $parameters = array($email);

      $result = executePreparedStatement(
            $sqlStatement,
            $affectedRows,
            $parameterTypes,
            $parameters
      );

      // Se c'è un errore nel prepared statement
      if($result == false)
            return false;

      // Ricavo l'unico record presente
      $row = mysqli_fetch_assoc($result);

      // Verifico che ci siano zero utenti registrati con la stessa password
      if($row['count'] == 0)
            return false;

      return true;
}

/**
 * Controlla che la password ripetti i requisiti imposti, ossia:
 * a) Lunghezza: almeno 8 caratteri
 * b) Lettere maiuscole: almeno 1
 * c) Lettere minuscole: almeno 1
 * d) Numeri: almeno 1
 * e) Caratteri speciali: almeno 1
 * @param string $password La password da verificare
 * @return boolean True se la password rispetta il pattern, false altrimenti
 */
function passwordPatternOk($password){
      // a) Lunghezza: almeno 8 caratteri
      if(strlen($password) < 8)
            return false;

      // b) Lettere maiuscole: almeno 1
      if (!preg_match('/[A-Z]/', $password))
            return false;

      // c) Lettere minuscole: almeno 1
      if (!preg_match('/[a-z]/', $password))
            return false;
      
      // d) Numeri: almeno 1
      if (!preg_match('/\d/', $password))
            return false;

      // e) Caratteri speciali: almeno 1
      if (!preg_match('/[^a-zA-Z\d]/', $password))
            return false;

      return true;
}

/**
 * Registra un nuovo utente nel database
 * @param string $email L'email
 * @param string $password La password
 * @param string $name Il nome dell'utente
 * @param string $surname Il cognome dell'utente
 * @return boolean True se l'inserimento è avvenuto con successo, false altrimenti
 */
function signUpNewUser($email, $password, $name, $surname){
      $sqlStatement = " INSERT INTO user(email, password, name, surname) 
                        VALUES (?, ?, ?, ?)";
      
      $parameterTypes = "ssss"; // Quattro stringhe
      
      $password = password_hash($password, PASSWORD_BCRYPT);
      $parameters = array($email, $password, $name, $surname);

      $result = executePreparedStatement(
            $sqlStatement,
            $affectedRows,
            $parameterTypes,
            $parameters
      );
      
      // Se c'è un errore nel prepared statement
      // O se le righe inserite sono != 1
      if($result == false || $affectedRows != 1)
            return false;

      return true;
}

function fillNewSession($email){
      $sqlStatement = "SELECT id, name, surname FROM user WHERE email = ?";
      $parameterTypes = "s";
      $parameters = array($email);

      $result = executePreparedStatement(
            $sqlStatement,
            $affectedRows,
            $parameterTypes,
            $parameters
      );

      // check that there's ony row
      if($affectedRows != 1)
            return;

      $row = mysqli_fetch_assoc($result);

      if(session_status() != PHP_SESSION_ACTIVE)
            session_start();

      $_SESSION['logged'] = 1;
      $_SESSION['user_email'] = $email;
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_surname'] = $row['surname'];
}

?>