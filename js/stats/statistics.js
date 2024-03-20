class Statistics{

      /**
       * Costruttore della classe statistics
       * @param {HTMLElement} GraphContainer Elemento HTML che andrà a contnere il grafico
       */
      constructor(GraphContainer){
            // Array di statistiche da mostrare
            this.statistics = [];

            // Ordinamento del grafico secondo numero di download decrescente
            this.orderByDownloads = true;

            // Container del grafico
            this.graphContainer = GraphContainer;
      
            // Larghezza dell'elemento più grande, in relazione percentuale con la larghezza del container
            this.maxWidthPercentage = 70;
      }


      /**
       * Dato un'entità della quale si vogliono reperire le informazioni di upload e download (Utenti, materia o corso di laurea),
       * eventualmente relativi a un sottoinsieme (tutti, per una data materia, per un dato corso di laurea), 
       * inetrroga il database per ricavare le informazioni richieste e costruisce il grafico
       * @param {String} Target L'entità della quale si vogliono reperire le informazioni di upload e download  ['User' | 'Subject' | 'Degree' ]
       * @param {String} Group Sottoinsieme da considerare [ 'All' | 'Degree' | 'Subject' ]
       * @param {Number | null} [GroupId=null] L'identificatore dell'eventuale gruppo, significativo solo se Group != 'All'
       */
      retrieveStatistics(Target, Group = 'All', GroupId = null){

            // Costruisco i parametri della fetch
            let fetchParam = "Target=" + Target + "&Group=" + Group;
            if(Group != 'All') fetchParam += "&GroupId=" + GroupId;

            // Fecth per ricavare un array di dati da visualizzare
            fetch("php/stats/getDegreesStats.php?" + fetchParam)

            // Deserializzo la risposta
            .then(response => response.json())

            // Costruisco il grafico
            .then(data => {

                  // Pulisco l'array di statistiche
                  this.statistics = [];

                  // Popolo l'array con le statistiche appena lette
                  for(let statData of data){
                        let Id = statData['ID'];
                        let Name = statData['Name'];
                        let Uploads = statData['Uploads'];
                        let Downloads = statData['Downloads'];
                        this.statistics.push(new StatRecord(Id, Name, Uploads, Downloads));
                  }

                  // Ordino le statitsiche
                  this.sortStatistics();

                  // Costruisco il grafico
                  this.constructGraph();
            })

            .catch(error => console.error("Errore: " + error));
      }

      /**
       * Ordina l'array di statistiche secondo il campo indicato da this.orderByDownloads
       */
      sortStatistics(){
            this.statistics.sort(this.orderByDownloads ? sortStatsByDownloads : sortStatsByUploads);
      }

      constructGraph(){
            if(this.statistics.length == 0){
                  this.graphContainer.innerHTML = "Nessun grafico da mostrare :(";
                  return;
            }

            // Cancello il contenuto del container
            this.graphContainer.innerHTML = "";

            // Valore massimo, rispetto al quale scalare tutti gli elementi
            let maxValue = 0;

            let first = true;

            for(let singleStat of this.statistics){

                  // Se è il primo elemento mi salvo il valore massimo
                  if(first){
                        maxValue = this.orderByDownloads ? singleStat.downloads : singleStat.uploads;
                        first = false;
                  }

                  // Calcolo la width che dovà avere questo elemento
                  let percentageOfMax = (this.orderByDownloads ? singleStat.downloads : singleStat.uploads) / maxValue;
                  let finalWidth = percentageOfMax * this.maxWidthPercentage;

                  let statContainer = singleStat.constructGraphElement(this.orderByDownloads, finalWidth);
                  this.graphContainer.appendChild(statContainer);
            }
      }

      /**
       * Cambia la variabile di ordinamento, ripopola il grafico se necessario
       * @param {boolean} OrderByDownloads Indica se il grafico deve mostrare i dati ordinati secondo Downloads
       */
      changeOrder(OrderByDownloads){

            // Controllo se è stato cambiato l'ordine
            let orderChanged = this.orderByDownloads != OrderByDownloads;

            // Salvo il nuovo ordine
            this.orderByDownloads = OrderByDownloads;

            // Se ci sono dati e l'ordinamento è cambiato allora riordino e ripopolo il grafico
            if(this.statistics.length > 0 && orderChanged){

                  // Ordino le statitsiche
                  this.sortStatistics();

                  // Costruisco il grafico
                  this.constructGraph();

            }
      }
}

class StatRecord{
      constructor(
            Id,
            Name,
            Uploads,
            Downloads
      ){
            this.id = Id;
            this.name = Name;
            this.uploads = Uploads;
            this.downloads = Downloads;
      }

      /**
       * Costruisce un elemento HTML per mostrare la statistica
       * @param {Boolean} showDownloads Indica se mostrare il valore dei downloads o degli uploads
       * @param {Number} widthPercentage Width percentuale da impostare per l'elemento, in centesimi
       * @returns {HTMLElement} Ritorna un elemento HTML per mostrare la statistica
       */
      constructGraphElement(showDownloads, widthPercentage){
            let elementContainer = document.createElement("div");
            elementContainer.classList.add("graph-element-container");

            // Elemento per contenere l'informazione sul valore di ordinamento
            let infoElement = document.createElement("div");
            infoElement.classList.add("graph-element-value");
            infoElement.innerText = showDownloads ? this.downloads : this.uploads;
            elementContainer.appendChild(infoElement);

            // Barra del grafico
            let graphPart = document.createElement("div");
            graphPart.classList.add("graph-element-bar");
            graphPart.innerText = this.name;
            graphPart.style.width = widthPercentage + '%';
            elementContainer.appendChild(graphPart);

            return elementContainer;
      }
}

/**
 * Funzione di sort tra due StatRecord, ordina per numero di Uploads decrescente
 * @param {StatRecord} A 
 * @param {StatRecord} B 
 * @returns {Number} -1 se A è precedente a B, 0 se sono equivalenti, 1 se A è successivo a B
 */
function sortStatsByUploads(A, B){
      return B.uploads - A.uploads;
}

/**
 * Funzione di sort tra due StatRecord, ordina per numero di Downloads decrescente
 * @param {StatRecord} A 
 * @param {StatRecord} B 
 * @returns {Number} -1 se A è precedente a B, 0 se sono equivalenti, 1 se A è successivo a B
 */
function sortStatsByDownloads(A, B){
      return B.downloads - A.downloads;
}