class Statistics{

      /**
       * Costruttore della classe statistics
       * @param {HTMLElement} GraphContainer Elemento HTML che andrà a contnere il grafico
       */
      constructor(GraphContainer, NoResultSection, AxisContainer){
            // Array di statistiche da mostrare
            this.statistics = [];

            // Ordinamento del grafico secondo numero di download decrescente
            this.orderByDownloads = true;

            // Container del grafico
            this.graphContainer = GraphContainer;

            // Container del grafico
            this.axisContainer = AxisContainer;

            // Sezione con l'immagine da mostrare quando non ci sono risultati
            this.noResultSection = NoResultSection;
      
            // Larghezza dell'elemento più grande, in relazione percentuale con la larghezza del container
            this.maxWidthPercentage = 70;

            // Salvo le informazioni dell'ultima ricerca fatta
            this.currentTarget = null;
            this.currentGroup = null;
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

            this.currentTarget = Target;
            this.currentGroup = Group;

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
            const noResultSection = document.getElementById("no-result");

            if(this.statistics.length == 0){
                  // Informo che non ci sono risultati
                  this.graphContainer.innerText = "Nessun grafico da mostrare";

                  this.axisContainer.innerText = "";
                  
                  // E mostro l'immagine
                  this.noResultSection.style.display = "block";

                  return;
            }

            // Cancello il contenuto del container
            this.graphContainer.innerHTML = "";

            // Nascondo l'immagine
            this.noResultSection.style.display = "none";

            // Genero il titolo del grafico
            let graphTitle = document.createElement("h3");
            let title = '';
            switch(this.currentTarget){
                  case 'User': title += 'Utenti ordinati per numero di '; break;
                  case 'Subject': title += 'Materie ordinate per numero di '; break;
                  case 'Degree': title += 'Corsi di laurea ordinati per numero di '; break;
            }
            title += this.orderByDownloads ? "download" : "documenti caricati";
            graphTitle.innerText = title;
            this.graphContainer.appendChild(graphTitle);

            // Valore massimo, rispetto al quale scalare tutti gli elementi
            let maxValue = 0;

            let first = true;

            for(let singleStat of this.statistics){

                  // Se è il primo elemento mi salvo il valore massimo
                  if(first){
                        maxValue = this.orderByDownloads ? singleStat.downloads : singleStat.uploads;
                        // Evito il caso in cui maxValue sia uguale a zero, metto minimo 1
                        maxValue = Math.max(maxValue, 1);
                        first = false;
                  }

                  // Calcolo la width che dovà avere questo elemento
                  let percentageOfMax = (this.orderByDownloads ? singleStat.downloads : singleStat.uploads) / maxValue;
                  let finalWidth = percentageOfMax * this.maxWidthPercentage;

                  let statContainer = singleStat.constructGraphElement(this.orderByDownloads, finalWidth);
                  this.graphContainer.appendChild(statContainer);
            }

            // Cancello le righe verticali precedenti
            this.axisContainer.innerText = "";

            // Valore massimo che potrebbe essere mostrato nel grafico
            // nb: scalo tutti i valori al this.maxWidthPercentage% per non riempire la pagina
            let maxValueInGraphDisplayed = 100 * maxValue / this.maxWidthPercentage;

            // divido il range [0; maxValueInGraphDisplayed] in N parti (N = subdivisions)
            let subdivisions = 10;

            // Calcolo lo step
            let step = maxValueInGraphDisplayed / subdivisions;

            // 'Arrotondo' lo step per avere dei numeri più 'immediati' sulle ascisse
            step = roundStep(step);

            for(let i = 0; true; i++){
                  // Valore da mostrare
                  let value = step * i;

                  // left shift della barra
                  let leftShift = value * 100 / maxValueInGraphDisplayed;

                  // Esco dal ciclo quando ho quasi riempito la pagina con le barre verticali (quasi -> 94%)
                  if(leftShift >= 94) break;

                  leftShift += '%'; 

                  // Barra verticale
                  let verticalBar = document.createElement("div");
                  verticalBar.classList.add("vertical-line");
                  verticalBar.style.left = leftShift;
                  this.axisContainer.appendChild(verticalBar);

                  // Valore mostrato in alto
                  let verticalBarValueTop = document.createElement("div");
                  verticalBarValueTop.classList.add("vertical-line-value", "top");
                  verticalBarValueTop.style.left = 'calc(' + leftShift + ' - 20px)';
                  verticalBarValueTop.innerText = value;
                  this.axisContainer.appendChild(verticalBarValueTop);

                  // Valore mostrato in basso
                  let verticalBarValueBottom = document.createElement("div");
                  verticalBarValueBottom.classList.add("vertical-line-value", "bottom");
                  verticalBarValueBottom.style.left = 'calc(' + leftShift + ' - 20px)';
                  verticalBarValueBottom.innerText = value;
                  this.axisContainer.appendChild(verticalBarValueBottom);
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

const roundedSteps = [1, 2, 3, 5, 10, 15, 20, 30, 40, 50, 75, 100, 150, 200, 250];
function roundStep(preciseStep){
      preciseStep = Number(preciseStep);

      // Se step <= 1 ritorno 1
      // Si stanno tracciando numeri di upload e download di documenti, 
      // non ha senso parlare di numeri non interi
      if(preciseStep <= 1)
            return 1;

      // Se step >= 300 ritorno precise step troncato delle cifre delle decine e unità
      if(preciseStep >= 300)
            return (Math.floor(preciseStep / 100) * 100);

      // altrimenti cerco lo step arrotondato più vicino a preciseStep, minore di preciseStep
      for(let i = 0; i < roundedSteps.length; i++)
            if(roundedSteps[i] >= preciseStep) return roundedSteps[i-1];

      return 300;
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
            // Tolgo i 10px di padding
            graphPart.style.width = 'calc(' + widthPercentage + '% - 10px)';

            // Testo del elemento
            let graphBarText = document.createElement("span");
            graphBarText.classList.add("graph-element-bar-text");
            graphBarText.innerText = this.name;
            graphPart.appendChild(graphBarText);

            // Informazioni mostrate solo all'hover
            let additionalInfo = document.createElement("div");
            additionalInfo.classList.add("graph-element-additional-info");

            // Numero di uploads
            let uploadsInfo = document.createElement("div");
            let uploadsInfoSpan = document.createElement("span");
            uploadsInfoSpan.innerText = "Uploads ";
            uploadsInfo.appendChild(uploadsInfoSpan);
            let uploadsInfoData = document.createElement("span");
            uploadsInfoData.innerText = this.uploads;
            uploadsInfo.appendChild(uploadsInfoData);
            additionalInfo.appendChild(uploadsInfo);

            // Numero di downloads
            let downloadsInfo = document.createElement("div");
            let downloadsInfoSpan = document.createElement("span");
            downloadsInfoSpan.innerText = "Downloads ";
            downloadsInfo.appendChild(downloadsInfoSpan);
            let downloadsInfoData = document.createElement("span");
            downloadsInfoData.innerText = this.downloads;
            downloadsInfo.appendChild(downloadsInfoData);
            additionalInfo.appendChild(downloadsInfo);

            graphPart.appendChild(additionalInfo);
            elementContainer.appendChild(graphPart);

            elementContainer.setAttribute("data-opened", JSON.stringify(false));
            elementContainer.onclick = function(){
                  const opened = JSON.parse(elementContainer.getAttribute("data-opened"));
                  if(opened) elementContainer.classList.remove("open");
                  else elementContainer.classList.add("open");
                  elementContainer.setAttribute("data-opened", JSON.stringify(!opened));
            };

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