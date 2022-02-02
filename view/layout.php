<?php
foreach($_POST as $key => $value)
{
    $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
}

foreach($_GET as $key => $value)
{
    $_GET[$key] = htmlspecialchars(strip_tags(trim($value)));
}
?>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     
        <!-- Bootstrap icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

        <link rel="stylesheet" href="css/app.css"/>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <title>CDA - <?=$title;?></title>
      
    </head>

    <body>
<!-- NAVBAR BOOTSTRAP -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="index.php">- FORMATION CDA -</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBar" aria-controls="navBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navBar">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 25vw;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="?op=ajouter&data=patient">Ajouter un patient</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="?op=voir&data=patient&page=1">Liste des patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="?op=ajouter&data=rdv">Ajouter un RDV</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="?op=voir&data=rdv">Liste des RDV</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="?op=ajouter&data=rdvpatient">Ajouter un patient et un RDV</a>
                    </li>
            </div>
        </nav>        


        <main>
            <h1 class="text-center my-4 text-primary"><?=$title;?></h1>
        
        <?= $content;?>

        </main>    

        <footer class="text-center text-white bg-primary">
            2022 - Ludovic Herisson - Test formation CDA
        </footer>

        
        

        <!-- CDN Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    </body>
  </html>