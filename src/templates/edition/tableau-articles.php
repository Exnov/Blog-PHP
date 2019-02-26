<div class="table-responsive">
	<table class="table table-hover" id="tableauBillets">
	 	<thead class="thead-dark">
			<tr>
				<th scope="col">Titre</th>
				<th scope="col">Date de création</th>
				<th scope="col">Date de modification</th>
				<th scope="col">Statut publication</th>
				<th scope="col">Commentaires</th>
				<th scope="col">Editer</th>
				<th scope="col">Supprimer</th>
			</tr>
		</thead>

		<tbody>

 	<?php
 	//DEBUT BOUCLE
	foreach ($articles as $article) { 
	?>
			<tr>
				<th scope="row"><a href="apercu-article-<?= htmlspecialchars($article->getId()) ?>">
					<?= $article->getTitre() ?></a>
				</th>
				<td><?= $article->getDate_creation() ?></td>
				<td><?= $article->getDate_modification() ?></td>
				<td><?= $article->getStatut_Publication() ?></td>
				<td><?php echo($managerCommentaires->getNbreCommentaires($article->getId())); ?></td>
				<td><a href="edition-article-<?= htmlspecialchars($article->getId()) ?>" class="btn-primary btn">Editer</a></td>
				<!-- Button trigger modal -->
				<td><button type="button" class="supprimer btn btn-danger" data-toggle="modal" data-target="#deleteModal">
  				Supprimer</button></td>
			</tr>	
	<?php	
	} //FIN BOUCLE
	?>
		</tbody>
	</table>

	<?php
		$titremodal="Suppression article";
		$messagemodal="Êtes-vous de vouloir supprimer cet article ?";
		include("modal.php");
	?>

</div>