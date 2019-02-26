<?php
$this->title = "Gestion du profil";
?>

<section>
  <h1 class="titre-edition">Profil de <span id="labelprofil"><?= $_SESSION['user'] ?></span></h1>
  <div class="contenu-edition">
      <form  id="formEditProfil" method="post">
        <div class="form-group">
            <label for="nom">Nom public</label><br>
            <input type="text" id="nom" name="nom" value="<?= $user->getNom() ?>" required><br>
        </div>
        <div class="form-group">
            <label for="login">Login</label><br>
            <input type="text" id="login" name="login" value="<?= $user->getLogin() ?>" required><br>
        </div>
        <div class="form-group">
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="<?= $user->getEmail() ?>" required><br>
        </div>
        <br/>
        <input type="submit" value="Modifier" id="editprofil" name="editprofil" class="btn btn-primary"/>
      </form>

      <div class="snackbar"></div>
      
  </div>
</section>
 
<section>
  <h1 class="titre-edition">Mot de passe</h1>
  <div class="contenu-edition">
      <form  id="formEditMtp" method="post">
          <div class="form-group">
            <label for="mtp">Mot de passe actuel</label><br>
            <input type="password" id="mtp" name="mtp" value="" required><br>
          </div>
          <div class="form-group">
            <label for="mtpnew">Nouveau mot de passe</label><br>
            <input type="password" id="mtpnew" name="mtpnew" value="" required><br>
          </div>
          <div class="form-group">
            <label for="mtpnew2">Confirmer nouveau mot de passe</label><br>
            <input type="password" id="mtpnew2" name="mtpnew2" value="" required><br>
          </div>
          <br/>
          <input type="submit" value="Modifier" id="editmtp" name="editmtp" class="btn btn-primary"/>
      </form>

      <div class="snackbar"></div>
      
  </div>
</section>
