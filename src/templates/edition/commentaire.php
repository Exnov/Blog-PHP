<?php
$this->title = "Edition d'un commentaire";
?>

<?php
  if($commentaire){
?>

  <h1 class="titre-edition">Edition d'un commentaire</h1>

  <p><a href="gestionnaire-commentaires">Gestionnaire des commentaires</a>
    <?php
    if(!empty($commentaire->getId_article_trouve())){
    ?>
     - <a href="apercu-article-<?=$commentaire->getId_article_trouve()?>">Voir article</a>
    <?php
    }
    ?>
 </p>

  <div class="contenu-edition">
      <form  id="formEditComment" method="post">

          	<input id="idComment" name="idComment" type="hidden" value="<?= $commentaire->getId() ?>">

            <div class="form-group">
              <label for="auteur">Auteur</label>
              <input type="text" id="auteur" name="auteur" value="<?= $commentaire->getAuteur() ?>">
            </div>
             <div class="form-group">
              <label for="contenu">Commentaire écrit le <?php echo($commentaire->getDate_creation()); ?></label><br>
              <textarea id="contenu" name="contenu" class="zone-message" rows="10"><?= $commentaire->getContenu() ?></textarea><br>
            </div>
             <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="<?= $commentaire->getEmail() ?>">
            </div>

            <input type="submit" value="enregistrer" id="submit" name="enregistrer" class="btn btn-primary"/>
            <?php
            $action="retirer";
            if($commentaire->getStatut_publication()=='retiré'){
            	$action="publier";
            }
            ?>
            <input type="submit" value="<?= $action ?>" id="pubcomment" name="<?= $action ?>" class="btn btn-secondary"/>
      </form>
      
      <div class="snackbar"></div>

  </div>

<?php
}
?>

<!--script js tiny -->
<?php
$this->scriptTiny = "<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script><script src='vendor/tinymce/js/js.js'></script>";
?>