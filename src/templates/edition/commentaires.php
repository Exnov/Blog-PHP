
<?php
$this->title = "Gestion des commentaires";
?>

<h1 class="titre-edition">Gestion des commentaires</h1>

<?php
//tableau des commentaires
include("tableau-commentaires.php");

//pagination
include(dirname(dirname(__FILE__)).'/pagination.php');
?>


	
