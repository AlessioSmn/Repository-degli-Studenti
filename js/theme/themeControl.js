
const CUSTOM_THEME = "_CUSTOM_THEME";
let brightBackground = false;

// Controllo se è stato impostato un tema nel localStorage
let theme = window.localStorage.getItem('theme');

// In tal caso lo imposto
if (theme)
      applyTheme(theme);

// e modifico il logo, ma solo a pagina caricata
document.addEventListener('DOMContentLoaded', adaptLogo);

/**
 * Imposta il tema in localStorage per mantenere il tema costante tra le varie pagine
 * @param mode Nome del file CSS che contiene le variabili globali (senza estensione) o CUSTOM_THEME
 */
function setTheme(mode){
      // Salva il tema in localStorage
      window.localStorage.setItem('theme', mode);

      applyTheme(mode);

      adaptLogo();
}

/**
 * Applica il tema fonrito come paramtero alla pagina corrente
 * @param theme Il tema da impostare
 */
function applyTheme(theme){

      // Tema custom
      if(theme == CUSTOM_THEME){

            // Prendo le informazioni sul tema dal localStorage
            let storedCustomTheme = window.localStorage.getItem('customThemeInfo');

            // Il tema custom potrebbe essere stato richiesto ma mai impostato
            if (!storedCustomTheme)
                  return;

            // Deseserializzo le informazioni sul tema
            let customTheme = JSON.parse(storedCustomTheme);

            // Scorro sui vari campi (le varie varibili --bgColor, --foreColor, etc)
            for(let themeElement in customTheme){

                  // Ricavo il valore della varibaile, ossia il colore
                  let themeElementValue = customTheme[themeElement];

                  // Applico il colore
                  document.documentElement.style.setProperty(themeElement, themeElementValue);

                  if(themeElement == '--bgColor_dark')
                        brightBackground = isColorBright(themeElementValue);

            }
      }

      else{
            // ELimino le eventuali variabili CSS impostate da un applyTheme(CUSTOM) precedente
            document.documentElement.setAttribute('style', '');

            // Per i temi predefiniti utilizzo i file css
            themeStylesheet = document.getElementById("theme");
            themeStylesheet.href = "css/themes/" + theme + ".css";

            // Tra quelli default l'unico che necessita il logo scuro è il tema chiaro
            brightBackground = theme == 'light';
      }
}

/**
 * Indica se il colore passato come parametro è luminoso o meno
 * @param {String} color Colore espresso come #RRGGBB
 * @param {Number} threshold Soglia (da 0 a 255) per rilevare la lumiosità
 */
function isColorBright(color, threshold = 160){

      // 0.299 R + 0.587 G + 0.114 B;
      let R = parseInt(color.substring(1, 3), 16);
      let G = parseInt(color.substring(3, 5), 16);
      let B = parseInt(color.substring(5, 7), 16);

      let brightness = 0.299 * R + 0.587 * G + 0.114 * B;

      return brightness >= threshold;
}

/**
 * Seleziona il logo bianco o nero a seconda della luminosità dello sfondo
 */
function adaptLogo(){
      const logoElement = document.getElementById("footerUnipiLogo");
      const version = brightBackground ? "black" : "white";
      logoElement.src = "media/.ico/cherubino_" + version + ".ico";
}