document.addEventListener("DOMContentLoaded", () => {
//aspetto che sia terminato il caricamento della pagina prima di eseguire

fetch("dati.php")
//richiesta di tipo GET al php
// Chiede i dati al server


  .then(response => response.json()) // Converte la risposta in oggetti JS
  .then(dati => {
    // Qui usi davvero i dati come array di oggetti
  });


});
