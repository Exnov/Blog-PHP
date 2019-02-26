
<?php
$this->title = "Editer article";
?>

<?php
  if($article){ 
?>

  <h1 class="titre-edition">Edition d'un article</h1>

  <p><a href="gestionnaire-articles">Gestionnaire des articles</a> - <a href="apercu-article-<?= htmlspecialchars($article->getId()) ?>">Voir article</a></p>
  
  <div class="contenu-edition">
      <form id="formEdit" method="post"" 
        enctype="multipart/form-data">

            <div class="form-group">
              <label for="titre">Titre</label>
              <input type="text" id="titre" name="titre" value="<?php echo($article->getTitre());?>" class="t-article">
             </div>

            <div class="form-group">
              <label for="illustration">Image</label>
              <input type="file"
               id="illustration" name="illustration"
               accept="image/png, image/jpeg, image/jpg" value="<?php echo($article->getIllustration()); ?>"/>
           </div>

            <input id="idArticle" name="idArticle" type="hidden" value="<?php echo($article->getId()); ?>">
            <input id="memoImg" name="memoImg" type="hidden" value="<?php echo($article->getIllustration()); ?>"/>
            <input id="memoMedium" name="memoMedium" type="hidden" value="<?php echo($article->getMedium()); ?>"/>

             <div id="preview"><img id="imgpreview" src="<?php 
                 echo(!empty($article->getIllustration()) ? 'web/images/'.$article->getIllustration() : '');?>">
                 <button id="byePreview" class="btn btn-warning">Retirer</button>
             </div>
             <br/>

             <div class="form-group">
               <label for="contenu">Contenu</label><br>
              <textarea id="contenu" name="contenu"><?php echo($article->getContenu()); ?></textarea>
            </div>

             <div class="form-group">
              <label for="auteur">Auteur</label>
              <input type="text" id="auteur" name="auteur" value="<?php echo($article->getAuteur()); ?>">
             </div>

             <input type="submit" value="Enregistrer" id="enregistrer" name="enregistrer" class="btn btn-primary"/> 
             <input type="submit" value="Publier" id="publier" name="publier" class="btn btn-success"/>
             <input type="submit" value="Retirer" id="retirer" name="retirer" class="btn btn-warning"/>
             <input type="submit" value="Supprimer" id="supprimer" name="supprimer" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"/>

      </form>

      <div class="snackbar"></div>

      <?php
        $titremodal="Suppression article";
        $messagemodal="Êtes-vous de vouloir supprimer cet article ?";
        include("modal.php");
      ?>

  </div>

<!--script js tiny -->
<?php
  }
$this->scriptTiny = "<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script><script src='vendor/tinymce/js/js.js'></script>";
?>



