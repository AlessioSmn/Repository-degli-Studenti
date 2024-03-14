
// Indice del blocco di documenti visualizzato
let currentBlock = 0;

// Numero di documenti in un blocco
let blockDimension = 7;

// NUmero di blocchi in cui sono divisi i documenti
let numBlocks; // = Math.ceil(Number(DOCUMENTS.length / blockDimension));

let container = document.getElementById("page-index-container");

function visualizeNextBlock(){
      let maxNumBlocks = Math.ceil(Number(DOCUMENTS.length / blockDimension));
      if(currentBlock >= maxNumBlocks - 1)
            return false;

      currentBlock++;
      visualizeBlock(currentBlock);

      adjustCurrentPageIndex(currentBlock - 1, currentBlock);

      return true;
}

function visualizePreviousBlock(){
      if(currentBlock == 0)
            return false;

      currentBlock--;
      visualizeBlock(currentBlock);
      
      adjustCurrentPageIndex(currentBlock + 1, currentBlock);

      return true;
}

function visualizeExactBlock(index){
      if(index < 0 || index >= maxNumBlocks - 1)
            return false;

      let oldIndex = currentBlock;
      visualizeBlock(index);
      
      adjustCurrentPageIndex(oldIndex, currentBlock);

      return true;
}

/**
 * Permette di reimpostare i vari parametri per una nuova visualizzazione dei documenti
 * @param {string} numDocuments Numero di documenti totali
 * @param {Number} blockDimension Il numero di documenti da visualizzare per blocco
 * @param {number} [startingBlock=0] Il primo blocco da visualizzare
 */
function firstVisualization(NumDocuments, BlockDimension, StartingBlock = 0){
      blockDimension = BlockDimension;
}

function visualizeBlock(blockIndex){
      let firstDoc = blockIndex * blockDimension;
      let lastDoc = (blockIndex + 1) * blockDimension;
      populateWithDocuments(DOCUMENTS.slice(firstDoc, lastDoc));
}

function PROVA(){
      // let container = document.getElementById("page-index-container");
      let middleChildren = Array.from(container.children).slice(1, container.children.length-1);
      console.log(middleChildren);
}

function adjustCurrentPageIndex(oldIndex, newIndex){
      let pageIndexElements = Array.from(container.children);
      pageIndexElements[oldIndex + 1].classList.remove("current");
      pageIndexElements[newIndex + 1].classList.add("current");
}

function firstVisualization(NumDocuments, BlockDimension, StartingBlock = 0){
      blockDimension = BlockDimension;
      // ...
}

class PageHandler{
      /**
       * Il Costruttore della classe PageHandler
       * @param {HTMLElement} PageIndexContainer L'elemento HTML che contiene i bottoni per il cambio delle pagine
       */
      constructor(PageIndexContainer){
            /** Elemento HTML che contiene i bottoni per il passaggio tra pagine */
            this.pageIndexContainer = PageIndexContainer;

            /** Indice del blocco di documenti attualmente visualizzato */
            this.currentBlock = null;

            /** Numero di documenti che vanno a comporre un blocco */
            this.blockDimension = 1;

            /** Array dei documenti da visualizzare */
            this.documents = null;

            /** Numero di bottoni visualizzati per lo scorrimento tra le pagine */
            this.pageIndexesButtons = 0;

            /** Indice dell'indice di pagina corrente all'interno di this.pageIndexContainer*/
            this.currentPageIndexPosition = null;

            /** Numero di blocchi presenti (RIDONDANTE) */
            this.numBlocks = 1;
      }

      /**
       * Permette di reimpostare i vari parametri per una nuova visualizzazione dei documenti
       * @param {Array} Documents Array dell'insieme di tutti i documenti
       * @param {Number} blockDimension Il numero di documenti da visualizzare per blocco
       * @param {number} [startingBlock=0] Il primo blocco da visualizzare
       * @param {number} [PageIndexesButtons=5] Numero massimo di bottoni per lo scorrimento delle pagine da visualizzare
       * @return {Array} Ritorna il sottoinsieme dei documenti da visualizzare
       */
      firstVisualization(Documents, BlockDimension, StartingBlock = 0, PageIndexesButtons = 5){
            // Inizializzo i tre campi
            this.blockDimension = BlockDimension > 0 ? BlockDimension : 1;
            this.numBlocks = Math.ceil(Number(Documents.length / this.blockDimension));
            this.currentBlock = this.isIndexValid(StartingBlock) ? StartingBlock : 0;
            this.documents = Documents;

            if(PageIndexesButtons <= 0)
                  this.pageIndexesButtons = Math.min(5, this.numBlocks);
            else
                  this.pageIndexesButtons = Math.min(PageIndexesButtons, this.numBlocks);

            this.createPageIndexes();

            return this.visualizeBlock(this.currentBlock);
      }

      /**
       * Controlla se l'indice di blocco è ammissibile
       * @param {Number} Index Indice di blocco
       * @return {boolean} True se l'indice è ammissibile, false altrimenti
       */
      isIndexValid(Index){
            if(Index < 0 || Index >= this.numBlocks)
                  return false;
            return true;
      }

      /**
       * Visualizza il blocco richiesto
       * @param {Number} Index Indice del blocco da visualizzare
       * @return {Array|boolean} Ritorna il sottoinsieme dei documenti da visualizzare se possibile, false altrimenti
       */
      visualizeBlock(Index){
            if(!this.isIndexValid(Index))
                  return false;

            let OldIndex = this.currentBlock;
            this.currentBlock = Index;
            
            this.adjustPageIndexes(OldIndex, Index);

            let firstElement = Index * this.blockDimension;
            let lastElement = (Index + 1) * this.blockDimension;
            return this.documents.slice(firstElement, lastElement);
      }

      adjustPageIndexes(OldIndex, NewIndex) {
            // Array dei bottoni per il cambio pagina
            let pageIndexElements = Array.from(this.pageIndexContainer.children);

            // Rimuovo la classe attiva dal bottone della vecchia pagina
            if(this.currentPageIndexPosition != null)
                  pageIndexElements[this.currentPageIndexPosition].classList.remove("current");

            // Distanza dal primo e ultimo bottone mostrato se metto la pagina corrente al centro
            let difference = Math.floor(this.pageIndexesButtons / 2);

            // Se sto mettendo una delle prime pagine (una di indice <= (this.pageIndexesButtons + 1) / 2) non posso scalare troppo
            let shift = -Math.min(NewIndex, difference);

            // Stesso discorso per le ultime pagine, ma lo controllo solo se ci sono più bottoni che pagine da visualizzare
            if(this.numBlocks > this.pageIndexesButtons){
                  let shift2 = difference - Math.min(this.numBlocks - 1 - NewIndex, difference);
                  shift -= shift2;
            }
            
            // Mantengo la pagina corrent al centro dell'indice
            for(let i = 0; i < this.pageIndexesButtons; i++){
                  pageIndexElements[i].innerText = NewIndex + i + 1 + shift;

                  // Quando sto impostando l'indice di pagina corrente lo segno
                  if(i + shift == 0){
                        // Salvo l'indice in cui è stato inserito all'interno del container
                        this.currentPageIndexPosition = i;
                        pageIndexElements[this.currentPageIndexPosition].classList.add("current");
                  }
            }

            
      }

      /**
       * Visualizza il prossimo blocco se possibile
       * @return {Array|boolean} Ritorna il sottoinsieme dei documenti da visualizzare se possibile, false altrimenti
       */
      visualizeNextBlock(){
            return this.visualizeBlock(this.currentBlock + 1);
      }

      /**
       * Visualizza il blocco precedente se possibile
       * @return {Array|boolean} Ritorna il sottoinsieme dei documenti da visualizzare se possibile, false altrimenti
       */
      visualizePreviousBlock(){
            return this.visualizeBlock(this.currentBlock - 1);
      }

      createPageIndexes(){
            // Rimuovo tutti i figli 
            this.pageIndexContainer.innerHTML = "";

            // Aggiungo il numero corretto di figli
            for(let i = 0; i < this.pageIndexesButtons; i++){
                  let pageIndexElem = document.createElement("div");
                  pageIndexElem.classList.add("page-index-element");
                  pageIndexElem.innerText = i + 1;
                  this.pageIndexContainer.appendChild(pageIndexElem);
            }
      }
}