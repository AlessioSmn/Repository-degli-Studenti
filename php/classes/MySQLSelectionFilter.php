<?php
/**
 * Classe di utilità per fornire vincoli MySQL per una interrogazione riguardante un documento
 */
class MySQLSelectionFilter{
      /** Vincolo sul titolo del documento (che contenga una data stringa) */
      const DocTITLE =        "(LOWER(document.title) LIKE ? )";

      /** Vincolo sul sottotitolo del documento (che contenga una data stringa) */
      const DocSUBTITLE =     "(LOWER(document.subtitle) LIKE ? )";

      /** Vincolo sull'estesione del documento (che contenga una data stringa) */
      const DocEXTENSION =    "(LOWER(document.extension) LIKE ? )";

      /** Vincolo sul nome della corso di studi del documento (che contenga una data stringa) */
      const DegNAME =         "(LOWER(degreecourse.name) LIKE ? )";

      /** Vincolo sul nome della materia del documento (che contenga una data stringa) */
      const SubNAME =         "(LOWER(subject.name) LIKE ? )";

      /** Vincolo sul numero minimo di CFU della materia*/
      const SubMinCFU =       "(subject.cfu >= ?)";

      /** Vincolo sul numero massimo di CFU della materia*/
      const SubMaxCFU =       "(subject.cfu <= ?)";

      /** Vincolo sullo username dell'autore del documento (che contenga una data stringa) */
      const UsrNAME =         "(LOWER(user.name) LIKE ? )";

      /** Vincolo sull'email dell'autore del documento (che contenga una data stringa) */
      const UsrMAIL =         "(LOWER(user.email) LIKE ? )";
}
?>