<?php
function errorLog($previousDir, $pageName){
      $backtrace = debug_backtrace();
      $callingFile = basename(isset($backtrace[1]['file']) ? $backtrace[1]['file'] : '-');
      $a1 = "\n\tCaller: $callingFile";
      $a2 = "\n\tPagename: " . $pageName;
      $a3 = "\n\tPrevious directory: " . (isset($prevDir) ? $prevDir : "[not set]");
      $a4 = "\n\tRedirecting: location:$previousDir"."login.php";
      $errMSG = $a1.$a2.$a3.$a4;
      error_log($errMSG);
}
?>