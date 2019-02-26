
<section id="blocBillets">
	<h1 id="titre-bloc-billets">Les derniers épisodes ... <i class="fas fa-book-reader"></i></h1>


	<div class="row">
	<?php
	foreach ($articles as $article) { 
	?>
			<article class="col-sm-6 mb-4 carte-article">
				
					<div class="card">

						  <div class="card-header titre-card">
						    <h3>
						    	<a href="article-<?= htmlspecialchars($article->getId()) ?>">
									<?= $article->getTitre() ?>
								</a>
						    </h3>
						  </div>
						  <a href="article-<?= htmlspecialchars($article->getId()) ?>">
						  <img class="card-img-top" src="<?php 
   								echo(!empty($article->getMedium()) ? 'web/images/'.$article->getMedium() : '');?>"  alt="<?= $article->getTitre() ?>">
   							</a>
						
						<div class="card-body"> 

							<?= $article->getExtrait() ?>  <!--automatiquement compris entre p -->	
							
						</div>
						<div class="card-footer text-muted">
						    <small>publié le <?= $article->getDate_publication() ?> par <?= $article->getAuteur() ?></small>
							<!--si commentaires : -->
							<?php
							if($managerCommentaires->getNbreCommentaires($article->getId())){
								$n=$managerCommentaires->getNbreCommentaires($article->getId());
							?>
								<span class="bulle">
									<a href="article-<?= htmlspecialchars($article->getId()) ?>">
										<small><?= $n ?> </small><i class="fas fa-comment"></i>
									</a>
								</span>
							<?php
							}
							?>
							<?php
							if(isset($validation) && $validation){
							?>
								<p><a href="edition-article-<?= htmlspecialchars($article->getId()) ?>">éditer</a></p>
							<?php
							}
							?>

						 </div>
					</div>

			</article>
	<?php	
	}
	?>
	</div>

</section>






