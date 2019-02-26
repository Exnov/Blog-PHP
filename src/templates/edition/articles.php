
<?php
$this->title = "Administration";
?>

<h1 class="titre-edition">Gestion des articles</h1>	

<?php
//tableau d'administration des billets
include("tableau-articles.php");
//pagination
include(dirname(dirname(__FILE__)).'/pagination.php');
?>




	
