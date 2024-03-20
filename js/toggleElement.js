
/**
 * Aggiorna il CSS del container in maniera da riflettere la scelta fatta
 * @param {HTMLElement} callerElement Elemento che chiama la funzione
 * @param {Number} optionIndex Indice dell'opzione selezionata
 */
function changeOptionInToggleOptions(callerElement, optionIndex) {
      const toggleContainer = callerElement.parentNode;

      // Rimuovo la precedente classe di opzione selezionata
      let classes = toggleContainer.classList;
      // lo scorro
      for(let cssClass of classes)
            // Se inizia con option- la rimuovo
            if (cssClass.startsWith('option-'))
                  toggleContainer.classList.remove(cssClass);

      // Aggiungo la nuova classe
      toggleContainer.classList.add('option-' + Number(optionIndex + 1) +'-selected');
}