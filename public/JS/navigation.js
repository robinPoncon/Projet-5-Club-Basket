var url = window.location.pathname; // On récupère l'url actuel
// create regexp to match current url pathname and remove trailing slash if present as it could collide with the link
// On crée une regex qui va matcher avec l'url et on supprime les slash qui pourraient faire des collisions
var urlRegExp = new RegExp(url.replace(/\/$/,'') + "$");

// now grab every link from the navigation
$('.menu a, #connexion a').each(function(){
    // and test its normalized href against the url pathname regexp
    if(urlRegExp.test(this.href.replace(/\/$/,''))){
        $(this).addClass('active');
    }
});

$("h1").click(function(){
    $.get('https://scorenco.com/widget/5bb7c95f45a3b523e8a6c9ce/', function( data ) {
        $('#result').html( data );
    }, 'json');
})


