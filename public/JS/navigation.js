
var path = window.location.href; // On récupère l'url

$('.menu a, #connexion a').each(function () {
    if (this.href === path) { // Si l'url correspond on ajoute la classe active
        $(this).addClass('active');
        let cCedille = "%C3%A7";
        let regexBoy = RegExp('gar' + cCedille + "ons");
        let regexGirl = RegExp("filles");

        if (regexBoy.test(path)) {
            $("#nav-team").addClass("active");
            $("#boyTeam").addClass("active");
        } else if (regexGirl.test(path)) {
            $("#nav-team").addClass("active");
            $("#girlTeam").addClass("active");
        }
    }
});

$(".menu-compte a").each(function () {
    if (this.href === path) {
        let regExpCompte = RegExp("home");
        let regExpUsers = RegExp("utilisateurs");
        let regExpArticles = RegExp("articles");
        let regExpEquipes = RegExp("equipes");
        if (regExpCompte.test(path)) {
            $("#compte1").addClass("activeCompte");
        } else if (regExpUsers.test(path)) {
            $("#compte2").addClass("activeCompte");
            $("#connexion :first-child").addClass("active");
        } else if (regExpArticles.test(path)) {
            $("#compte3").addClass("activeCompte");
            $("#connexion :first-child").addClass("active");
        } else if (regExpEquipes.test(path)) {
            $("#compte4").addClass("activeCompte");
            $("#connexion :first-child").addClass("active");
        }

    }

});




        function compteCssOver(compteEnfant, compteParent) {
            $(compteEnfant).mouseenter(function () {
                $(compteParent).css("background-color", "#dd650f");
            }).mouseleave(function () {
                $(compteParent).css("background-color", "#074592");
            });
        }

        compteCssOver("#compte1child", "#compte1");
        compteCssOver("#compte2child", "#compte2");
        compteCssOver("#compte3child", "#compte3");
        compteCssOver("#compte4child", "#compte4");


        function deleteConfirm(id) {
            $("#confirm" + id).css("display", "inline-block");
            $(".compteTeam, .typeTeam, #addTeam, h1, #blocEntrainement").css("opacity", 0.5).css("pointer-events", "none");
        }

        function cancelConfirm(id) {
            $("#confirm" + id).css("display", "none");
            $(".compteTeam, .typeTeam, #addTeam, h1, #blocEntrainement").css("opacity", 1).css("pointer-events", "auto");
        }







