"use strict";

var ville = [
    "Gare de Calais-Ville", "Gare de Dunkerque", "Gare de Lille-Europe", "Gare Lille Flandre", "Gare de Valentiennes",
    "Gare de Arras", "Gare de Amiens", "Gare de Rouen Rive Droite", "Gare du Havre", "Gare de Caen", "Gare de evreux-Normandie",
    "Gare du Mans", "Gare de Rennes", "Gare de Brest", "Gare de Lorient", "Gare de Anger-Saint-Laud", "Gare de Nantes",
    "Gare SNCF de Tours", "Gare de Strasbourg-Ville", "Gare de Metz-Ville", "Gare SNCF de Nancy", "Gare de Reims", "Gare de Mulhouse-Ville",
    "Gare de Montbéliard", "Gare de Besançon-Viotte", "Gare de Dijon-Ville", "Gare de Nevers", "Gare SNCF de Bourges", "Gare de Orléans",
    "Gare de Poitiers", "Gare de Limoges-Bénédictins", "Gare de Angoulême", "Gare de Brive-la-Gaillarde", "Gare de Bordeaux-Saint-Jean",
    "Gare Montauban-Ville-Bourbon", "Gare de Toulouse-Matabiau", "Gare de Pau", "Gare de Bayonne", "Gare de Perpignan", "Gare de Clermont-Ferrand",
    "Gare de Lyon Part-Dieu", "Gare de Lyon-Perrache", "Gare Saint-Paul", "Gare de Saint-Etienne-Châteaucreux", "Gare de Chambery-Charles-les-Eaux",
    "Gare de Grenoble", "Gare de Valence-Ville", "Gare de Nice-Ville", "Gare de Nîmes", "Gare de Toulon", "Gare de Marseille Saint-Charles", "Gare de Montpellier Saint-Roch",
    "Gare de Lyon", "Gare Montparnasse", "Gare du Nord", "Gare Saint-Lazare", "Gare de l'Est", "Gare de Bercy", "Gare de Austerlitz"
];

function getTime(first, second) {
    var stringArrayOne = first.split(':');
    var stringArrayTwo = second.split(':');
    var arrayOne = [], arrayTwo = [];
    $.each(stringArrayOne, function (i, value) {
        arrayOne.push(parseInt(value))
    });

    $.each(stringArrayTwo, function (i, value) {
        arrayTwo.push(parseInt(value))
    });

    var minutes = arrayTwo[1] - arrayOne[1];
    var heures = arrayTwo[0] - arrayOne[0];

    return heures + " h " + Math.abs(minutes)
}

$(document).ready(function () {


    /**
     * FORMULAIRE RECHERCHE -- DEBUT
     */

    $("#departure, #arrival").autocomplete({
        minLength: 2,
        source: ville
    });

    $('#form-search').submit(function (event) {

        reset();

        var departure = $("#departure");
        var arrival = $("#arrival");
        var date = $("#dateDepart").val();
        var timeDep = $("#time-depart").val();
        var timeArr = $("#time-arrival").val();

        console.log("depart : " + timeDep + " arri " + timeArr);


        if (!isEmpty()) {
            $(this).before(function () {
                return "<div class='error'>Remplissez tout les champs</div>";
            });
            return false;
        } else {
            if (!isDate($("#date").val())) {
                $('#date').before(function () {
                    return "<div class='error'>" + this.value + " n\'est pas une date valide</div>";
                });
                return false;
            }
        }

        if ($.inArray(departure.val(), ville) == -1 || $.inArray(arrival.val(), ville) == -1) {
            departure.before(function () {
                return "<div class='error'>Une des villes saisie est incorrect</div>";
            });
            return false;
        }


        $("#hide-search").hide('slow', function () {

            $.ajax({
                url: Routing.generate('get_voyage', {
                    departure: departure.val(),
                    arrival: arrival.val(),
                    timeDepart: timeDep,
                    timeArrival: timeArr
                }),
                beforeSend: function () {
                    $(".loading").removeClass("hidden");
                },
                error: function () {
                    $("#form-search").before("<div class='error'>Une erreur est survenue</div>");
                },
                success: function (data) {

                    if (data.length == 0) {
                        $(".loading").addClass('hidden');
                        $("#aucun-voyage").removeClass('hidden').text("Aucun voyage trouvé");
                        return false;
                    }

                    $(".loading").addClass("hidden").empty();

                    $(".itineraire").html("<h3 class='titre-voyage'>" + departure.val() + " <span class='unicode'> ➔ </span> " + arrival.val() + "</h3>" +
                        "<button id='edit-search'>Modifier votre recherche</button>");

                    $.each(data, function (i, item) {


                        $("#voyages").append("<div class='single-voyages'>" +

                            "<div class='detail'>" +

                            "<span class='departure-detail'>" + item.HeureDepart + "</span>" +

                            "<span class='unicode'>➔</span>" +

                            "<span class='arrive-detail'>" + item.HeureArrivee + "</span>" +

                            "<div class='estimate-time'>" +

                            "<span class='time'>" + getTime(item.HeureDepart, item.HeureArrivee) + "</span>" +

                            "<span class='jauge'> </span>" +

                            "</div>" +

                            "</div>" +

                            "<div class='price'>" +

                            "<div class='details-details'>" + item.Prix + " €</div> " +

                            "</div>" +

                            "<div class='hidden' data-train='" + item.TypeTrain + "' data-type='" + item.TrajetId + "'>Best</div> " +

                            "</div>");


                    });

                    $(".detail-voayage").removeClass("hidden").show('slow');

                }
            })
        });


        event.preventDefault();

    });

    /*
     $("#departure").autocomplete({
     source : gares,
     select : function(event, ui){
     $(this).val(ui.item.NomGare);
     return false;
     }
     });*/

    /*
     $.ajax({
     url: "https://microsoft-apiapp8e4c01653956482183a83076bcb4e9f9.azurewebsites.net/api/gare",
     method: "GET",
     success: function(data){
     console.log(data)
     }
     });

     */


    /**
     * FORMULAIRE RECHERCHE -- FIN
     */

    /**
     * FONCTION ANNEXE - DEBUT
     */

    $(document).on("click", "#edit-search", function () {
        //3$(".detail-voyage").remove();

        $("#hide-search").show('slow');
        $(this).remove();
        $(".detail-voyage").addClass("hidden");

        sessionStorage.removeItem("id_voyage");

    });


    $(document).on("click", ".single-voyages", function (e) {

        if ($("#hide-search").is(':visible')) {
            e.preventDefault();
            return false;
        }

        var id = $(".hidden", this).data("type");

        localStorage.setItem('id_voyage', id);

        $(".detail-voyage").removeClass("hidden").addClass("active").html("<h2 style='color:#999;text-align:left'>Détail du trajet</h2>" +

            "<div class='info-part'> " +

            "<h4>Voyages</h4> " +

            "<div class='sub-part'> " +

            "<p><span class='hour'>" + $(this).find('.departure-detail').text() + "</span>" + $("#departure").val() + "</p> " +

            "<p><span class='hour'>" + $(this).find('.arrive-detail').text() + "</span>" + $('#arrival').val() + "</p> " +

            "<p><span class='hour'>Type de train</span>" + $(".hidden", this).data("train") + "</p> " +

            "</div> " +

            "</div> " +

            " <div class='info-part'> " +

            "<h4>Train</h4> " +

            "<div class='sub-part'> " +

            "<p><span class='hour'>Catégorie</span> Transillien</p> " +

            "</div> " +

            "</div> " +

            "<div class='info-part'> " +

            "<h4>Temps de trajet  " + $(this).find(".time").text() + " </h4> " +

            "<a id='add_checkout' class='price button' href='http://commander.io/checkout/" + parseInt(id) + "'>Ajouter au panier </a>" +

            "</div>");

    });

    $(document).on("click", "#add_checkout", function () {

        var id_voyage = localStorage.getItem('id_voyage');

        window.location.href = 'http://commander.io/checkout/' + id_voyage;

    });

    $('#pay').click(function (e) {

        var id_voyage = localStorage.getItem('id_voyage');

        $.ajax({
            url: Routing.generate('get_voyage_ajax', { id: parseInt(id_voyage)}),
            success: function (data) {

                console.log('id recuperé est : ' + data)
            }
        });

        console.log('click nigga ... avec ' + id_voyage);

    });

    if ($("#checkout").is(":visible")) {

        var id_voyage = localStorage.getItem('id_voyage');

        if (id_voyage) {

        } else {

            $(".whith-user").addClass('hidden');
            $(".no-user").removeClass('hidden');

        }

    }


    $('[data-popup-open]').on('click', function (e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

        e.preventDefault();
    });

    //----- CLOSE
    $('[data-popup-close]').on('click', function (e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

        e.preventDefault();

    });


});


function duration(seconde) {

    var minute = seconde / 60;

    return minute;


}


function formatHour(navitiaDate) {
    return navitiaDate.substr(9).match(/.{2}/g).join(':');
}

/**
 * VALIDATION -- DEBUT
 */


function reset() {
    $(".error").remove();
    $(".itineraire").html("");
    $("#voyages").empty();
    $("#accroche").addClass("hidden");

}
function isEmpty() {
    var flag = 1;

    $(".required").each(function () {
        if ("" == $(this).val())
            flag++;
    });

    return flag == 1;

}

if ($(".information").is(":visible")) {

    $.ajax({
        url: Routing.generate('front_getuser'),
        beforeSend: function () {
            $('.loading').html('Chargement ...')
        },
        success: function (data) {

            $('.information-user').append(
                "<h3>Informations</h3>" +
                "<p> Nom : " + data.nom + "</p>" +
                "<p> Prenom : " + data.nom + "</p>" +
                "<p> Email : " + data.email + "</p>"
            );

            $('.loading').empty();
        }
    });


}


function isDate(txtDate) {

    var currVal = txtDate;
    var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
    var dtArray = currVal.match(rxDatePattern); // is format OK?

    if (dtArray == null)
        return false;

    var dtMonth = dtArray[1];
    var dtDay = dtArray[3];
    var dtYear = dtArray[5];

    if (dtMonth < 1 || dtMonth > 12)
        return false;
    else if (dtDay < 1 || dtDay > 31)
        return false;
    else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)
        return false;
    else if (dtMonth == 2) {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay > 29 || (dtDay == 29 && !isleap))
            return false;
    }
    return true;
}

/**
 * VALIDATION -- FIN
 */
