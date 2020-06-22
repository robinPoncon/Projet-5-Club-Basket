
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


    /*$.getJSON("https://www.prevision-meteo.ch/services/json/meximieux", function(data){
        $("#nomVille").append("Météo - " + data.city_info.name);
        $("#tempMin").append(data.fcst_day_0.tmin + " °C");
        $("#tempMax").append(data.fcst_day_0.tmax + " °C");
        let dateGet = data.fcst_day_0.date;
        let dateFormated = dateGet.replace(".", "/").replace(".", "/");
        $("#day").append(data.fcst_day_0.day_long + " " + dateFormated + " = ");
        $("#condition").append(data.fcst_day_0.condition);
        $("#icone").attr("src", data.fcst_day_0.icon);
    });*/

    function sendAjaxController(id)
    {
        $.ajax({
            method: "POST",
            url: "http://localhost:8888/Projet-5-Club-Basket/public/admin/equipes/entrainement/data",
            data: {id: id},
            success: function(){

            }
        });
    }

    $("select").change(function(){
        let test = $("select :selected").val();
        sendAjaxController(test);
        getAjaxController();
        console.log(test);
    });

    function getAjaxController()
    {
        $.getJSON("http://localhost:8888/Projet-5-Club-Basket/public/admin/equipes/entrainement/data",
            function(data){
                console.log(data)
                $("#convocations").append(data.day);
        });
    }








    function compteCssOver(compteEnfant, compteParent)
    {
        $(compteEnfant).mouseenter(function(){
            $(compteParent).css("background-color", "#dd650f");
        }).mouseleave(function(){
            $(compteParent).css("background-color", "#074592");
        });
    }

    compteCssOver("#compte1child", "#compte1");
    compteCssOver("#compte2child", "#compte2");
    compteCssOver("#compte3child", "#compte3");
    compteCssOver("#compte4child", "#compte4");


    

    function deleteEquipe(id)
    {
        $("#confirm" + id).css("display", "inline-block");
        $(".compteTeam, .typeTeam, #addTeam, h1").css("opacity", 0.5).css("pointer-events", "none");
    }

    function cancelEquipe(id)
    {
        $("#confirm" + id).css("display", "none");
        $(".compteTeam, .typeTeam, #addTeam, h1").css("opacity", 1).css("pointer-events", "auto");
    }







