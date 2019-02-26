
<?php
$this->title = "Roman en ligne de Jean Forteroche";
?>

<?php
if(isset($accueil)){
  $this->description = $accueil->getDescription(); 
?>
  <div class="jumbotron" id="tete">

      <div id="infos-banner">
        <p id="invitation"><?= $accueil->getPromo() ?></p>
        <h1 class="display-5"><?= $accueil->getTitre() ?></h1>
        <p class="lead rounded"><?= $accueil->getMention() ?></p>
      </div>
       <!-- -->
       <div id="support-image">
        <img id="image-banner"  src="web/images/<?= $accueil->getImage() ?>" alt="<?= $accueil->getImage() ?>" class="rounded-top">
        <p id="tete-description"><?= $accueil->getextrait() ?></p>
      </div>
      
  </div>
<?php
}
?>

<?php
if(isset($_SESSION['add_billet'])) {
    echo ('<p>'.$_SESSION['add_billet'].'</p>');
    unset($_SESSION['add_billet']);
}
if(isset($_SESSION['user'])){
	$validation=true;
?>
  <p><a href="edition-accueil">éditer</a></p>
<?php
}
?>

<?php
	include("articles.php");
	//pagination
	include(dirname(dirname(__FILE__)).'/pagination.php');
?>


