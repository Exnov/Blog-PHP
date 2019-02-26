<?php

namespace App\src\entities;

use App\src\DAO\ManagerLogos;
use App\src\DAO\ManagerFooter;

class View{
    
    private $file; //nom du fichier du template
    private $title;
    private $description;
    private $scriptTiny;

    public function render($template, $data = [])
    {
        $this->file = 'src/templates/'.$template.'.php';

        $content  = $this->renderFile($this->file, $data);

        //--logo et favicon
        $managerLogos=new ManagerLogos();
        $logos=$managerLogos->getLogos();
        //--footer
        $managerFooter=new ManagerFooter();
        $footer=$managerFooter->getData();

        $view = $this->renderFile('src/templates/base.php', [
            'logos'=>$logos,
            'title' => $this->title,
            'description'=>$this->description,
            'content' => $content,
            'scriptTiny'=>$this->scriptTiny,
            'footer'=>$footer
        ]);
        echo $view;
    }

    public function renderFile($file, $data)
    {
        if(file_exists($file)){
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        
        else {
            header('Location: 404'); 
        }
    }
}