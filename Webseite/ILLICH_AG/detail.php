<!DOCTYPE html>
<html lang="de">
<head>
  <title>ILLICH AG Eintrag</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">

  <style>
    .row {
        display: flex;
        justify-content: center;
    }

    .column {
        align-items: center;
        width: fit-content;
        display: flex;
        flex-direction: column;
        align-items: baseline;
        align-items: center;
    }

    .column img {
        max-width: 600px;
        max-height: 600px;
        width: auto;
        height: auto;
    }
 
    .fotos {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .fotos img {
        width: 100%;
        height: 100%;
    }

  </style>

</head>
<body>

<?php
include('header.php');
include('datenbank.php');

// Überprüfe, ob die 'NR'-Variable in der URL vorhanden ist
if (isset($_GET['NR'])) {
    //wählt die NR aus.
    $selectedId = mysqli_real_escape_string($con, $_GET['NR']);
    // holt alle Daten
    $query = "SELECT * FROM `gaestebuch` WHERE `NR`='$selectedId'";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="row">
            <div class="column">
                <div class="fotos">
                    <?php
                    if (!empty($row['Bild'])) {
                        $imagePath = $row['Bild'];
                        ?>
                            <img src="<?= $imagePath; ?>" alt="Uploaded Image">
                        <?php
                    }
                    ?>
                </div>
                <p><strong><?= $row['Name']; ?></strong> <?= $row['Datum']; ?></p>
                <h2><?= $row['Titel']; ?></h2>
                <h3><?= $row['Untertitel']; ?></h3>
                <p><?= $row['Nachricht']; ?></p>
            </div>
        </div>
        <?php
    } else {
        echo "<h1>Eintrag nicht gefunden.</h1>";
    }
}

include('footer.php');
mysqli_close($con);
?>

</body>
</html>
