<?php

    echo '
            <!DOCTYPE html>
            <html lang="it">
                <head>
                    <meta charset="UTF-8">
                    <title>Errore</title>
                    <link rel="stylesheet" href="../css/style.css">
                </head>
                <body>
                    <div class="container-error">
                        <h1 class="error">⚠️ Errore ⚠️</h1>
                        <p><b>Qualcosa è andato storto. Email o password non corrette.</b></p>
                        <p>Non sei registrato? <a href="../registrazione"> Fallo ora!</a> <p>
                        <button onclick="window.history.back()" class="save-submit">Torna al login</button>
                    </div>
                </body>
            </html>
            ';
?>