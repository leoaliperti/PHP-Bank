<?php
    $email = $_POST["email"];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("errore");
    }

    $password = htmlspecialchars($_POST["password"]);
    //criptografia della password per non salvarla in chiaro
    $password = password_hash($password, PASSWORD_DEFAULT);

    $name = htmlspecialchars($_POST["name"]);
    $surname = htmlspecialchars($_POST["surname"]);
    $secondName = htmlspecialchars($_POST["secondName"]);

    $username = htmlspecialchars($_POST["username"]);
    if (empty($username)) {
        $username = $name . $surname;
    }

    $brith = $_POST["birth"];
    $phone = htmlspecialchars($_POST["phone"]);
    $gender = $_POST["genere"];

    //includiamo il file "connessioni.php" in modo da usare le variabili che contiene
    require_once "../script/connessione.php";

    //scriviamo la QUERY per aggiungere le informazioni dell'utente al Db
    $PrepQuery = $conn->prepare("INSERT INTO utente (email, password, username, name, secondName, surname, birth, gender, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    //$conn viene da "connessioni.php"
    //$PrepQuery contiene la query preparata a cui verranno aggiuente le informazioni dopo. e si usa per evitare attacchi
    //i 3 ?, ?, ? sono placeholder per le info che aggiungeremo

    $PrepQuery -> bind_param("sssssssss", $email, $password, $username, $name, $secondName, $surname, $brith, $gender, $phone);
    //bind_param sostituisce i 3 ??? nell'ordine in cui inserisco le 3 variabili
    //"sss" dice che stai passando 3 stringhe (s = string)

    if($PrepQuery -> execute())
    {
        header("Location: ../login");
        exit;

    }
    else{
        echo "Errore: " . $PrepQuery->error;
    }

    $PrepQuery -> close();
    $conn -> close();
?>