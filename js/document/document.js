/**
 * Classe usata per memorizzare un documento
 * @param {int} id Identificatore numerico (usato nel database)
 * @param {string} title Titolo del documento
 * @param {string} subtitle Sottotitolo del documento se presente
 * @param {string} extension Estensione del file del documento
 * @param {string} author Autore del documento (Nome)
 * @param {string} subject Materia del documento
 * @param {string} degree Corso di studi del documento
 * @param {string} downloads Numero di download
 * @param {Date} lastModifiedDate Data dell'ultima modifica
 * @param {Date} uploadDate Data di upload del file
 */
      class Document{
      constructor(
            id, 
            title,
            subtitle,
            extension,
            author,
            subject,
            degree,
            downloads,
            lastModifiedDate,
            uploadDate
      ){
            this.id = id;
            this.title = title;
            this.subtitle = subtitle;
            this.extension = extension;
            this.author = author;
            this.subject = subject;
            this.degree = degree;
            this.downloads = downloads;
            this.lastModifiedDate = lastModifiedDate;
            this.uploadDate = uploadDate;
      }
}

/**
 * Funzione che ordina un array di documenti (documents) secondo un campo passato come parametro
 * @param {Array} documents Array di documenti
 * @param {string} field Campo secondo il quale ordinare l'array
 * @param {boolean} ascending Specifica se l'rdine dev'essere crescente (true) o decrescente (false)
 * @returns {null} Riordina l'array documents passato per riferimento
 */
function sortDocuments(documents, field, ascending){

      documents.sort((a, b) => {

            // Se i campi hanno lo stesso valore ritorna 0
            if(a[field] == b[field])
                  return 0;

            // Sort deve ritornare -1 se a dev'essere precedente a b
            if(ascending)
                  return a[field] < b[field] ? -1 : 1;
            
            else
                  return a[field] > b[field] ? -1 : 1;

      });
}