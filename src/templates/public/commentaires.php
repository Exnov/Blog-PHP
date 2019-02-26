
<?php
if(!empty($commentaires)){
?>
	<section id="billet-commentaires" class="mt-4">
	<h3 class="titre-single">Commentaires</h3>
	<?php
		foreach ($commentaires as $commentaire) {
		?>
		<article>
			<p><strong><?= htmlspecialchars($commentaire->getAuteur()) ?></strong> a commenté le 
				<?= htmlspecialchars($commentaire->getDate_creation()) ?></p> 

			<p>"<?= $commentaire->getContenu() ?>"</p>
		</article>
		<button type="button" class="signaler btn btn-warning btn-sm mb-4 mt-4" value="<?= htmlspecialchars($commentaire->getId()) ?>">Signaler</button>
		<!-- -->
		<div class="snackbar"></div>
		<!-- -->
	    <?php
	    if(isset($validation) && $validation){
	    ?>
			<p><a href="edition-commentaire-<?= htmlspecialchars($commentaire->getId()) ?>">Éditer le commentaire</a></p>
		<?php
		}
		?>
		<hr class="mt-3 sep-comments">
		<?php
		}
	?>
	</section>
<?php
}
?>







