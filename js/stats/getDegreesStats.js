
function getDegreesStats(mode, par = null){
      fetch("php/stats/getDegreesStats.php?mode="+mode)
      .then(response => response.json())
      .then(data => constructGraph(data))
      .catch(error => console.error("Errore: " + error));
}

function constructGraph(data){
      let graphContainer = document.getElementById("graphContainer");
      graphContainer.innerHTML = "";
      if(data === null){
            graphContainer.innerHTML = "Sorry, no data";
            return;
      }

      // non voglio pienare la pagina con il grafico che arriva da parte a parte
      var maxHeight = 0.65 * parseInt(graphContainer.clientWidth);

      // NB: la prima riga è sempre quella con il valore più alto
      var resizingFactor = 0;
      var first = true;
      data.forEach(function(queryRow){ 
            let ID = queryRow['ID'];
            let Name = queryRow['Name'];
            let ElemValue = queryRow['Value'];

            if(first){ 
                  // Imposto il fattore di scala, dato che il primo elemento è quello di dimensione massima
                  // Lo imposto in maniera tale che, dato un valore un valore, restituisca la
                  // dimensione che dovrà avere il div, coompresa quindi in [0; maxHeight]
                  resizingFactor = maxHeight / max(1, ElemValue);
                  first = false;
            }
            var elementValueDiv = document.createElement("div");
            elementValueDiv.setAttribute("class", "graphValue");
            elementValueDiv.innerHTML = ElemValue;
            graphContainer.appendChild(elementValueDiv);


            var graphElement = document.createElement("div");
            graphElement.setAttribute("class", "graphElement");
            graphElement.setAttribute("id", "degree_"+ID);
            graphElement.style.width = max(1, ElemValue * resizingFactor) + "px";
            graphElement.innerHTML = Name;
            graphContainer.appendChild(graphElement);
            graphContainer.appendChild(document.createElement("br"));
      });
}
function max(a, b){
      return a>b?a:b;
}