
var path = window.location.href; // On récupère l'url

console.log(path);
$('.menu a, #connexion a').each(function() {
    if (this.href === path) { // Si l'url correspond on ajoute la classe active
        $(this).addClass('active');
        var cCedille = "%C3%A7";
        var regexBoy = RegExp('gar' + cCedille + "ons");
        var regexGirl = RegExp("filles");
        if(regexBoy.test(path))
        {
            $("#nav-team").addClass("active");
            $("#boyTeam").addClass("active");
        }
        else if(regexGirl.test(path))
        {
            $("#nav-team").addClass("active");
            $("#girlTeam").addClass("active");
        }
    }
});



