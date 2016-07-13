/**
 * Created by gioacchinocastorio on 29/06/16.
 */

$(document).ready(function () {

    var btn_search = $("#search-submit");
    btn_search.attr('disabled', true); // appena carichi la pagina il bottone è disabilitato

    var textbox_search = $("#searchbox");

    // se c'è un testo nel form il bottone è abilitato
    textbox_search.keyup(function () {

        if($(this).val().length !== 0)
            btn_search.attr('disabled', false);
        else
            btn_search.attr('disabled',true);

    });



});