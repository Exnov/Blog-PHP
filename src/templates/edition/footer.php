<?php
$this->title = "Editer footer";
?>
<h1 class="titre-edition">Edition du footer</h1>

<div class="contenu-edition">
    <form  id="formEditFooter" method="post" > 

         <label for="contenu">Contenu</label><br>
        <textarea id="contenu" name="contenu"><?= $contenu ?></textarea><br>

         <input type="submit" value="Enregistrer" id="submit" name="submit" class="btn btn-primary"/>
    </form>

    <div class="snackbar"></div>

</div>

<!--script js tiny -->
<?php
$this->scriptTiny = "<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script><script src='vendor/tinymce/js/js.js'></script>";
?>



