<?php
$this->title = "Editer logo/favicon";
?>

<h1 class="titre-edition">Edition du logo et du favicon</h1>

<div class="contenu-edition">
    <form  id="formEditLogos" method="post"" enctype="multipart/form-data" > 

        <div class="form-group">
          <label for="logo">Logo : (format recommandé : .png, dimensions recommandées : 150px * 150px)</label><br/>
          <input type="file"
                 id="logo" name="logo"
                 accept="image/png, image/jpeg, image/jpg"/>
        </div>
        
        <div id="previewLogo"><img id="previewLogoImg" src="<?php 
             echo(!empty($logos->getLogo()) ? 'web/images/'.$logos->getLogo() : '');?>">

              <button id="byePreviewLogo" class="btn btn-warning">Retirer</button>              
         </div>
        <input id="memoLogo" name="memoLogo" type="hidden" value="<?= $logos->getLogo() ?>"/>

        <br/>
        <div class="form-group">
           <label for="favicon">Favicon : (format recommandé : .ico, dimensions recommandées : 64px * 64px)</label><br/>
          <input type="file"
                 id="favicon" name="favicon"
                 accept="image/png, image/jpeg, image/jpg"/>
        </div>
                   
       <div id="previewFavicon"><img id="previewFaviconImg" src="<?php 
           echo(!empty($logos->getFavicon()) ? 'web/images/'.$logos->getFavicon() : '');?>">

            <button id="byePreviewFavicon" class="btn btn-warning">Retirer</button>              
       </div>   
       <input id="memoFavicon" name="memoFavicon" type="hidden" value="<?= $logos->getFavicon() ?>"/>       


       <br/><br/>
        <input type="submit" value="Enregistrer" id="submit" name="submit" class="btn btn-primary"/>

    </form>

    <div class="snackbar"></div>

</div>


