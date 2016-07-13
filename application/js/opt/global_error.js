/**
 * Created by gioacchinocastorio on 03/07/16.
 */


// variabile globale per la gestione grafica degli errori e positive log
hberror = Handlebars.compile('<div class="col-md-10 alert alert-danger center-block">{{error}}</div>');
hblog = Handlebars.compile('<div class="col-md-10 alert alert-success center-block">{{msg}}</div>');

// gestione di errori gravissimi
$(document).ajaxComplete(function (error, XHR) {


    ERRORS = {
        dbnr: 'db-not-recheable',
        unauth: 'action-forbidden-for-user'

    }
    // debugger;

    // $('body').append(hblog({msg: 'Ti invitiamo a riprovare più tardi'}));

    var msg_json = XHR.responseJSON;

    if(msg_json !== undefined && msg_json.fatal !== undefined) { // se è definita una risposta di errore fatale non altrimenti gestito

        // debugger;

        $body = $('body');
        $body.html(''); // cancella tutto il body

        $body.append(hberror({error: 'Scusaci, la tua richiesta non può essere processata'}))

        $body.append(hblog({log: 'Ti invitiamo a riprovare più tardi'}));

        // debugger;

    }

});

