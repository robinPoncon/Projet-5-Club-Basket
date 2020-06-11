
    var path = window.location.href; // On récupère l'url

    $('.menu a, #connexion a').each(function () {
        if (this.href === path) { // Si l'url correspond on ajoute la classe active
            $(this).addClass('active');
            var cCedille = "%C3%A7";
            var regexBoy = RegExp('gar' + cCedille + "ons");
            var regexGirl = RegExp("filles");

            if (regexBoy.test(path)) {
                $("#nav-team").addClass("active");
                $("#boyTeam").addClass("active");
            }
            else if (regexGirl.test(path)) {
                $("#nav-team").addClass("active");
                $("#girlTeam").addClass("active");
            }
        }
    });

    $(".menu-compte a").each(function() {
        if (this.href === path) {
            var regExpCompte = RegExp("home");
            var regExpUsers = RegExp("utilisateurs");
            var regExpArticles = RegExp("articles");
            var regExpEquipes = RegExp("equipes");
            console.log(path);
            console.log(this.href);
            if (regExpCompte.test(path)){
                $("#compte1").addClass("activeCompte");
            }
            else if(regExpUsers.test(path)){
                $("#compte2").addClass("activeCompte");
                $("#connexion :first-child").addClass("active");
            }
            else if(regExpArticles.test(path)){
                $("#compte3").addClass("activeCompte");
                $("#connexion :first-child").addClass("active");
            }
            else if(regExpEquipes.test(path)){
                $("#compte4").addClass("activeCompte");
                $("#connexion :first-child").addClass("active");
            }

        }

    });


    $.getJSON("https://www.prevision-meteo.ch/services/json/meximieux", function(data){
        $(".meteo").append(data.city_info.name);
    })

    $("#compte1child").mouseenter(function(){
        $("#compte1").css("background-color", "#dd650f");
    }).mouseleave(function(){
        $("#compte1").css("background-color", "#074592");
    });

    $("#compte2child").mouseenter(function(){
        $("#compte2").css("background-color", "#dd650f");
    }).mouseleave(function(){
        $("#compte2").css("background-color", "#074592");
    });

    $("#compte3child").mouseenter(function(){
        $("#compte3").css("background-color", "#dd650f");
    }).mouseleave(function(){
        $("#compte3").css("background-color", "#074592");
    });

    $("#compte4child").mouseenter(function(){
        $("#compte4").css("background-color", "#dd650f");
    }).mouseleave(function(){
        $("#compte4").css("background-color", "#074592");
    });

    

    function deleteEquipe(id)
    {
        $("#confirm" + id).css("display", "inline-block");
    console.log(id);
    }

    function cancelEquipe(id)
    {
        $("#confirm" + id).css("visibility", "hidden");

    }







