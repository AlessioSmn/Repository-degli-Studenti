<?php
// include 'MySQLSelectionFilter.php';
class UserElement{
      private $userName;
      private $userMail;

      /**
       * @param string $UserName Il nome dell'utente
       * @param string $UserMail La mail dell'utente
       */
      public function __construct($UserName = null, $UserMail = null){
            $this->userName = $UserName;
            $this->userMail = $UserMail;
      }

      /**
       * @return string Stringa per la proiezione in MySQL delle specifiche del documento, preparato per bind_param
       */
      public function stringQueryConstraint(){
            if($this->userName == null && $this->userMail == null)
                  return "";
                  
            if($this->userName != null && $this->userMail != null)
                  return " (" . MySQLSelectionFilter::UsrNAME . " OR " . MySQLSelectionFilter::UsrMAIL . ") ";

            if($this->userName != null)
                  return " (" . MySQLSelectionFilter::UsrNAME . ") ";

            return " (" . MySQLSelectionFilter::UsrMAIL . ") ";
      }
      
      /**
       * @return string Stringa con i tipi dei paramteri, es.: "sii" per stringa-intero-intero
       */
      public function getParameterTypes(){
            $str = "";
            if($this->userName != null) $str = $str . "s";
            if($this->userMail != null) $str = $str . "s";
            return $str;
      }
      
      /**
       * @return string[] Stringa con i tipi paramteri
       */
      public function getParameters(){
            $paramArray = array();
            if($this->userName != null)
                  $paramArray[] = "%".$this->userName."%";
            if($this->userMail != null)
                  $paramArray[] = "%".$this->userMail."%";
            return $paramArray;
      }
      
      /**
       * @return int Numero di parametri da passare alla bind_param
       */
      public function numParameters(){
            $n = 0;
            if($this->userName != null) $n++;
            if($this->userMail != null) $n++;
            return $n;
      }
}
?>