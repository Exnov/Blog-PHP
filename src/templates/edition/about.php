<?php
$this->title = "Editer page A propos";
?>
<h1 class="titre-edition">Edition de la page 'A propos'</h1>


<div class="contenu-edition">
    <form  id="formEditAbout" method="post"" enctype="multipart/form-data" > 

        <div class="form-group">
          <label for="avatar">Avatar : </label>

          <input type="file"
                 id="avatar" name="avatar"
                 accept="image/png, image/jpeg, image/jpg"/>
        </div>

        <input id="memoAvatar" name="memoAvatar" type="hidden" value="<?= $avatar ?>"/>
         <div id="previewAvatar"><img id="imgPreviewAvatar" src="<?= $urlAvatar ?>">

              <button id="byePreviewAvatar" class="btn btn-warning">Retirer</button>
           
         </div>
         <br/>
         <div class="form-group">
          <label for="email">Email de contact : </label>
          <input type="email" id="email" name="email" value="<?= $email ?>">
        </div>
                  
         <div class="form-group">
           <label for="contenu">Contenu</label><br>
          <textarea id="contenu" name="contenu"><?= $contenu ?></textarea>
        </div>

        <div class="form-group">
          <label for="descriptionAbout">Meta-description</label><br>
          <textarea id="descriptionAbout" name="description" rows="4" class="zone-message"><?= $description ?>
          </textarea><br>
        </div>

        <input type="submit" value="Enregistrer" id="submit" name="submit" class="btn btn-primary" />

    </form>

    <div class="snackbar"></div>

</div>


<!--script js tiny -->
<?php
$this->scriptTiny = "<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script><script src='vendor/tinymce/js/js.js'></script>";
?>
