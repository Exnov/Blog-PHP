<?php
$this->title = "Login";
?>
<h1 id="titre-page">Connexion</h1>

<form method="post" action="gestionnaire-articles">

  <div class="form-group row">
    <label for="login" class="col-sm-2 col-form-label">Login</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="login" placeholder="..." name="login">
    </div>
  </div>

  <div class="form-group row">
    <label for="password" class="col-sm-2 col-form-label">Mot de passe</label>
    <div class="col-sm-4">
      <input type="password" class="form-control" id="password" placeholder="..." name="password">
    </div>
  </div>

  <button type="submit" class="btn btn-primary" value="Connexion" name="submit">Connexion</button>

</form>
	

<?php
if(isset($message)){
	echo('<p class="mt-4 text-center" id="attention">'.$message.'  <i class="far fa-frown"></i></p>');
}
?>