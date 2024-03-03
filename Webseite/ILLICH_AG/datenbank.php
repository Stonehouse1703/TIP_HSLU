<?php
define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('db', 'illichag');

$con = mysqli_connect(host, user, pass, db);

//überprüfung, ob der Server erreichbar ist
if (!$con) {
    echo "Es besteht derzeit keine Verbindung zur Datenbank. <br> Bitte versuchen Sie es erneut.";
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // wenn der Post button bei Einträge Erstellen gedrückt wird. 
        // Variablen werden gespeichert.
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $titel = mysqli_real_escape_string($con, $_POST['title']);
        $untertitel = mysqli_real_escape_string($con, $_POST['untertitel']);
        $nachricht = mysqli_real_escape_string($con, $_POST['nachricht']);
        $datum = date('Y-m-d H:i:s');

        // Die Bilder werden unter uploads gespeichert.
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['bild']['name']);

        // Überprüft, ob das Bild hochgeladen ist.
        if ($_FILES['bild']['error'] == UPLOAD_ERR_OK) {
            if (!move_uploaded_file($_FILES['bild']['tmp_name'], $uploadFile)) {
                echo '<div class="bad">Fehler beim Hochladen des Bildes.</div>';
            }
            
        }

        // analysiere das hochgeladene Bild und gib mir Informationen darüber
        $imageColumn = ($_FILES['bild']['error'] == UPLOAD_ERR_OK) ? ', `Bild`' : '';
        $imageValue = ($_FILES['bild']['error'] == UPLOAD_ERR_OK) ? ",'$uploadFile'" : '';

        // sendet die daten an die Datenbank
        $query = "INSERT INTO `gaestebuch`(`NR`, `Name`, `E-Mail`, `Titel`, `Untertitel`, `Nachricht`$imageColumn, `Datum`) VALUES ('','$name','$email','$titel','$untertitel','$nachricht'$imageValue,'$datum')";
        $result = mysqli_query($con, $query);
        mysqli_close($con);
    } else {
        // holt die daten von der Datenbank und sortiert diese nach Datum.
        $query = "SELECT * FROM `gaestebuch` ORDER BY `Datum` DESC";
        $result = mysqli_query($con, $query);
    }
}
?>
