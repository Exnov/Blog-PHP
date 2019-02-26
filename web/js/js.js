$(function(){
//DEBUT CODE

    /* 
    *************************************************************************************
    -1- Définition d'objets  
    -2- Déclaration de variables et sélection d'éls dans le DOM
    -3- Gestion événementielle
    ************************************************************************************* 
    */

    /*
    **********************************************************************
    -1- Définition d'objets
    **********************************************************************
    */

    /*
    **********************************************************
    définition de l'objet Snack : affiche un message temporaire quand signalement, ou clique dans un bouton du mode édition
    **********************************************************
    */
    var Snack={

        init:function(frere,message){
            this.message=message;
            this.snackbar=frere.parentNode.querySelector(".snackbar");
            
            this.display();
        },

        display:function(){
            var objet=this;
            this.snackbar.classList.add("showsnack");
            this.snackbar.textContent=this.message;
            // After 2 seconds, remove the show class from DIV
            setTimeout(function(){ 
              objet.snackbar.className = objet.snackbar.className.replace("snackbar showsnack", "snackbar"); 
                }, 
                2000
            );    
        }
      
    };

    /*
    **********************************************************
    définition de l'objet Visual : gestion des images dans edition
    **********************************************************
    */
    var Visual={

        init:function(apercu,boutonBye,idIllu,idApercu){

            this.apercu=apercu;
            this.boutonBye=boutonBye;
            this.idIllu=idIllu;
            this.idApercu=idApercu;

        },

        boutonByeOn:function(){
            var objet=this;
            if(this.apercu.attributes.src.textContent.length>0){
                this.boutonBye.style.display='inline';
                this.boutonBye.addEventListener("click",function(e){
                    e.preventDefault();
                    $(objet.idIllu).val(""); 
                    $(objet.idApercu).attr("src",""); 
                     this.style.display="none"; 
                });
            }         
        },

        createVisual:function(file){
            var objet=this;
            var reader = new FileReader();
            reader.onload = function() {
                // Affichage de l'image
                objet.apercu.src = this.result;
                objet.boutonByeOn();
            };
            reader.readAsDataURL(file);
        },

        checkImage:function(){
            if($(this.idApercu).attr("src").length===0){
                this.boutonBye.style.display='none';
            }
        },

        checkPresence:function(){
            var action="";
            if($(this.idApercu).attr("src").length===0){
                action="retirer";               
            }     
            return action;   
        }

    };

    /*
    **********************************************************
    définition de l'objet Tablor : afficher les articles, commentaire en fonction du numéro de page
    **********************************************************
    */
    var Tablor={

        init:function(elt,dest,idbloc,donnees,division){ //elts pour la pagination
          
            this.elt=elt;
            this.dest=dest;
            this.idbloc=idbloc;
            this.donnees=donnees;
            this.division=division; 
            //pour deletor(): cf donnees
            this.classeBoutons;
            this.classeElt;
            this.slug;

            this.repere=1;
            this.lis=document.querySelectorAll("#listepagination li");
            this.totalPages=1;
            this.indexRef=1; //valeur à transmettre en POST, contiendra le numéro de la page à afficher
            this.debut=0;

            this.nDebut();
            this.pager();
            this.checkDeletor();    
        },

        nDebut:function(){
            if(this.lis.length==6){
              this.debut=1;
            }
        },
        
        pager:function(){ 

            var objet=this;
            //recupération du nombre total de pages
            if(document.getElementById("infoNpages")){
                this.totalPages=Number(document.querySelector("#infoNpages>span").textContent);
            }

            this.elt.forEach(function(page){

                objet.couleurGrise(objet.lis[objet.debut]);

                //listener----------------------------------------------------------------------
                page.addEventListener("click",function(e){
                    e.preventDefault();

                    //calcul de l'intervalle :
                    var a=(parseInt(this.textContent)-1)*objet.division;
                    //--------------------------------------------------------------          
                    //récupération de la valeur de l'elt coloré en vert si existant
                    //si gris ==> pas de < ou >
                    //si pas de gris ==> < oub> ==> voir valeur de indice
                    objet.lis.forEach(function(b){
                        var couleurLi=b.style.backgroundColor;
                        if(couleurLi=="rgb(225, 225, 225)"){ 
                            objet.repere=b.firstChild.textContent;
                        }
                        //remise à blanc de tous les <li>
                        objet.couleurBlanche(b);
                    });
                      
                    //--récupération de la valeur du a cliqué
                    var parent = e.target.parentNode; 
                    var nPage=e.target.textContent;
                  
                    if(nPage!='<' && nPage!='>'){
                        var index=Number(nPage);
                        objet.couleurGrise(parent); 
                        objet.indexRef=index;
                    }
                    else{
                        var n=0;                      
                        //récupération du 1er elt, on en déduit les 3 suivants :
                        var elt1=Number(objet.elt[1].innerText);
                        var elt4=elt1+3;
                        var valeurs=[];
                        valeurs.push(elt1); 
                        var n=1;

                        if(nPage=='>' && elt4<objet.totalPages){ 
                            elt1++;
                            elt4++;
                        }
                        if(nPage=='<' && elt1!=1){
                            elt1--;
                            elt4--;
                        }
                        while(elt1<=elt4){
                            valeurs.push(elt1);
                            elt1++;
                        }
                        while(n<=4){
                            objet.elt[n].innerText=valeurs[n];
                            n++;
                        }

                        //couleur grise et récupération du numéro de page du li en vert:
                        objet.indexRef=objet.couleurGriseChevron (objet.repere,valeurs,objet.lis);

                        a=(objet.indexRef-1)*objet.division;

                    } 

                    //requête ajax :
                    $.post( "index.php?route="+objet.dest, { aArticle : a, numero : objet.indexRef }) 
                    .done(function( data ) {

                        var obj = JSON.parse(data);

                        $("#"+objet.idbloc).replaceWith(obj.vueArticles); 
                        //---------------------
                        objet.checkDeletor();                      
                        //--------------------
                    });
                });
              
            }); //fin listener --------------------------------------------------------------
        },

        checkDeletor: function(){

            if(this.donnees.length>0){ 
                this.classeBoutons=this.donnees[0];
                this.classeElt=this.donnees[1];
                this.idTableau=this.donnees[2];
                this.slug=this.donnees[3];
                
                this.deletor(); //appel de deletor
            }
        },
        
        deletor:function(){ //fonction de suppression de billet et de commentaire : donnees contient classeBoutons,classeElt, idTableau
          
            var boutons=document.querySelectorAll("."+this.classeBoutons); 
            var objet=this;

            boutons.forEach(function(bouton){
                bouton.addEventListener('click',function(){

                    //récupération de l'id du billet
                    var url=bouton.parentNode.previousSibling.previousElementSibling.firstChild.href;

                    var recherche='article';
                    var check=url.search(recherche);
                    var plus=8;
                    if(check<0){
                        plus=12;
                        recherche='commentaire';
                    }

                    var a=url.search(recherche)+plus; 
                    var id=url.substring(a);

                    //affichage de la fenêtre de dialogue
                    $('#deleteContenu').click(function(){

                        //requête ajax :
                        $.post( "index.php?route=delete", { aArticle : id, nPage : objet.indexRef, elt : objet.slug}) 
                        .done(function( data ) {

                            var obj = JSON.parse(data);
                            var memoAncres = document.querySelectorAll("."+objet.classeElt); 

                            $("#"+objet.idTableau).replaceWith(obj.tableau); 
                            $('#blocPagination').replaceWith(obj.pagination); 

                            objet.elt = document.querySelectorAll("."+objet.classeElt); 
                            var nElts=objet.elt.length;
                            var majTotalPages=Number(obj.totalPages);

                            var n=1;
                            var q=5;
                             
                            var tabValeurs=[];
                            var newIndex;

                            if(nElts==6){
                                var k=0;
                                if(majTotalPages<Number(memoAncres[4].innerText)){ //si le nombre de page est < au chiffre de la dernière page, on baisse les chiffres de 1
                                    k=1;
                                }
                                //récupération et remplacement des valeurs des a
                                while(n<5){
                                    var x=Number(memoAncres[n].innerText)-k;
                                    objet.elt[n].innerText=x;
                                    if(x==objet.indexRef){
                                        newIndex=n;
                                    }
                                    n++;
                                }
                                if(newIndex==undefined){ //quand disparition de la dernière page à partir de celle-ci
                                    newIndex=4;
                                }                   
                            }

                            if(nElts<=4){
                                n=0;
                                while(n<nElts){
                                    var x=objet.elt[n].innerText;
                                    tabValeurs.push(x);
                                    if(x==objet.indexRef){
                                        newIndex=x-1;
                                    }
                                    n++;  
                                }
                                if(newIndex==undefined){
                                    newIndex=tabValeurs[tabValeurs.length-2];
                                }
                            }

                            //commmun
                            objet.debut=Number(newIndex);

                            //récupération de la page où on est, pour la couleur verte
                            objet.lis=document.querySelectorAll("#listepagination li");
                             
                            objet.pager(objet.elt,objet.classeElt,objet.idTableau,objet.donnees,objet.division); 
                            objet.deletor(); 
                        });
                    });

                });
            });     
        },

        couleurGrise:function(elt){
            elt.style.backgroundColor="#e1e1e1";
        },

        couleurBlanche:function(elt){
            elt.style.backgroundColor="white";
        },

        couleurGriseChevron:function(repere,valeurs,lis) { //colore le numéro de page lorsque clique sur chevron, et renvoie le nouveau numéro de page
            repere=Number(repere);
            var indexRef;
            var liGris;
                        
            //cf >
            if(repere<valeurs[1]){ 
                liGris=lis[1];
                indexRef=repere+1;
            }
            //cf <
            else if(repere>valeurs[4]){ 
                liGris=lis[4];
                indexRef=repere-1;
            }
            //cf > et <
            else{
                //on colore le parent du li précédemment selectionné cad de repere
                //récupération de l'index du li a colorer en gris
                 a=1;
                var indexLi;
                while(a<=4){
                     if(valeurs[a]==repere){
                           indexLi=a;
                      }
                   a++;
                }
                liGris=lis[indexLi];
                indexRef=repere;
             }               
            //on colore le li en gris
            this.couleurGrise(liGris);
            //on renvoie la valeur de la page en gris
            return indexRef;                       
          } 
    
    };


    /*
    **********************************************************************
    -2- Déclaration de variables et sélection d'élts dans le DOM
    **********************************************************************
    */

    //edition d'un article 
    var input=document.querySelector("#illustration");
    var image=document.querySelector("#imgpreview");
    var boutonByePreview=document.querySelector("#byePreview");

    //edition page A propos 
    var inputAvatar=document.querySelector("#avatar");
    var imageAvatar=document.querySelector("#imgPreviewAvatar");
    var boutonByePreviewAvatar=document.querySelector("#byePreviewAvatar");

    //edition logo et favicon
    //logo
    var inputLogo=document.querySelector("#logo");
    var imageLogo=document.querySelector("#previewLogoImg");
    var boutonByePreviewLogo=document.querySelector("#byePreviewLogo");
    //favicon
    var inputFavicon=document.querySelector("#favicon");
    var imageFavicon=document.querySelector("#previewFaviconImg");
    var boutonByePreviewFavicon=document.querySelector("#byePreviewFavicon");

    //ecriture de commentaire par le visiteur
    var formComment = document.querySelector("#formComment");

    //signalement commentaire par le visiteur 
    var signaler = document.querySelectorAll(".signaler");

    //edition des commentaires
    var formEditComment = document.querySelector("#formEditComment");

    //edition profil part 1
    var formEditProfil = document.querySelector("#formEditProfil");

    //edition profil part 2
    var formEditMtp = document.querySelector("#formEditMtp");

    //edition page Accueil
    var formEditBanner = document.querySelector("#formEditBanner");

    //edition footer
    var formEditFooter = document.querySelector("#formEditFooter");

    //pagination
    //pagination page Accueil
    var pagination = document.querySelectorAll(".pagination");
    //pagination edition articles
    var paginationadmin = document.querySelectorAll(".paginationadmin")
    //pagination edition commentaires    
    var paginationComments = document.querySelectorAll(".paginationcommentaires");  


    /*
    **********************************************************************
    -3- Gestion événementielle
    **********************************************************************
    */

    /*
    *******************************
    edition d'un article  
    *******************************
    */    
    if(input){ //si input non null

        //création objet
        var visualisator1=Object.create(Visual); 
        visualisator1.init(image,boutonByePreview,"#illustration","#imgpreview");

        input.addEventListener("change",function(){ 
            var file = this.files[0];
            visualisator1.createVisual(file);
        });     

        visualisator1.boutonByeOn();
        
        //pour requête ajax avec form
        var form = document.querySelector("#formEdit");
        // Gestion de la soumission du formulaire
        if(form){
          form.addEventListener("submit", function (e) {
              e.preventDefault();

              // Récupération des champs du formulaire dans l'objet FormData
              var data = new FormData(form);
              var action=document.activeElement.name; 

              data.append("action", action); //valeur du name des inputs de type submit

              if(action==='supprimer'){
                  $('#deleteContenu').click(function(){
                      // Envoi des données du formulaire au serveur
                      ajaxPost("index.php?route=save", data, function () { 
                          window.location = ("gestionnaire-articles");                
                      }); 
                  });
              }
              else{
                  //retrait ou pas d'image :
                  var actionImage=visualisator1.checkPresence();
                  data.append("actionImage", actionImage);

                  //on retire le focus sur le bouton cliqué
                  document.activeElement.blur();

                  // Envoi des données du formulaire au serveur
                  ajaxPost("index.php?route=save", data, function () { 
                      //création objet pour message
                      var snackbar=Object.create(Snack); 
                      snackbar.init(form,"Modification sur article enregistrée");                 
                  }); 
              }
          }); 
        }
    }

    /*
    *******************************
    edition page A propos 
    *******************************
    */
    if(inputAvatar){ //si input non null

         //création objet
        var visualisator2=Object.create(Visual); 
        visualisator2.init(imageAvatar,boutonByePreviewAvatar,"#avatar","#imgPreviewAvatar");
        
        inputAvatar.addEventListener("change",function(){ 
            var file = this.files[0];
            visualisator2.createVisual(file);    
        });     
        
        visualisator2.boutonByeOn();
        visualisator2.checkImage(); //on vérifie au chargement de la page s'il y a une image à afficher, sinon on retire le bouton 'retirer'

        //pour requête ajax avec form
        var form = document.querySelector("#formEditAbout");
        // Gestion de la soumission du formulaire
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            // Récupération des champs du formulaire dans l'objet FormData
            var data = new FormData(form);
            var action=visualisator2.checkPresence();

            data.append("action", action);

            //on retire le focus sur le bouton cliqué
            document.activeElement.blur();

            // Envoi des données du formulaire au serveur
            // La fonction callback est ici vide
            ajaxPost("index.php?route=saveabout", data, function (donnees) { 
                //création objet pour message
                var snackbar=Object.create(Snack); 
                snackbar.init(form,"Page 'A propos' mise à jour");            
            }); 
        }); 
    }

    /*
    *******************************
    edition logo et favicon
    *******************************
    */
    if(inputLogo){ //si input non null

        //création objet
        var visualisator3=Object.create(Visual); 
        visualisator3.init(imageLogo,boutonByePreviewLogo,"#logo","#previewLogoImg");

        //logo
        inputLogo.addEventListener("change",function(){ 
            var file = this.files[0];
            visualisator3.createVisual(file);      
        });   

        visualisator3.boutonByeOn();
        visualisator3.checkImage(); //on vérifie au chargement de la page s'il y a une image à afficher, sinon on retire le bouton 'retirer'

        //favicon
        //création objet
        var visualisator4=Object.create(Visual); 
        visualisator4.init(imageFavicon,boutonByePreviewFavicon,"#favicon","#previewFaviconImg");

        inputFavicon.addEventListener("change",function(){ 
            var file = this.files[0];
            visualisator4.createVisual(file); 
        });     
 
        visualisator4.boutonByeOn();
        visualisator4.checkImage(); //on vérifie au chargement de la page s'il y a une image à afficher, sinon on retire le bouton 'retirer'

        //pour requête ajax avec form
        var form = document.querySelector("#formEditLogos");
        // Gestion de la soumission du formulaire
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            // Récupération des champs du formulaire dans l'objet FormData
            var data = new FormData(form);
            var actionLogo=visualisator3.checkPresence();
            var actionFavicon=visualisator4.checkPresence();

            data.append("actionLogo", actionLogo);
            data.append("actionFavicon", actionFavicon);

            //on retire le focus sur le bouton cliqué
            document.activeElement.blur();

            // Envoi des données du formulaire au serveur
            ajaxPost("index.php?route=savelogo", data, function (donnees) { 

                function getWay(elt){
                    var way="";
                    var chemin="web/images/"; 
                    if(elt.length>0){
                        way=chemin+elt;
                    }
                    return way;
                }

                var obj = JSON.parse(donnees);
                var installLogo=getWay(obj['logo']);
                var installFavicon=getWay(obj['favicon']);

                $("#nav-logo").attr("src",installLogo); //base.php
                $("#favicon-header").attr("href",installFavicon);

                //création objet pour message
                var snackbar=Object.create(Snack); 
                snackbar.init(form,"Modification(s) enregistrée(s)");
            }); 
        }); 
    }

    /*
    *******************************
    ecriture de commentaire par le visiteur 
    *******************************
    */
    if(formComment){ //si form non null
        formComment.addEventListener("submit", function (e) {
            e.preventDefault();

            // Récupération des champs du formulaire dans l'objet FormData
            var data = new FormData(formComment);

            // Envoi des données du formulaire au serveur
            ajaxPost("index.php?route=savecomment", data, function () { 
                window.location.reload(); //recharge les commentaires sur la page, permet de maj l'affichage des commentaires
            }); 
        });      
    }

  /*
  *******************************
  signalement commentaire par le visiteur :
  gestion du click sur le bouton 'signaler'
  *******************************
  */ 
  if(signaler){
    signaler.forEach(function(bouton){
        bouton.addEventListener("click",function(e){

          var idCommentaire=bouton.getAttribute('value');

          $.post( "index.php?route=signalement", { id : idCommentaire })
            .done(function( data ) {

                //création objet pour message
                var snackbar=Object.create(Snack); 
                snackbar.init(bouton,"Commentaire signalé");

            });        
        });
    });
  }

  /*
  *******************************
  edition des commentaires
  *******************************
  */ 
  if(formEditComment){ //si form non null, cad si sur single.php
    formEditComment.addEventListener("submit", function (e) {
          e.preventDefault();

          var action=document.activeElement.name; 
          // Récupération des champs du formulaire dans l'objet FormData
          var data = new FormData(formEditComment);

          data.append("action", action); //valeur du name des inputs de type submit

          //on retire le focus sur le bouton cliqué
          document.activeElement.blur();

          // Envoi des données du formulaire au serveur
          ajaxPost("index.php?route=updatecomment", data, function () { 

              var message="Commentaire enregistré";
              //mise à jour du texte du bouton 'publier/retirer'
              if(action!=='enregistrer'){

                  if(action==='retirer'){
                      $('#pubcomment').attr('value','publier').attr('name','publier');
                      message="Commentaire retiré";
                  }
                  else{
                      $('#pubcomment').attr('value','retirer').attr('name','retirer');
                      message="Commentaire publié";
                  }
              }

              //création objet pour message
              var snackbar=Object.create(Snack); 
              snackbar.init(formEditComment,message);
            
          }); 
      });      
    }  

    /*
    *******************************
    edition profil part 1 :
    *******************************
    */
    if(formEditProfil){ //si form non null
      formEditProfil.addEventListener("submit", function (e) {
            e.preventDefault();

            // Récupération des champs du formulaire dans l'objet FormData
            var data = new FormData(formEditProfil);

            //on retire le focus sur le bouton cliqué
            document.activeElement.blur();

            // Envoi des données du formulaire au serveur
            ajaxPost("index.php?route=saveprofil", data, function (donnees) { 

                var obj = JSON.parse(donnees);
                $('#labelprofil').text(obj["login"]);

                //création objet pour message
                var snackbar=Object.create(Snack); 
                snackbar.init(formEditProfil,"Profil mis à jour");
              
            }); 
      });      
    }

    /*
    *******************************
    edition profil part 2 :
    *******************************
    */
    if(formEditMtp){ //si form non null
      formEditMtp.addEventListener("submit", function (e) {
            e.preventDefault();

            // Récupération des champs du formulaire dans l'objet FormData
            var data = new FormData(formEditMtp);

            //on retire le focus sur le bouton cliqué
            document.activeElement.blur();

            // Envoi des données du formulaire au serveur
            ajaxPost("index.php?route=savemtp", data, function (donnees) { 
             
                var obj = JSON.parse(donnees);

                //on vide les champs
                $("#mtp").val("");
                $("#mtpnew").val("");
                $("#mtpnew2").val("");

                 //création objet pour message
                var snackbar=Object.create(Snack); 
                snackbar.init(formEditMtp,"Mot de passe modifié");             
              
            }); 
      });      
    }

    /*
    *******************************
    edition page Accueil :
    *******************************
    */
    if(formEditBanner){ //si form non null
        formEditBanner.addEventListener("submit", function (e) {
              e.preventDefault();

              // Récupération des champs du formulaire dans l'objet FormData
              var data = new FormData(formEditBanner);

              //on retire le focus sur le bouton cliqué
              document.activeElement.blur();

              // Envoi des données du formulaire au serveur
              ajaxPost("index.php?route=savebanner", data, function (donnees) { 

                  var obj = JSON.parse(donnees);
                  if(obj["banner"].length>0){
                      $('#previewbanner img').attr("src","web/images/"+obj["banner"]); 
                  }
                  
                  //création objet pour message
                  var snackbar=Object.create(Snack); 
                  snackbar.init(formEditBanner,"Page accueil mise à jour");
                
              }); 
        });      
    }

    /*
    *******************************
    edition footer :
    *******************************
    */
    if(formEditFooter){ //si form non null
      formEditFooter.addEventListener("submit", function (e) {
            e.preventDefault();

            // Récupération des champs du formulaire dans l'objet FormData
            var data = new FormData(formEditFooter);

            // Envoi des données du formulaire au serveur
            ajaxPost("index.php?route=savefooter", data, function (donnees) { 

                var obj = JSON.parse(donnees);

                $("footer").html(obj["contenu"]);

                //création objet pour message
                var snackbar=Object.create(Snack); 
                snackbar.init(formEditFooter,"Footer modifié");               
            }); 
      });      
    }

    /*
    *******************************
    Création des objets de paginations
    *******************************
    */
    //création des objets
    var tablor1=Object.create(Tablor); 
    var tablor2=Object.create(Tablor); 
    var tablor3=Object.create(Tablor); 
    
    //pagination page Accueil
    if(pagination){
        tablor1.init(pagination,'pagination','blocBillets',[],6); 
    }
    //pagination edition articles
    if(paginationadmin){
        var donnees=['supprimer','paginationadmin','tableauBillets','article']; 
        tablor2.init(paginationadmin,'paginationadmin','tableauBillets',donnees,6); 
    }

    //pagination edition commentaires    
    if(paginationComments){
        var donnees=['supprimercomment','paginationcommentaires','tableauCommentaires','commentaire'];
        tablor3.init(paginationComments,'paginationcommentaires','tableauCommentaires',donnees,10);
    }
     
 //FIN CODE
});