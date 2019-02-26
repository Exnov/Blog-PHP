$(function(){

  var language_url_ref='vendor/tinymce/js/fr_FR.js';
  var images_upload_url_ref='vendor/tinymce/postAcceptor.php';

  tinymce.init({
    selector: '#contenu',
    language_url : language_url_ref,
    images_upload_url: images_upload_url_ref,
    height: 300,
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'save table contextmenu directionality emoticons template paste textcolor'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
  });

});