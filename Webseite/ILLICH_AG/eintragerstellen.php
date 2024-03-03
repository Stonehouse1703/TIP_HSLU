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
        width: fit-content;
        display: flex;
        flex-direction: column;
        align-items: baseline;
    }

    .column input{
        padding: 0.5em;
        margin: 1em;
        width: calc(100% - 2em);
        border-radius: 10px;
    }

    .column textarea{
        padding: 0.5em;
        margin: 1em;
        width: calc(100% - 2em);
        border-radius: 10px;
    }

    .column button{
        width: calc(100% - 2em);
        border-radius: 20px;
        padding: 10px;
        background-color: rgb(55, 102, 49);
        color: rgb(255, 255, 255);
        border: none;
    }

    .column button:hover {
        background-color: rgb(89, 201, 74);
        color: rgb(255, 255, 255);
    }

    .Foti {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .Foti input{
        border: none;
    }

    .error {
        border: 2px solid red; /* Apply red border for error */
    }

  </style>

</head>

<body>

    <?php include('header.php'); ?>
    <div class="row">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="column">
                <!-- Überpüft ob die input leer sind, falls ja, wird es per error rot, Zudem werden die Bereits eingegebenen Daten gespeichert.  -->
                <input type="text" name="name" placeholder="Name" class="<?php if(isset($_POST["posten"]) && empty($_POST["name"])) echo 'error'; ?>" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                <input type="text" name="email" placeholder="E-Mail" class="<?php if(isset($_POST["posten"]) && empty($_POST["email"])) echo 'error'; ?>" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <input type="text" name="title" placeholder="Titel" class="<?php if(isset($_POST["posten"]) && empty($_POST["title"])) echo 'error'; ?>" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                <input type="text" name="untertitel" placeholder="Untertitel" class="<?php if(isset($_POST["posten"]) && empty($_POST["untertitel"])) echo 'error'; ?>" value="<?php echo isset($_POST['untertitel']) ? htmlspecialchars($_POST['untertitel']) : ''; ?>">
                <textarea name="nachricht" rows="10" cols="50" placeholder="Nachricht" style="resize: none;" class="<?php if(isset($_POST["posten"]) && empty($_POST["nachricht"])) echo 'error'; ?>"><?php echo isset($_POST['nachricht']) ? htmlspecialchars($_POST['nachricht']) : ''; ?></textarea>


                <div class="Foti">
                    <label for="Foti">Fotos:</label>
                    <input type="file" id="Foti" name="bild" accept="image/*">
                </div>

                <button type="submit" name="posten">Posten</button>

                <?php
                // Überprüfen ob kein Kasten leer gelassen worden ist, bevor es auf die Datenbank hochgeladen wird.
                if (!isset($_POST["posten"]) || (isset($_POST["posten"]) && !empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["title"]) && !empty($_POST["untertitel"]) && !empty($_POST["nachricht"]))) {
                    include('datenbank.php');
                
                    // Setzt die Variablen wieder auf leer, sodass es ersichtlich ist, dass die Daten hochgeladen wurden.
                    echo "<script>
                        document.getElementsByName('name')[0].value = '';
                        document.getElementsByName('email')[0].value = '';
                        document.getElementsByName('title')[0].value = '';
                        document.getElementsByName('untertitel')[0].value = '';
                        document.getElementsByName('nachricht')[0].value = '';
                    </script>";
                }
                ?>

            </div>
        </form>
    </div>

    <?php 
        include('footer.php'); 
    ?>  

</body>

</html>
