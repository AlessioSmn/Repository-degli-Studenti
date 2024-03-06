
const CUSTOM_THEME = "_CUSTOM_THEME";

// Controllo se è stato impostato un tema nel localStorage
var theme = window.localStorage.getItem('theme');
if (theme)
      applyTheme(theme);

/**
 * Imposta il tema in localStorage per mantenere il tema costante tra le varie pagine
 * @param mode Nome del file CSS che contiene le variabili globali (senza estensione) o CUSTOM_THEME
 */
function setTheme(mode){
      // Salva il tema in localStorage
      window.localStorage.setItem('theme', mode);

      applyTheme(mode);
}

/**
 * Applica il tema fonrito come paramtero alla pagina corrente
 * @param theme Il tema da impostare
 */
function applyTheme(theme){

      // Tema custom
      if(theme == CUSTOM_THEME){

            // Prendo le informazioni sul tema dal localStorage
            const storedCustomTheme = window.localStorage.getItem('customThemeInfo');

            // Il tema custom potrebbe essere stato richiesto ma mai impostato
            if (!storedCustomTheme)
                  return;

            // Deseserializzo le informazioni sul tema
            const customTheme = JSON.parse(storedCustomTheme);

            // Scorro su tutte le variabili in customTheme
            Object.keys(customTheme).forEach(variable => {
                  // Applica il valore della variabile al documento HTML
                  document.documentElement.style.setProperty(variable, customTheme[variable]);
            });
      }

      else{
            // ELimino le eventuali variabili CSS impostate da un applyTheme(CUSTOM) precedente
            document.documentElement.setAttribute('style', '');

            // Per i temi predefiniti utilizzo i file css
            themeStylesheet = document.getElementById("theme");
            themeStylesheet.href = "css/themes/" + theme + ".css";
      }
}