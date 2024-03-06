
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
      var maxHeight = 0.65 * parseInt(graphContainer.clientWidth);

      // nb: first row is the one with more downloads
      var resizingFactor = 0;
      var first = true;
      data.forEach(function(queryRow){ 
            let ID = queryRow['ID'];
            let Name = queryRow['Name'];
            let ElemValue = queryRow['Value'];

            if(first){ 
                  // Set resizing factor so that when multiplied by sum in interval [0; downloadsSum in current iteration]
                  // it returns the height of the div in interval [0; maxHeight]
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
            // console.log(queryRow);
      });
}
function max(a, b){
      return a>b?a:b;
}