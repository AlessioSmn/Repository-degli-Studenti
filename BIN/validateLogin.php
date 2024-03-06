<?php

// Se la sessione non è già attiva la faccio partire
if(session_status() != PHP_SESSION_ACTIVE)
      session_start();

// File di configurazione per la connessione con il DB
include_once __DIR__ . '/../config/config.php';
include_once 'classes/DBconnect.php';
include_once 'utils/executePreparedStatement.php';
$previousPage = $_SESSION['previousPage'];

// Save the previous page before destroying the session
// $previousPage = $_SESSION['previousPage'];
// echo $previousPage;

// Quando viene effettuato il login si elimina la sessione corrente
if(isset($_SESSION['logged'])) 
      session_destroy();
$_SESSION['previousPage'] = $previousPage;

// Validate login
$email = $_POST['email'];

if(loginValidation($email)){
      // Fill login info in session
      fillNewSession($email);
      
      // Echo previous page for redirection
      echo json_encode($previousPage);
}

function loginValidation($email, $printInfo = false){
      $sqlStatement = "SELECT password FROM user WHERE email = ?";
      $parameterTypes = "s"; // Stringa
      // TODO Sanitize input
      $parameters = array($email);

      $result = executePreparedStatement(
            $sqlStatement,
            $affectedRows,
            $parameterTypes,
            $parameters
      );

      // $stm = mysqli_prepare($connection, $query);
      if($result == false){
            if($printInfo) echo "[INFO] error in the prepared statement";
            return false;
      }
      
      // check that the result is only and only one row
      if($affectedRows != 1) {
            if($printInfo) echo "[INFO] affected_rows: " . $affectedRows . "\n";
            return false;
      }

      // Ricavo l'unico record presente
      $row = mysqli_fetch_assoc($result);

      // verifico il match con la password inserita
      $password = $_POST['password'];
      if(password_verify($password, $row['password']))
            return true;

      return false;
}

function fillNewSession($email){
      $sqlStatement = "SELECT name, surname FROM user WHERE email = ?";
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
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_surname'] = $row['surname'];
      $_SESSION['previousPage'] = "login.php";
}

?>