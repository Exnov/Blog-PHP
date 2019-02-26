<?php
$chemin="login"; 
$label='<i class="fa fa-unlock" aria-hidden="true"></i>';
$idEntree="connexion";
$check=false;
if(isset($_SESSION)){

    if(isset($_SESSION['user'])){
        $check=true;
        $chemin="logout"; 
        $label='<i class="fas fa-lock"></i>';
        $idEntree="deconnexion";
        $menu_admin='<li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-user"></i>
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="ajouter-article">Créer article</a>
                <a class="dropdown-item" href="gestionnaire-articles">Gérer articles</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="gestionnaire-commentaires">Gérer commentaires</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="edition-accueil">Page Accueil</a>
                <a class="dropdown-item" href="edition-a-propos">Page A propos</a>               
                <a class="dropdown-item" href="edition-footer">Footer</a>
                <a class="dropdown-item" href="edition-logo-favicon">Logo/favicon</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="edition-profil">Profil</a>
              </div>
            </li>';
        $validation=true;
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="shortcut icon" type="image/x-icon" href="<?php 
               echo(!empty($logos->getFavicon()) ? 'web/images/'.$logos->getFavicon() : '');?>" id="favicon-header"/>
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description ?>">
    <!--fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!--bootstrap -->
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> 	
	 <!--perso -->
   <link rel="stylesheet" href="web/css/style.css">
</head>
<body>


  <header class="sticky-top">

      <!--menu taille classique -->
      <nav class="navbar navbar-expand-sm navbar-dark container" id="menu-principal">
        <a class="navbar-brand" href="accueil"><img src="<?php 
         echo(!empty($logos->getLogo()) ? 'web/images/'.$logos->getLogo() : '');?>" id="nav-logo"></a>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="accueil"><i class="fa fa-home" aria-hidden="true"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="a-propos"><i class="fas fa-info-circle"></i></a>
          </li>
          <!-- Dropdown -->
          <?php
          if($check){
              echo($menu_admin);
          }
          ?>
           <li class="nav-item">
            <a class="nav-link" href="<?= $chemin ?>" id="<?= $idEntree ?>"><?= $label ?></a>
          </li>
        </ul>
      </nav>

      <!--menu taille réduite -->
      <div id="menu-principal-hamburger">
        <nav class="navbar navbar-dark container">
          <a class="navbar-brand" href="accueil"><img src="<?php 
         echo(!empty($logos->getLogo()) ? 'web/images/'.$logos->getLogo() : '');?>" id="nav-logo"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </nav> 

        <div class="collapse container navbar-dark" id="navbarToggleExternalContent">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="accueil"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="a-propos"><i class="fas fa-info-circle"></i></a>
            </li>
            <!-- Dropdown -->
            <?php
            if($check){
                echo($menu_admin);
            }
            ?>
             <li class="nav-item">
              <a class="nav-link" href="<?= $chemin ?>" id="<?= $idEntree ?>"><?= $label ?></a>
            </li>
          </ul>
        </div>
      </div>

  </header>

  <main id="content" class="container">

        <?= $content ?>
  </main>

  <footer class="container">
    <?php

    if(isset($footer)){
        echo($footer->getContenu());
    }

    if(isset($validation) && $validation){
    ?>
      <p><a href="edition-footer">éditer</a></p>
    <?php
    }
    
    ?>      
  </footer>

  <!--js -->
  <!--bootstrap -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <!--jQuery -->
  <script
          src="https://code.jquery.com/jquery-3.3.1.min.js"
          integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
          crossorigin="anonymous"></script>
  <!--tiny -->
  <?= $scriptTiny ?>
  <!--perso -->
  <script src="web/js/ajax.js"></script>
  <script src="web/js/js.js"></script>

</body>
</html>