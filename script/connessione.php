<?php //FILE CHE CI COLLEGA AL DB

//informazioni di connessione
$host = "localhost";
$user = "root";
$pass = "";
$db = "banca";

//salvo tutte le informazioni di connessione nella variabile $conn
$conn = new mysqli($host, $user, $pass, $db);

//messaggio di errore nel caso il db non si connetta correttamente
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>