<div class="table-responsive">
	<table class="table table-hover" id="tableauCommentaires">
		 	<thead class="thead-dark">
				<tr>
					<th scope="col">Titre de l'article</th>
					<th scope="col">Signalement</th>
					<th scope="col">Commentaire</th>
					<th scope="col">Auteur</th>
					<th scope="col">Email</th>
					<th scope="col">Date de création</th>
					<th scope="col">Statut</th>
					<th scope="col">Editer</th>
					<th scope="col">Supprimer</th>
				</tr>
			</thead>

			<tbody>
	 	<?php
	 	//DEBUT BOUCLE
		foreach ($commentaires as $commentaire) {
		?>
				<tr>
					<th scope="row">
						<?php
						if(!empty($commentaire->getTitre_article())){ 
							echo('<a href="apercu-article-'.$commentaire->getId_article_trouve().'">'.$commentaire->getTitre_article().'</a>');
						}
						else{
							echo('article supprimé');
						}
						?>							
					</th>
					<td><?= $commentaire->getSignalement() ?></td>
					<td><?= $commentaire->getExtrait() ?></td>
					<td><?= $commentaire->getAuteur() ?></td>
					<td><?= $commentaire->getEmail() ?></td>
					<td><?= $commentaire->getDate_creation() ?></td>
					<td><?= $commentaire->getStatut_Publication() ?></td>
					<td><a href="edition-commentaire-<?= htmlspecialchars($commentaire->getId()) ?>" 
						class="btn-primary btn">Editer</a></td>
					<!-- Button trigger modal -->
					<td><button type="button" class="supprimercomment btn btn-danger" data-toggle="modal" data-target="#deleteModal">
	  				Supprimer</button></td>
				</tr>			
		<?php	
		} //FIN BOUCLE
		?>
		</tbody>
	</table>

	<?php
		$titremodal="Suppression commentaire";
		$messagemodal="Êtes-vous de vouloir supprimer ce commentaire ?";
		include("modal.php");
	?>

</div>