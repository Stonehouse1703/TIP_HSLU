<!DOCTYPE html>
<html lang="de">
<head>
    <title>ILLICH AG Eintrag Erstellen</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .bloecke {
            transition: background-color 0.5s; 
            cursor: pointer; 
            align-items: center;
            width: 100%;
            height: 50%;
        }

        .bloecke:hover {
            background-color: #ccc; 
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
            max-width: 500px;
        }

        .strich {
            width: 100%;
            height: 1px;
            background-color: black; 
        }

        .bloecke h2,
        .bloecke h3,
        .bloecke p {
            text-decoration: none;
            color: black;
        }

        a {
            text-decoration: none;
        }

    </style>

</head>

<body>

    <?php
    include('header.php');
    include('datenbank.php');
    ?>

    <div class="row">
        <div class="column">

            <?php
            $rowCount = mysqli_num_rows($result);

            if ($rowCount > 0) {
                // Wenn Einträge vorhanden sind
                $currentRow = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $currentRow++;
                    ?>
                    <div class="bloecke">
                        <a href='detail.php?NR=<?php echo $row['NR']; ?>'>
                            <p class="entry-info"><strong><?= $row['Name']; ?></strong> - <?= $row['Datum']; ?></p>
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
                            <h2 style="text-decoration: none;"><?= $row['Titel']; ?></h2>
                            <h3 style="text-decoration: none;"><?= $row['Untertitel']; ?> </h3>
                        </a>
                    </div>
                    <?php
                    // Display the line if it's not the last row
                    if ($currentRow < $rowCount) {
                        ?>
                        <div class="strich"></div>
                        <?php
                    }
                }
            } else {
                // Wenn kein Eintrag vorhanden ist
                ?>
                <h1>Kein Beitrag verfügbar</h1>
                <?php
            }
            ?>

        </div>
    </div>

    <?php
    include('footer.php');
    mysqli_close($con);
    ?>

</body>
</html>