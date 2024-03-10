
function signup(event){
      event.preventDefault();

      // Recupera le informazioni inserite
      var name = document.querySelector('input[name="name"]').value;
      var surname = document.querySelector('input[name="surname"]').value;
      var email = document.querySelector('input[name="email"]').value;
      var password1 = document.querySelector('input[name="password"]').value;
      var password2 = document.querySelector('input[name="passwordRepeat"]').value;

      // Controllo che le due password coincidano
      if(password1 != password2){
            // TODO
            // Informa che le due password non coincidono
            window.alert("LE PASSWORD NON COINCIDONO");
            return false;
      }

      // Imposto i vari campi per la richiesta POST
      var fetchBodyOptions = new FormData();
      fetchBodyOptions.append("email", email);
      fetchBodyOptions.append("password", password1);
      fetchBodyOptions.append("name", name);
      fetchBodyOptions.append("surname", surname);
      var fetchOptions = {
            method: "POST",
            body: fetchBodyOptions,
      };

      // Fetch
      fetch("php/logControl/validateSignup.php", fetchOptions)

      // Deserializzo la risposta del server
      .then(response => response.json())

      // Il primo elemento dell'array è un booleano,
      // mi permette di capire se la registrazione è andata a buon fine o meno
      .then(data => {
            console.log(data);

            // Se la registrazione è avvenuta con successo porto l'utente alla home
            if(data[0])
                  window.location.href = "index.php";

            // Altrimenti dal PHP mi arriva un messaggio di errore
            else{
                  window.alert(data[1]);
            }
      })
      .catch(error => console.error(error));
}