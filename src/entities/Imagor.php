<?php

namespace App\src\entities;

class Imagor{

	protected $extension;
	protected $temp;
	protected $chemin;
	protected $nomImage;
	protected $source;
	protected $donnees;
	protected $medium;
	protected $cheminMedium;
	protected $largeur;
	protected $hauteur;

	public function __construct($temp){
		$this->temp=$temp;
		$this->chemin="web/images/"; 
		$this->cheminMedium="web/images/"; 
		$this->medium="";
	}

	public function copie(){

		if (isset($this->temp) AND $this->temp['error']== 0){

			//check si le fichier n'est pas trop gros
			if ($this->temp['size'] <= 1000000){

				//check si l'extension est autorisée
				$infosfichier =pathinfo($this->temp['name']);
				$this->extension = $infosfichier['extension'];
				$extensions_autorisees = array('jpg', 'jpeg', 'JPG', 'gif','png','ico');

				if (in_array($this->extension, $extensions_autorisees)){

					//on peut valider le fichier et le stocker définitivement
					$this->nomImage=$infosfichier['filename'];
					$this->chemin=$this->chemin.$this->nomImage.'.'.$this->extension;

					move_uploaded_file($this->temp['tmp_name'], $this->chemin);

				}
			}
		}
	}

	public function resize($largeur,$hauteur){ 

		$this->largeur=$largeur;
		$this->hauteur=$hauteur;		

		switch ($this->extension) {
	      	case 'jpg':
	            $this->source = imagecreatefromjpeg($this->chemin); 
	            $this->sampleImage();
	            imagejpeg($this->donnees[0],$this->donnees[1]);
	        	break;        
	        case 'jpeg':
	            $this->source = imagecreatefromjpeg($this->chemin); 
	            $this->sampleImage();
	            imagejpeg($this->donnees[0],$this->donnees[1]);
	       		break;
	        case 'png':
	            $this->source = imagecreatefrompng($this->chemin); 
	            $this->sampleImage();
	            imagepng($this->donnees[0],$this->donnees[1]);
	        	break;
	        case 'gif':
	            $this->source = imagecreatefromgif($this->chemin); 
	            $this->sampleImage();
	            imagegif($this->donnees[0],$this->donnees[1]);
	        	break; 		                     
		}   	
	}

	private function sampleImage(){

      	$largeur_destination=$this->largeur; //500
      	$hauteur_destination=$this->hauteur; //300

      	$largeur_source = imagesx($this->source);
      	$hauteur_source = imagesy($this->source);

      	$absPt_source=0;
      	$ordPt_source=0;

      	$ratio_ref=$largeur_destination/$hauteur_destination; //5/3 = 1.66 cad du 1 (h) sur 1.66 (l)
      	$ratio_orig = $largeur_source/$hauteur_source; 

      	//si ratios == : on ne fait rien

      	//si ratios != :
      	if($ratio_ref!=$ratio_orig){

  			//maj des largeur et hauteur de l'image source en fonction du ratio de ref:
  			if ($ratio_ref > $ratio_orig) {
  				$memo=$hauteur_source;
	         	$hauteur_source = round($largeur_source/$ratio_ref);
	        	//calcul du point de récupération de l'image source : besoin uniquement de calculer point ordonnée
  				$ordPt_source=round(($memo-$hauteur_source)/2);
	    	} 
	    	else {
	    		$memo=$largeur_source;
	        	$largeur_source = round($hauteur_source*$ratio_ref);
	        	//calcul du point de récupération de l'image source :  besoin uniquement de calculer point abscisse
  				$absPt_source=round(($memo-$largeur_source)/2);
	     	}

      	}

      	$destination = imagecreatetruecolor($largeur_destination, $hauteur_destination); // On crée la miniature vide
      	// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
        
      	// On crée la miniature
      	imagecopyresampled($destination, $this->source, 0, 0, $absPt_source, $ordPt_source,
      	$largeur_destination, $hauteur_destination, $largeur_source,
      	$hauteur_source);

      	// On enregistre la miniature sous le nom "mini_couchersoleil.jpg"
      	$location=$this->cheminMedium.$this->nomImage."_medium.".$this->extension; 
       
      	$this->donnees=[$destination, $location];
      	//--
      	$this->setMedium($this->nomImage."_medium.".$this->extension);
      	//--      
	}

    public function getMedium(){
    	return $this->medium;
    }

    public function setMedium($medium){
    	$this->medium=$medium;
    }

    //banner
    public function createBanner($nomImage){

		$file = $this->chemin;
		$newfile = "web/images/banner.".$this->extension; 
		
		
		if(empty($this->extension)){ //si ré-engistrement sans chargement d'une nouvelle image, il faut récupérer l'extension sans $this->extension
			//récupération de l'extension :
			$extensionRecup=$rest = substr($nomImage, -3);
			$file = $this->chemin.$nomImage;
			$newfile = $this->chemin.'banner.'.$extensionRecup;
		}			
		copy($file, $newfile);
    }
    //---------
}