<?php  
    $PrepQuery = $conn->prepare("SELECT username from utente WHERE email = ?");
    $PrepQuery->bind_param("s", $_SESSION["email"]);
    $PrepQuery->execute();
    $result = $PrepQuery->get_result();
    $row = $result->fetch_assoc();
    $_SESSION['username'] = $row['username'];
    echo htmlspecialchars($row['username']);
?>