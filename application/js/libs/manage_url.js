/**
 * Created by gioacchinocastorio on 30/06/16.
 */

$.getUrlParameters = function () {

    var query = $(window.location).attr('search'); // parte query dell'url

    var getUrlVars = function (url) {
        var hash;
        var myJson = {};
        var hashes = url.slice(url.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            myJson[hash[0]] = hash[1];
        }

        delete myJson['']; // togli l'eventuale campo senza nome

        return myJson;
    }

    return getUrlVars(query);

}