
/**
 * @param {string} field Il campo secondo cui ordinare i documenti: 
 * 
 *    [Title]     - titolo
 * 
 *    [UsrName]   - nome dell'autore
 * 
 *    @deprecated [UsrMail]   - mail dell'autore
 * 
 *    [Download]  - numero di download
 * 
 *    [Subject]   - nome della materia
 * 
 *    [Upload]    - data di caricamento
 * 
 *    [Update]    - data di ultima modifica
 * @param {boolean} asc Stabilisce l'ordine: 
 * 
 * True -> crescente
 * 
 * False -> decrescente
 */
function reOrderDocuments(field, asc){
      var docContainer = document.getElementById("documentVisualizer");
      var docs = Array.from(docContainer.children);
      var fieldAttribute = getAttributeFromFieldName(field);
      // clear all docs
      //docContainer.innerHTML = "";
      // const fragment = document.createDocumentFragment();
      

      // Array.sort(compareFunction)
      /*
      docs.sort((a, b) => {
            fieldA = a.getAttribute(fieldAttribute);
            fieldB = b.getAttribute(fieldAttribute);

            if(fieldA == fieldB) return 0;
            if(asc)
                  return fieldA.localeCompare(fieldB);
            else
                  return fieldB.localeCompare(fieldA);
      });
      */
      docs = sort_download(docs, asc);

      // console.log("Order field: " + fieldAttribute);
      // add all docs reordered
      /*
      docs.forEach(doc => {
            // docContainer.appendChild(doc);
            if(!fragment.contains(doc)) // evita duplicati per via del forced reflow
                  fragment.appendChild(doc);
            // console.log(doc.getAttribute(fieldAttribute));
      });
*/
      for (var i = 0; i < docs.length; i++) {
            docs[i].parentNode.appendChild(docs[i]);
      }
      // docContainer.appendChild(fragment);
}

function getAttributeFromFieldName(fieldName){
      switch(fieldName){
            case "Title":
                  return "data-doc-title";
            case "UsrName":
                  return "data-doc-author";
                  /*
            case "UsrMail":
                  return;
                  */
            case "Download":
                  return "data-doc-download";
                  // return parseInt(docElem.getAttribute("data-doc-download"));
            case "Subject":
                  return "data-doc-subject";
            case "Upload":
                  return "data-doc-upload";
            case "Update":
                  return "data-doc-update";
            default:
                  return "data-doc-download";
      }
}
function getDownload(docElem){
      return 
}

function sort_download(docs, asc){
      docs.sort((a, b) => {
            fieldA = parseInt(a.getAttribute("data-doc-download"));
            fieldB = parseInt(b.getAttribute("data-doc-download"));

            if(fieldA == fieldB) return 0;
            if(asc)
                  return fieldA - fieldB;
            else
                  return fieldB - fieldA;
      });
      return docs;
}