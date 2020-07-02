
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



$(".addCommentButton").click(function(){
    console.log($(this).val());
    if($(this).html() === "Cliquer ici")
    {
        $(this).text("Annuler");
    }
    else
    {
        $(this).text("Cliquer ici");
    }

    $(".addComment").toggle();
});







function deleteConfirm(id, text, dataText, routeSup, div) {
    console.log(id, text, dataText, routeSup, div);
    let divSup = $("<div>", {
        class: "confirm",
        id: "confirm" + id
    });

    let textSup = $("<p>", {
        text: text + ' "' + dataText + '" ?'
    });

    let urlSupPost = routeSup;
    urlSupPost = urlSupPost.replace("text", id);

    let yesSup = $("<a>", {
        class: "yesSup",
        text: "Oui",
        attr: {"href": urlSupPost}
    });

    let noSup = $("<button>", {
        class: "noSup",
        text: "Non"
    });

    $(noSup).click(function(){
        cancelConfirm(div);
    });

    $(divSup).append(textSup);
    $(divSup).append(yesSup);
    $(divSup).append(noSup);

    $(div).append(divSup);

    $(".typeTeam, #addTeam, h1, h2, .divInfosEntrainement, .divBoutonsEntrainement, #addPost, " +
        "#addConvoc, #selectTeam, #trierArticle, .divCategory, .divTitle, .modifPostDiv, .supPostDiv, .post," +
        " .addComment, .addCommentPost, .showComment h3, .commentEdit, .commentContent, .confirmSup ")
        .css("opacity", 0.5).css("pointer-events", "none");
}

function cancelConfirm(div) {
    $(div).text("");
    $(".typeTeam, #addTeam, h1, h2, .divInfosEntrainement, .divBoutonsEntrainement, #addPost, " +
        "#addConvoc, #selectTeam, #trierArticle, .divCategory, .divTitle, .modifPostDiv, .supPostDiv")
        .css("opacity", 1).css("pointer-events", "auto");
}






function htmlResponseAjax(routeShow, routeModif, routeSup, slugData, titleData, categoryData, idData)
{
    // Gestion lien article

    let urlPost = routeShow;
    urlPost = urlPost.replace("text", slugData);

    let lienPost = $("<a>", {
        class: "postLink",
        attr: {href: urlPost},
        text: titleData
    });

    let divTitle = $("<div>", {class: "divTitle"});
    $(divTitle).append(lienPost);

    // Gestion category
    let divCate = $("<div>", {class: "d-flex"});
    let divCategory = $("<div>", {class: "d-flex divCategory"});

    $categorys = categoryData;
    $categorys.forEach((category) => {
        let categoryPost = $("<p>", {
            text: category.title
        });
        $(divCate).append(categoryPost);
        $(divCategory).append(divCate);
    });

    // Gestion bouton modifier
    let urlModifPost = routeModif;
    urlModifPost = urlModifPost.replace("text", slugData);

    let lienModifier = $("<a>", {
        class: "modifPost",
        attr: {href: urlModifPost},
        text: "Modifier"
    });

    let modifPostDiv = $("<div>", {class: "d-flex flex-column modifPostDiv"})
    $(modifPostDiv).append(lienModifier);

    // Gestion bouton supprimer

    let lienSupprimer = $("<button>", {
        class: "confirmSup",
        text: "Supprimer"
    });

    let supPostDiv = $("<div>", {class: "supPostDiv"});
    $(supPostDiv).append(lienSupprimer);

    // Gestion confirmation suppression

    let confirmSupPost = $("<div>", {class: "confirmationSupPost"});

    $(lienSupprimer).click(function(){
        deleteConfirm(idData, "Voulez-vous vraiment supprimer cet article", titleData, routeSup, confirmSupPost);
    });

    // Gestion ajout des div
    let divPost = $("<div>", {class: "d-flex justify-content-around divPost"});
    $(divPost).append(divTitle);
    $(divPost).append(divCategory);
    $(divPost).append(modifPostDiv);
    $(divPost).append(supPostDiv);
    $(divPost).append(confirmSupPost);

    $(".blocPost").append(divPost);
}





