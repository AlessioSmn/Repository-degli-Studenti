<?php
const NO_CFU_MARGIN = -1; // nb: CFU > 0
class SubjectElement{
      private $subjectName;
      private $degreeName;
      private $minCFU;
      private $maxCFU;

      /**
       * @param string $SubjectName Il nome della materia
       * @param string $DegreeName Il nome del corso di studi
       * @param int $MinCFU Numero di CFU minimo, dev'essere maggiore di zero | [NO_CFU_MARGIN] per nessun limite inferiore
       * @param int $MaxCFU Numero di CFU massimo, dev'essere maggiore di zero | [NO_CFU_MARGIN] per nessun limite superiore
       */
      public function __construct($SubjectName = null, $DegreeName = null, $MinCFU = NO_CFU_MARGIN, $MaxCFU = NO_CFU_MARGIN){
            $this->subjectName = $SubjectName;
            $this->degreeName = $DegreeName;
            $this->minCFU = $MinCFU == NO_CFU_MARGIN ? NO_CFU_MARGIN : abs($MinCFU);
            $this->maxCFU = $MaxCFU == NO_CFU_MARGIN ? NO_CFU_MARGIN : abs($MaxCFU);
      }

      /**
       * Ritorna una stringa per la selezione dei documenti che fanno match con il nome della materia o il nome del corso di studi .
       * @return string Stringa per la  in MySQL delle specifiche della materia, preparato per bind_param
       */
      public function getQueryMatches(){
            if($this->subjectName == null && $this->degreeName == null)
                  return "";

            $str = "";
            if($this->subjectName != null)
                  $str = MySQLSelectionFilter::SubNAME;
            
            if($this->degreeName != null){
                  if ($str == "") $str = MySQLSelectionFilter::DegNAME;
                  else $str = $str . " OR " . MySQLSelectionFilter::DegNAME;
            }
            return " (" . $str .") ";
      }

      /**
       * Ritorna una stringa per la selezione dei documenti che rispettano tutti i vincoli sul numero di cfu della rispettiva materia.
       * @return string Stringa per la selezione in MySQL delle specifiche della materia, preparato per bind_param
       */
      public function getQueryFilters(){
            if($this->minCFU == NO_CFU_MARGIN && $this->maxCFU == NO_CFU_MARGIN)
                  return "";
            
            $str = "";
            if($this->minCFU != NO_CFU_MARGIN){
                  if($str == "") $str = MySQLSelectionFilter::SubMinCFU;
            }
            if($this->maxCFU != NO_CFU_MARGIN){
                  if($str == "") $str = MySQLSelectionFilter::SubMaxCFU;
                  else $str = $str . " AND " . MySQLSelectionFilter::SubMaxCFU;
            }
            return " (" . $str .") ";
      }
      
      /**
       * Ritorna una stringa con i tipi dei paramteri, relativi alla parte di match
       * @return string Stringa con i tipi dei paramteri, es.: "sii" per stringa-intero-intero
       */
      public function getMatchParameterTypes(){
            $types = "";
            if($this->subjectName != null) $types = $types . "s";
            if($this->degreeName != null) $types = $types . "s";
            return $types;
      }
      
      /**
       * Ritorna una stringa con i tipi dei paramteri, relativi alla parte di filtro
       * @return string Stringa con i tipi dei paramteri, es.: "sii" per stringa-intero-intero
       */
      public function getFilterParameterTypes(){
            $types = "";
            if($this->minCFU != NO_CFU_MARGIN) $types = $types . "i";
            if($this->maxCFU != NO_CFU_MARGIN) $types = $types . "i";
            return $types;
      }

      /**
       * Ritorna una array di stringhe costituita dai parametri della query, relativi alla parte di match
       * @return string[] Stringa con i tipi paramteri
       */
      public function getMatchParameters(){
            $paramArray = array();
            if($this->subjectName != null) $paramArray[] = "%".$this->subjectName."%";
            if($this->degreeName != null) $paramArray[] = "%".$this->subjectName."%";
            return $paramArray;
      }
      
      /**
       * Ritorna una array di stringhe costituita dai parametri della query, relativi alla parte di filtro
       * @return string[] Stringa con i tipi paramteri
       */
      public function getFilterParameters(){
            $paramArray = array();
            if($this->minCFU != NO_CFU_MARGIN) $paramArray[] = $this->minCFU;
            if($this->maxCFU != NO_CFU_MARGIN) $paramArray[] = $this->maxCFU;
            return $paramArray;
      }
      
      /**
       * @return int Numero di parametri da passare alla bind_param
       */
      public function getMatchNumParameters(){
            $n = 0;
            if($this->subjectName != null) $n++;
            if($this->degreeName != null) $n++;
            return $n;
      }
      
      /**
       * @return int Numero di parametri da passare alla bind_param
       */
      public function getFilterNumParameters(){
            $n = 0;
            if($this->minCFU != NO_CFU_MARGIN) $n++;
            if($this->maxCFU != NO_CFU_MARGIN) $n++;
            return $n;
      }
}
?>