
/**
 * Funzione per la gestione dell'operazione di login
 * @param {*} event 
 * @return In caso di login avvenuto con successo redirige l'utente verso la pagina alla quale tentava di accedere
 */
function login(event){
      event.preventDefault();

      // Recupera email e password inserite
      let email = document.querySelector('input[name="email"]').value;
      let password = document.querySelector('input[name="password"]').value;

      // Imposto i campi email e password per la richiesta POST
      let fetchBodyOptions = new FormData();
      fetchBodyOptions.append("email", email);
      fetchBodyOptions.append("password", password);
      let fetchOptions = {
            method: "POST",
            body: fetchBodyOptions,
      };

      // Fetch
      fetch("php/logControl/validateLogin.php", fetchOptions)

      // Deserializzo la risposta del server
      .then(response => response.json())

      // Leggo la pagina di redirezione
      .then(data => {
            // se il login è avvenuto con successo
            if(data[0]){
                  let pageName = data[1];
                  
                  // Se è presente una pagina redirigo
                  if(pageName != null)
                        window.location.href = pageName;
            }
            else{
                  document.getElementById("loginError").style.display = 'block';
            }
      })
      .catch(error => console.error(error));
}