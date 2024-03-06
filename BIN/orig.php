<?php
// Utile per evitare SQL injections
// Funzione di utilità per processare query / DML statements 
// per evitare di sdoppiare il codice e aumentare possibilità di errore

/**
 * @param mysqli $connection Connessione con il server
 * @param string $sqlStatement Query / DML statement che si vuole eseguire
 * @param int $affectedRows Reference. Stores the number of affected rows
 * @param string $parameterTypes Optional. Default = null. Stringa dei tipi dei parametri della query
 * @param array $parameterValue Optional. Default = null. Array di parametri della query
 * @return mysqli_result|boolean|string[]
 */
function executePreparedStatement($connection, $sqlStatement, &$affectedRows, $parameterTypes = null, $parameterValue = null){
      $statement = $connection->prepare($sqlStatement);
      $affectedRows = -2;

      // statement non creato
      if(!$statement)
            return false;

      // TODO rendi la funzione a numero di valori variabile
      // Bind parameters se presenti
      // echo "{". $parameterTypes . "}"; 

      if(!is_null($parameterTypes) && !is_null($parameterValue) && !empty($parameterTypes) && !empty($parameterValue))
            // $statement->bind_param($parameterTypes, $parameterValue, $parameterValue, $parameterValue);
            //$statement->bind_param($parameterTypes, $parameterValue[0]);
            variableBindParam($statement, $parameterTypes, $parameterValue);

      //return $statement;

      if($statement->execute()){
            $result = $statement->get_result();
            $affectedRows = max(mysqli_affected_rows($connection), mysqli_num_rows($result));
            return $result;
      }
      // errore in esecuzione
      else 
            return false;
}

function variableBindParam(&$stm, $parameterTypes, array $parameters){
      // primo argomento della bind_param: unica stringa con i tipi in ordine
      $argsArray = array($parameterTypes); // serve sia un array

      // resto degli argomenti: i vari parametri
      foreach($parameters as &$p){
            $argsArray[] = &$p;
      }

      // $argsArray = array_merge(array($parameterTypes), array_values($parameters));
      call_user_func_array(array(&$stm, 'bind_param'), $argsArray);
}
?>