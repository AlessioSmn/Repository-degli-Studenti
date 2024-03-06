
/**
 * Funzione per la gestione dell'operazione di login
 * @param {*} event 
 * @returns In caso di login avvenuto con successo redirige l'utente verso la pagina alla quale tentava di accedere
 */
function login(event){
      event.preventDefault();

      // Recupera email e password inserite
      var email = document.querySelector('input[name="email"]').value;
      var password = document.querySelector('input[name="password"]').value;

      // Imposto i campi email e password per la richiesta POST
      var fetchBodyOptions = new FormData();
      fetchBodyOptions.append("email", email);
      fetchBodyOptions.append("password", password);
      var fetchOptions = {
            method: "POST",
            body: fetchBodyOptions,
      };

      // Fetch
      fetch("php/logControl/validateLogin.php", fetchOptions)

      // Deserializzo la risposta del server
      .then(response => response.json())

      // Leggo la pagina di redirezione
      .then(data => {
            console.log(data);
            let pageName = data;

            // Se è presente una pagina redirigo
            if(data != "null")
                  window.location.href = pageName;
      })
      .catch(error => console.error(error));
}