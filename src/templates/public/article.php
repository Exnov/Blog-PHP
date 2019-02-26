
<?php
$this->title = "Articles";
$this->description = strip_tags($article->getExtrait()); 
?>

<?php
	if(isset($_SESSION['user'])){
		$validation=true;	
	}
?>

<div id="billet-single">

  	<article>
  		<h1><?= $article->getTitre() ?></h1>
      <?php
      if(isset($validation) && $validation){
      ?>
        <p><a href="gestionnaire-articles">Gestionnaire des articles</a> - <a href="gestionnaire-commentaires">Gestionnaire des commentaires</a> - <a href="edition-article-<?= htmlspecialchars($article->getId()) ?>">Éditer l'article</a></p>
      <?php
      }
      ?>      
  		<small>publié et écrit le <?= $article->getDate_publication() ?> par <?= $article->getAuteur() ?></small>	
  		<div id="imgbillet"><img src="<?php 
                 echo(!empty($article->getIllustration()) ? 'web/images/'.$article->getIllustration() : '');?>"
                 alt="<?= $article->getTitre() ?>">
      </div>

  		<?= $article->getContenu() ?> <!--automatiquement compris entre p -->	
  		<?php
  		if(isset($validation) && $validation){
  		?>
  			<p><a href="edition-article-<?= htmlspecialchars($article->getId()) ?>">Éditer l'article</a></p>
  		<?php
  		}
  		?>	
  	</article>

    <!-- -->
    <hr class="mt-5 sep-pagination-article">
    <?php
    if(isset($htmlArticlePrevious)){
    ?>
        <p id="pagination-article" class="mt-4"><?= $htmlArticlePrevious ?><?= $htmlArticleNext ?></p>
    <?php
    }
    ?>

    <hr class="mt-4 mb-4">

  <?php
  	include("commentaires.php");
  ?>

  <section id="billet-commentaire" class="mt-4">
    <h3 class="titre-single">Ajoutez un commentaire</h3>
 
    <form id="formComment" method="post">
      <input id="idArticle" name="idArticle" type="hidden" value="<?php echo($article->getId()); ?>">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="auteur">Nom</label>
          <input type="text" class="form-control" id="auteur" name="auteur" placeholder="Nom" required>
        </div>
        <div class="form-group col-md-6">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
      </div>

      <div class="form-group row">
        <div class="form-group col-md-12">
          <br/>
           <textarea id="contenu" name="contenu" placeholder="Message" class="zone-message" rows="10" required></textarea><br>
        </div>
      </div>

      <input type="submit" value="Envoyer" id="submit" name="submit" class="btn btn-primary">

    </form>
  
  </section>

</div>

