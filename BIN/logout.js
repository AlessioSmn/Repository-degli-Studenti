
/**
 * Effettua il logout dalla sessione corrente
 */
function logout(){
      // Cancello la sessione in PHP
      fetch("php/logControl/logout.php")

      // Ricarico la pagina dopo che è arrivata la risposta
      .then(() => { location.reload(); })

      .catch(error => console.log(error))
}