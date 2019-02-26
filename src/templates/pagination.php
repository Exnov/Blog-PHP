<div id="blocPagination">

	<?php

	if(isset($nArticles)){ 
		$nElts=intval($nArticles['nbre']); 
		$ref=6; 
	}
	if(isset($nCommentaires)){ //page gestion des commentaires
		$nElts=intval($nCommentaires['nbre']);
		$ref=10;
	}

	$nPage=1;
	if($nElts>$ref){
		$a=1;
		$z=ceil($nElts/$ref);
		$nPage=$z;
		$previous="";
		$next="";
		if($nElts>($ref*4)){
			$z=4;
			$previous='<li><a href="" class="'.$classe.'"><</a></li>';
			$next='<li><a href="" class="'.$classe.'">></a></li>';
		}
	?>
	<p id="infoNpages" class="small">Nombre total de pages <span><?= $nPage ?></span></p>
	<?php
	?>

	<div id="pager">

		<ul id="listepagination">

		<?php
		echo($previous);
		while($a<=$z){
		?>
			<li><a href="" class="<?php echo($classe);?>"><?php echo($a);?></a></li>
		<?php
			$a++;
		}
		echo($next);
		?>
			
		</ul>

	</div>
	
	<?php
	}
	?>	
	
</div>