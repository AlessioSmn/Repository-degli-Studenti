<?php
const NO_CFU_MARGIN = -1; // nb: CFU > 0
// include 'MySQLSelectionFilter.php';
class SubjectElement{
      private $subjectName;
      private $minCFU;
      private $maxCFU;

      /**
       * @param string $SubjectName Il nome della materia
       * @param int $MinCFU Numero di CFU minimo, dev'essere maggiore di zero | [NO_CFU_MARGIN] per nessun limite inferiore
       * @param int $MaxCFU Numero di CFU massimo, dev'essere maggiore di zero | [NO_CFU_MARGIN] per nessun limite superiore
       */
      public function __construct($SubjectName = null, $MinCFU = NO_CFU_MARGIN, $MaxCFU = NO_CFU_MARGIN){
            $this->subjectName = $SubjectName;
            $this->minCFU = $MinCFU == NO_CFU_MARGIN ? NO_CFU_MARGIN : abs($MinCFU);
            $this->maxCFU = $MaxCFU == NO_CFU_MARGIN ? NO_CFU_MARGIN : abs($MaxCFU);
      }

      /**
       * @return string Stringa per la proiezione in MySQL delle specifiche della materia, preparato per bind_param
       */
      public function stringQueryConstraint(){
            if($this->subjectName == null && $this->minCFU == NO_CFU_MARGIN && $this->maxCFU == NO_CFU_MARGIN)
                  return "";
            $str = "";
            if($this->subjectName != null)
                  $str = MySQLSelectionFilter::SubNAME;
            
            if($this->minCFU != NO_CFU_MARGIN){
                  if($str == "") $str = MySQLSelectionFilter::SubMinCFU;
                  else $str = $str . " AND " . MySQLSelectionFilter::SubMinCFU;
            }
            if($this->maxCFU != NO_CFU_MARGIN){
                  if($str == "") $str = MySQLSelectionFilter::SubMaxCFU;
                  else $str = $str . " AND " . MySQLSelectionFilter::SubMaxCFU;
            }
            return " (" . $str .") ";
      }
      
      /**
       * @return string Stringa con i tipi dei paramteri, es.: "sii" per stringa-intero-intero
       */
      public function getParameterTypes(){
            $types = "";
            if($this->subjectName != null) $types = $types . "s";
            if($this->minCFU != NO_CFU_MARGIN) $types = $types . "i";
            if($this->maxCFU != NO_CFU_MARGIN) $types = $types . "i";
            return $types;
      }
      
      /**
       * @return string[] Stringa con i tipi paramteri
       */
      public function getParameters(){
            $paramArray = array();
            if($this->subjectName != null) $paramArray[] = "%".$this->subjectName."%";
            if($this->minCFU != NO_CFU_MARGIN) $paramArray[] = $this->minCFU;
            if($this->maxCFU != NO_CFU_MARGIN) $paramArray[] = $this->maxCFU;
            return $paramArray;
      }
      
      /**
       * @return int Numero di parametri da passare alla bind_param
       */
      public function numParameters(){
            $n = 0;
            if($this->subjectName != null) $n++;
            if($this->minCFU != NO_CFU_MARGIN) $n++;
            if($this->maxCFU != NO_CFU_MARGIN) $n++;
            return $n;
      }
}
?>