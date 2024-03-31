<?php
class DocumentElement{
      private $documentTitle;
      private $documentSubtitle;
      private $documentExtension;

      /**
       * @param string $DocumentTitle Il titolo del documento
       * @param string $DocumentSubtitle Il sottotitlo del documento
       * @param string $DocumentExtension L'estensione del documento
       */
      public function __construct($DocumentTitle = null, $DocumentSubtitle = null, $DocumentExtension = null){
            $this->documentTitle = $DocumentTitle;
            $this->documentSubtitle = $DocumentSubtitle;
            $this->documentExtension = $DocumentExtension;
      }

      /**
       * Ritorna una stringa per la selezione dei documenti che fanno match con il titolo o il sottotitolo della documento.
       * @return string Stringa per la selezione in MySQL delle specifiche del documento, preparato per bind_param
       */
      public function getQueryMatches(){
            if($this->documentTitle == null && $this->documentSubtitle == null)
                  return "";

            $str = "";
            if($this->documentTitle != null){
                  $str = MySQLSelectionFilter::DocTITLE;
            }
            if($this->documentSubtitle != null){
                  if ($str == "") $str = MySQLSelectionFilter::DocSUBTITLE;
                  else $str  = $str . " OR " . MySQLSelectionFilter::DocSUBTITLE;
            }
            return " (" . $str . ") ";
      }

      /**
       * Ritorna una stringa per la selezione dei documenti con una data estensione.
       * @return string Stringa per la selezione in MySQL delle specifiche del documento, preparato per bind_param
       */
      public function getQueryFilters(){
            $str = "";
            if($this->documentExtension != null)
                  $str = MySQLSelectionFilter::DocEXTENSION;

            return " (" . $str . ") ";
      }
      
      /**
       * Ritorna una stringa con i tipi dei paramteri, relativi alla parte di match
       * @return string Stringa con i tipi dei paramteri, es.: "sii" per stringa-intero-intero
       */
      public function getMatchParameterTypes(){
            $str = "";
            if($this->documentTitle != null) $str = $str . "s";
            if($this->documentSubtitle != null) $str = $str . "s";
            return $str;
      }
      
      /**
       * Ritorna una stringa con i tipi dei paramteri, relativi alla parte di filter
       * @return string Stringa con i tipi dei paramteri, es.: "sii" per stringa-intero-intero
       */
      public function getFilterParameterTypes(){
            $str = "";
            if($this->documentExtension != null) $str = $str . "s";
            return $str;
      }
      
      /**
       * Ritorna una array di stringhe costituita dai parametri della query, relativi alla parte di match
       * @return array Stringa con i tipi paramteri
       */
      public function getMatchParameters(){
            $paramArray = array();
            if($this->documentTitle != null)
                  $paramArray[] = "%".$this->documentTitle."%";
            if($this->documentSubtitle != null)
                  $paramArray[] = "%".$this->documentSubtitle."%";
            return $paramArray;
      }
      
      /**
       * Ritorna una array di stringhe costituita dai parametri della query, relativi alla parte di filter
       * @return array Stringa con i tipi paramteri
       */
      public function getFilterParameters(){
            $paramArray = array();
            if($this->documentExtension != null)
                  $paramArray[] = "%".$this->documentExtension."%";
            return $paramArray;
      }
      
      /**
       * @return int Numero di parametri da passare alla bind_param
       */
      public function getMatchNumParameters(){
            $n = 0;
            if($this->documentTitle != null) $n++;
            if($this->documentSubtitle != null) $n++;
            return $n;
      }
      
      /**
       * @return int Numero di parametri da passare alla bind_param
       */
      public function getFilterNumParameters(){
            $n = 0;
            if($this->documentExtension != null) $n++;
            return $n;
      }
}
?>