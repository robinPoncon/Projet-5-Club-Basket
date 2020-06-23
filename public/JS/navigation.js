
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

        function sendAjaxController(id) {
            $.ajax({
                method: "POST",
                url: "http://localhost:8888/Projet-5-Club-Basket/public/admin/equipes/entrainement/data",
                data: {id: id},
                success: function (responses) {

                    responses.forEach((datas) => {
                        console.log(datas);
                        let modifierConvoc = $("<a></a>");
                        $(modifierConvoc).attr("href", "http://localhost:8888/Projet-5-Club-Basket/public/admin/" +
                            "equipes/entrainement/" + datas.id);
                        $(modifierConvoc).text("Modifier");

                        let div = $("<div></div>");
                        $(div).addClass("convocation");

                        let jour = $("<p></p>");
                        $(jour).addClass("dayConvoc");
                        $(jour).text(datas.day);

                        let timeRecup = datas.horaire.timestamp;
                        console.log(timeRecup);
                        let date = new Date(timeRecup * 1000);
                        let hours = date.getHours() -1;
                        let minutes = "0" + date.getMinutes();
                        let formattedTime = hours + ':' + minutes.substr(-2);

                        let heure = $("<p></p>");
                        $(heure).addClass("horaireConvoc");
                        $(heure).text(formattedTime);

                        let adresse = $("<p></p>");
                        $(adresse).addClass("addressConvoc");
                        $(adresse).text(datas.address);

                        $(div).append(modifierConvoc);
                        $(div).append(jour);
                        $(div).append(heure);
                        $(div).append(adresse);
                        $(".convocations").append(div);
                        console.log(div);

                    });
                }
            });
        }

        $("select").change(function () {
            let test = $("select option:selected").val();
            console.log(test);
            $(".convocations").text("");
            sendAjaxController(test);
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


        function deleteEquipe(id) {
            $("#confirm" + id).css("display", "inline-block");
            $(".compteTeam, .typeTeam, #addTeam, h1").css("opacity", 0.5).css("pointer-events", "none");
        }

        function cancelEquipe(id) {
            $("#confirm" + id).css("display", "none");
            $(".compteTeam, .typeTeam, #addTeam, h1").css("opacity", 1).css("pointer-events", "auto");
        }







