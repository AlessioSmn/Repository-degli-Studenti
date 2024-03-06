<?php
// include 'MySQLSelectionFilter.php';
class DocumentElement{
      private $documentTitle;
      private $documentSubtitle;

      /**
       * @param string $DocumentTitle Il titolo del documento
       * @param string $DocumentSubtitle Il sottotitlo del documento
       */
      public function __construct($DocumentTitle = null, $DocumentSubtitle = null){
            $this->documentTitle = $DocumentTitle;
            $this->documentSubtitle = $DocumentSubtitle;
      }

      /**
       * @return string Stringa per la proiezione in MySQL delle specifiche del documento, preparato per bind_param
       */
      public function stringQueryConstraint(){
            if($this->documentTitle == null && $this->documentSubtitle == null)
                  return "";
            $str = "";
            if($this->documentTitle != null){
                  $str = MySQLSelectionFilter::DocTITLE;
                  if($this->documentSubtitle != null)
                        $str  = $str . " OR " . MySQLSelectionFilter::DocSUBTITLE;
            }
            else if($this->documentSubtitle != null)
                  $str = MySQLSelectionFilter::DocSUBTITLE;
            return " (" . $str . ") ";
      }
      
      /**
       * @return string Stringa con i tipi dei paramteri, es.: "sii" per stringa-intero-intero
       */
      public function getParameterTypes(){
            $str = "";
            if($this->documentTitle != null) $str = $str . "s";
            if($this->documentSubtitle != null) $str = $str . "s";
            return $str;
      }
      
      /**
       * @return array Stringa con i tipi paramteri
       */
      public function getParameters(){
            $paramArray = array();
            if($this->documentTitle != null)
                  $paramArray[] = "%".$this->documentTitle."%";
            if($this->documentSubtitle != null)
                  $paramArray[] = "%".$this->documentSubtitle."%";
            return $paramArray;
      }
      
      /**
       * @return int Numero di parametri da passare alla bind_param
       */
      public function numParameters(){
            $n = 0;
            if($this->documentTitle != null) $n++;
            if($this->documentSubtitle != null) $n++;
            return $n;
      }
}
?>