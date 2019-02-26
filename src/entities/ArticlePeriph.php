<?php

namespace App\src\entities;

use App\src\entities\Article;

class ArticlePeriph {

	public function getHtml($article,$message){

		$html='<span class="mb-2">'.$message.'</span>';

		if(!empty($article)){
			$html='<a href="article-'.$article->getId().'" class="bg-dark text-white rounded mb-2">'.$article->getTitre().'</a>';
		}

		return $html;
	}
	
}

		