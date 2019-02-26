<?php
$this->title = "Page accueil";
?>
<h1 class="titre-edition">Page accueil</h1>


<div class="contenu-edition">
    <form  id="formEditBanner" method="post" enctype="multipart/form-data">
        <h2>En-tête</h2>
        <div class="form-group">
          <label for="titreBanner">Titre</label><br>
          <input type="text" id="titreBanner" name="titre" value="<?= $titre ?>"><br> 
        </div>
        <div class="form-group">
          <label for="mentionBanner">Mention</label><br>
          <input type="text" id="mentionBanner" name="mention" value="<?= $mention ?>" size="30"><br>
        </div>
        <div class="form-group">
           <label for="extraitBanner">Extrait</label><br>
          <textarea id="extraitBanner" name="extrait" rows="7" class="zone-message"><?= $extrait ?></textarea><br>
        </div>
        <div class="form-group">
          <label for="promoBanner">Promo</label><br>
          <input type="text" id="promoBanner" name="promo" value="<?= $promo ?>"" size="70"><br>  
        </div>

        <input id="memoBanner" name="memoBanner" type="hidden" value="<?= $image ?>"/>
        
        <div class="form-group">
          <label for="imageBanner">Image (uniquement au format .jpg, dimensions recommandées : 1600px * 480px)</label><br>
          <input type="file" id="imageBanner" name="imageBanner" value="<?= $image ?>" accept="image/png, image/jpeg, image/jpg">
        </div>
          <br>
                <div id="previewbanner"><img id="imgpreviewbanner" src="<?= $urlImage ?>">
             </div>
          <br>   

          <h2>Meta-description</h2>              
          <div class="form-group">
            <textarea id="descriptionAccueil" name="description" rows="4" class="zone-message"><?= $description ?></textarea><br>
          </div>

          <input type="submit" value="Enregistrer" id="savebanner" name="savebanner" class="btn btn-primary"/>

    </form>

    <div class="snackbar"></div>
    
</div>


