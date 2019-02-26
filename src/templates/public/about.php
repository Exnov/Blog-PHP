
<?php
$this->title = "A propos - Jean Forteroche";
$this->description = $description;
?>

<div id="about-content">
	<h1>A propos</h1>

	<?php
		if(isset($_SESSION['user'])){
			$validation=true;	
		}
	?>
		<div>
		<img id="avatar-public" alt="Jean Forteroche" src="<?= $avatar ?>">
		</div>
		<article>
	   <?= $contenu ?> 
	  </article>
	  <p class="font-weight-light mt-3">Contact : <a href="mailto:<?= $email ?>"><i class="fas fa-envelope"></i></a></p>
		<?php
		if(isset($validation) && $validation){
		?>
			<p><a href="edition-a-propos">éditer</a></p>
		<?php
		}
		?>	
</div>




