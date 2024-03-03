<style>

  .topnav {
    overflow: hidden;
    background-color: #333;
    text-align: center; 
    padding: 1em;
  }

 
  .topnav a {
    display: inline-block; 
    color: white;
    text-align: center;
    padding: 0.1em 2em;
    text-decoration: none;
    border-radius: 2em;
    vertical-align: middle;
  }

  .topnav img {
    vertical-align: middle;
    padding: 10px;
  }

  .foti {
    position: absolute;
    top: 0;
    right: 0;
  }

  .foti img {
    height: 80px;
    width: 80px;
    border-radius: 100%;
  }

  /* Change color on hover */
  .topnav a:hover{
    background-color: green;
  }

  @media screen and (max-width:600px) {
    .topnav a {
      display: flex;
      align-items: center;
      width: 80%;
    }

    .topnav img {
      vertical-align: middle;
    }
  }

</style>

<body>
  <div class="topnav">
    <a href="/ILLICH_AG"><img src="img/home.svg">Home</a>
    <a href="gaestebuch.php"><img src="img/book.svg">Gästebuch</a>
    <a href="eintragerstellen.php"><img src="img/note.svg">Einträge Erstellen</a>
    <a href="aboutus.php"><img src="img/group.svg">Über uns</a>
    <a href="contact.php"><img src="img/contact.svg">Kontakte</a>
    <div class="foti">
      <img src="img/LOGO.jpg" alt="LOGO">
    </div>
  </div>
</body>