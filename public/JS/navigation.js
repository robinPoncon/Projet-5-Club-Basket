
var path = window.location.href; // On récupère l'url

$('.menu a, #connexion a, #name a, .nameMobile a').each(function () {
    if (this.href === path) { // Si l'url correspond on ajoute la classe active
        $(this).addClass('active');
        let cCedille = "%C3%A7";
        let regexBoy = RegExp('gar' + cCedille + "ons");
        let regexGirl = RegExp("filles");
        let regexLoisir = RegExp("loisir");
        let regexClub = RegExp("club-BCM");


        if (regexBoy.test(path))
        {
            $("#nav-team").addClass("active");
            $("#boyTeam").addClass("active");
        }
        else if (regexGirl.test(path))
        {
            $("#nav-team").addClass("active");
            $("#girlTeam").addClass("active");
        }
        else if (regexLoisir.test(path))
        {
            $("#nav-team").addClass("active");
            $("#loisirTeam").addClass("active");
        }
        else if (regexClub.test(path))
        {
            $("#nav-club").addClass("active");
        }
    }
});

$(".menu-compte a").each(function () {
    if (this.href === path) {
        let regExpCompte = RegExp("profil");
        let regExpUsers = RegExp("utilisateurs");
        let regExpArticles = RegExp("articles");
        let regExpEquipes = RegExp("equipes");
        let regExpProduits = RegExp("produits");
        if (regExpCompte.test(path))
        {
            $("#compte1").addClass("activeCompte");
            $("#connexion :first-child").addClass("active");
        }
        else if (regExpArticles.test(path))
        {
            $("#compte2").addClass("activeCompte");
            $("#connexion :first-child").addClass("active");
        }
        else if (regExpEquipes.test(path))
        {
            $("#compte3").addClass("activeCompte");
            $("#connexion :first-child").addClass("active");
        }
        else if (regExpUsers.test(path))
        {
            $("#compte4").addClass("activeCompte");
            $("#connexion :first-child").addClass("active");
        }
        else if (regExpProduits.test(path))
        {
            $("#compte5").addClass("activeCompte");
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
compteCssOver("#compte5child", "#compte5");



$(".addCommentButton").click(function(){
    //console.log($(this).val());
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

$(".buttonInscription").click(function(){
    //console.log($(this).val());
    if($(this).html() === "Cliquer ici")
    {
        $(this).text("Annuler");
    }
    else
    {
        $(this).text("Cliquer ici");
    }

    $(".formInscription").toggle();
});







function deleteConfirm(id, text, dataText, routeSup, div) {
    //console.log(id, text, dataText, routeSup, div);
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
        " .addComment, .addCommentPost, .showComment h3, .commentEdit, .commentContent, .confirmSup," +
        ".profil, .profilPicture, .modifInfosProfil, .modifPhotoProfil, .modifMDP, thead, .userName," +
        ".userEmail, .userRole, .userFonction, .modifRole, .nameTeam, .modifTeam, #addMembre, #addSponsor," +
        ".ajoutBoutique, .legend, .textGestionProduit, .modifProduit ")
        .css("opacity", 0.5).css("pointer-events", "none");
}

function cancelConfirm(div) {
    $(div).text("");
    $(".typeTeam, #addTeam, h1, h2, .divInfosEntrainement, .divBoutonsEntrainement, #addPost, " +
        "#addConvoc, #selectTeam, #trierArticle, .divCategory, .divTitle, .modifPostDiv, .supPostDiv, .post," +
        " .addComment, .addCommentPost, .showComment h3, .commentEdit, .commentContent, .confirmSup," +
        ".profil, .profilPicture, .modifInfosProfil, .modifPhotoProfil, .modifMDP, thead, .userName," +
        ".userEmail, .userRole, .userFonction, .modifRole, .nameTeam, .modifTeam, #addMembre, #addSponsor," +
        ".ajoutBoutique, .legend, .textGestionProduit, .modifProduit ")
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
    let divAction = $("<div>", {class: "d-flex actionPost"});
    $(divAction).append(modifPostDiv);
    $(divAction).append(supPostDiv);
    $(divAction).append(confirmSupPost);

    let divPost = $("<div>", {class: "d-flex justify-content-around divPost"});

    $(divPost).append(divTitle);
    $(divPost).append(divCategory);
    $(divPost).append(divAction);

    $(".blocPost").append(divPost);
}





function htmlResponseAjaxConvoc(routeModif, routeSup, dayData, horaireData, addressData, idData)
{
    //Gestion affichage des convocations

    let jour = $("<p>", {
        class: "dayConvoc",
        text: dayData
    });

    //console.log(horaireData);
    let date = new Date(horaireData * 1000);
    let hours = date.getHours();
    let minutes = "0" + date.getMinutes();
    let formattedTime = hours + ':' + minutes.substr(-2);

    let heure = $("<p>", {
        class: "horaireConvoc",
        text: formattedTime
    });

    let adresse = $("<p>", {
        class: "addressConvoc",
        text: addressData
    });

    // Gestion bouton Modifier
    let urlModif = routeModif;
    urlModif = urlModif.replace("text", idData);

    let modifierConvoc = $("<a>", {
        attr: {"href": urlModif},
        class: "modifConvoc",
        text: "Modifier"
    });

    // Gestion bouton Suppression
    let supprimerConvoc = $("<button>", {
        class: "confirmSup",
        text: "Supprimer"
    });

    let confirmSupConvoc = $("<div>", {class: "confirmationSupConvoc"});

    $(supprimerConvoc).click(function () {
        deleteConfirm(idData, "Voulez-vous vraiment supprimer cet entraînement",
            dayData + " - " + formattedTime, routeSup,
            confirmSupConvoc);
    });

    //Finition affichage avec les blocs de div
    let divInfos = $("<div>", {class: "d-flex divInfosEntrainement"});
    $(divInfos).append(jour);
    $(divInfos).append(heure);
    $(divInfos).append(adresse);

    let divBoutons = $("<div>", {class: "d-flex divBoutonsEntrainement"});
    $(divBoutons).append(modifierConvoc);
    $(divBoutons).append(supprimerConvoc);

    let div = $("<div>", {class: "convocation"});
    $(div).append(divInfos);
    $(div).append(divBoutons);
    $(div).append(confirmSupConvoc);
    $(".convocations").append(div);
}

function htmlResponseAjaxPhoto(source, alt, parent)
{
    let img = $("<img>", {
        src: source,
        alt: alt
    });

    let divPicture = $("<div>", {class: "picture"});

    $(divPicture).append(img);
    $(parent).append(divPicture);
}

function htmlResponseAjaxTailleProduit(id, name, select)
{
    let option = $("<option>", {
        value: id,
        text: name
    });

    $(select).append(option);
}

function htmlResponseAjaxTailleColors(name, quantity)
{
    let taille = $("<option>", {
        text: name,
        val: quantity
    });

    $("#selectTaille").append(taille);

    let quantityTaille = $("#selectTaille option:selected").val();

    $(".quantityTaille").text(quantityTaille);

}

function showQuantityTaille(variable)
{
    $(".quantityTaille").text(variable);
}










// CSS MENU HAMBURGER

$(window).resize();

$(".hamburger").click(function(){
    $(this).css("display", "none");
    $(".close-hamburger").css("display", "block");

    if ($(window).width() >= 769)
    {
        $(".menu").css("display", "flex")
    }

    else
    {
        $(".menu").css("display", "block")
    }
});

$(".close-hamburger").click(function(){
    $(this).css("display", "none");
    $(".hamburger").css("display", "block");
    if ($(window).width() >= 769)
    {
        $(".menu").css("display", "flex")
    }

    else
    {
        $(".menu").css("display", "none")
    }
});

if ($(window).width() <= 768)
{
    $(".photoDiv .flex.row.divForm").attr("class", "flex-column divForm");
}

// Ajout plusieurs photos


    jQuery('.add-another-collection-widget').click(function (e) {
        var list = jQuery(jQuery(this).attr('data-list-selector'));
        // Try to find the counter of the list or use the length of the list
        var counter = list.data('widget-counter') || list.children().length;

        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data('widget-counter', counter);

        // create a new list element and add it to the list
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });

                // Aggrandir image

    $(".imageImportant").click(function(){
        $(".imageAggrandit").fadeIn();
    });

    $(".imageAggrandit").click(function(){
        $(this).fadeOut();
    });

// Afficher les images

    $(".afficherPhotoEquipe").click(function()
    {
        if($(this).html() === "Afficher les autres photos de l'équipe")
        {
            $(this).text("Cacher les autres photos");
        }
        else
        {
            $(this).text("Afficher les autres photos de l'équipe");
        }

        $(".blocAutrePhoto").toggle();
    });

    $(".afficherPhotoArticle").click(function()
    {
        if($(this).html() === "Afficher les autres photos de l'article")
        {
            $(this).text("Cacher les autres photos");
        }
        else
        {
            $(this).text("Afficher les autres photos de l'article");
        }

        $(".blocAutrePhotoArticle").toggle();
    });





    // Reduction opacité image avec bouton play et pause

$(".play, .pause, .diaporama").mouseenter(function(){
    $(".diaporama").css("opacity", 0.8);
});

$(".play, .pause, .diaporama").mouseleave(function(){
    $(".diaporama").css("opacity", 1);
});






    // Zoom image au survol

$(".imageImportanteProduit").click(function(){
   $(".imageImportanteFull").css("display", "inline");
});

$(".imageImportanteFull").click(function(){
    $(this).css("display", "none");
});







    // Diaporama 3D

var carousel = $(".carousel"),
    currdeg  = 0;

$(".chevron-droit").on("click", { d: "n" }, rotate);
$(".chevron-gauche").on("click", { d: "p" }, rotate);

function rotate(e){
    if(e.data.d === "n"){
        currdeg = currdeg - 60;
    }
    if(e.data.d === "p"){
        currdeg = currdeg + 60;
    }
    carousel.css({
        "-webkit-transform": "rotateY("+currdeg+"deg)",
        "-moz-transform": "rotateY("+currdeg+"deg)",
        "-o-transform": "rotateY("+currdeg+"deg)",
        "transform": "rotateY("+currdeg+"deg)"
    });
}



