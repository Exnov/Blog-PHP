<?php
$this->title = "Ajouter un article";
?>
<h1 class="titre-edition">Ecrire un nouvel article</h1>


  <div class="contenu-edition">
      <form  method="post"" enctype="multipart/form-data" action="index.php?route=add"> 

          <div class="form-group">
             <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" class="t-article">
          </div>
          <div class="form-group">
            <label for="illustration">Image : </label>

            <input type="file"
                   id="illustration" name="illustration"
                   accept="image/png, image/jpeg, image/jpg"/>
          </div>

           <div id="preview"><img id="imgpreview" src="">
               <button id="byePreview" class="btn btn-warning">Retirer</button>
           </div>
           <br/>

          <div class="form-group">
             <label for="contenu">Contenu</label><br>
            <textarea id="contenu" name="contenu"></textarea>
          </div>
          <div class="form-group">
            <label for="auteur">Auteur</label>
            <input type="text" id="auteur" name="auteur" value="<?php echo($auteur); ?>">
          </div>
         
          <input type="submit" value="Enregistrer" id="submit" name="submit" class="btn btn-primary"/>
      </form>

  </div>

<!--script js tiny -->
<?php
$this->scriptTiny = "<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script><script src='vendor/tinymce/js/js.js'></script>";
?>
