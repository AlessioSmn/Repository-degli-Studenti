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
            this.currentPageIndexPosition = null;

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

            this.currentBlock = Index;
            
            this.adjustPageIndexes(Index);

            let firstElement = Index * this.blockDimension;
            let lastElement = (Index + 1) * this.blockDimension;
            return this.documents.slice(firstElement, lastElement);
      }

      adjustPageIndexes(NewIndex) {
            // Array dei bottoni per il cambio pagina
            let pageIndexElements = Array.from(this.pageIndexContainer.children);

            // Rimuovo la classe attiva dal bottone della vecchia pagina
            if(this.currentPageIndexPosition != null)
                  pageIndexElements[this.currentPageIndexPosition].classList.remove("current");

            // Numero del primo elemento mostrato
            let firstShift = this.calculateFirstShift(NewIndex);

            // Shift della pagina corrente rispetto al primo elemento mostrato
            let currentShift = this.calculateCurrentShift(NewIndex);
            
            // Mantengo la pagina corrent al centro dell'indice
            for(let i = 0; i < this.pageIndexesButtons; i++){
                  pageIndexElements[i].innerText = firstShift + i + 1;

                  // Quando sto impostando l'indice di pagina corrente lo segno
                  if(i == currentShift){
                        // Salvo l'indice in cui è stato inserito all'interno del container
                        this.currentPageIndexPosition = i;
                        pageIndexElements[this.currentPageIndexPosition].classList.add("current");
                  }
            }

            
      }
      /**
       * Calcola lo scostamento (quindi il numero) dell'indice di pagina corrente rispetto al primo mostrato
       * @param {Number} index Indice di pagina da mostrare
       * @return Ritorna lo scostamento
       */
      calculateCurrentShift(index){
            // shift = index                                   index <= leftSlot
            // shift = leftSlot                                leftSlot <= index <= numBlocks - slotDisponibili
            // shift = index - numBlocks + slotDisponibili     index >= slotDisponibili
            /*
            La funzione nel caso generale (molte pagine) è y = {
                  x                 per  x <= slot disponibili a sinistra (leftSlot)
                  leftSlot          per x >= leftSlot, {costante e uguale a leftSlot, così la pagina corrente è sempre al centro}
                        ma riprende ad aumentare per gli ultimi leftSlot indici, per mostrare la pagina corrente sempre più a destra, quindi:
                  index - this.numBlocks + slotDisponibili        per x >= this.NumBlocks - left
            }
            Nel caso tutti gli indici di pagina possano essere mostrati, questi saranno fissi e di conseguenza
            sarà solo la pagina corrente a scorrere, linearmente, quindi y = x
            */

            // Numero totale di slot disopnibli, si suppone dispari
            let slotDisponibili = this.pageIndexesButtons;

            if(slotDisponibili == this.numBlocks)
                  return index;

            // Numero di slot da lasciare a sinistra per avere quello corrente al centro
            let leftSlot = (slotDisponibili - 1) / 2;

            if(index <= leftSlot)
                  return index;

            return Math.max(leftSlot, index - this.numBlocks + slotDisponibili);
      }
      /**
       * Calcola lo scostamento (quindi il numero) che deve avere il primo indice di pagina mostrato
       * @param {Number} index Indice di pagina da mostrare
       * @return Ritorna lo scostamento
       */
      calculateFirstShift(index){
            /*
            La funzione è y = {
                  0                 per  x <= slot disponibili a sinistra (leftSlot)
                  x - leftSlot      per x >= leftSlot,
                        ma limitato da (this.numBlocks - slotDisponibili), per evitare di mostrare a destra inidici di pagina non presenti, quindi
                  this.numBlocks - slotDisponibili          per x >= this.NumBlocks - slotDisponibili
            }
            */
            let slotDisponibili = this.pageIndexesButtons;
            let leftSlot = Math.floor(slotDisponibili / 2);

            if(index <= leftSlot)
                  return 0;

            return Math.min(index - leftSlot, this.numBlocks - slotDisponibili);
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