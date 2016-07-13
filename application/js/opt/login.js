$(document).ready(function () {



    // è necessario controllare se sono abilitati i cookie
    (function () { // esegui una sola volta direttamente

        var $btn_login = $('#btn-login'); // bottone di login
        var $btn_registr = $('#btn-registration');  // bottone di logon


        // controllo cross-browser
        var isCookieAvail = function () {

            var avail = false;


            var token = 'token'; // token noto
            var name = 'coo'; // nome del cookie
            var result; // contenuto coockie richiesto al browser

            $.cookie(name, token); // set del cookie

            result = $.cookie(name); // richiedi a browser

            if ( result !== undefined & result === token ) {
                avail = true;
            }

            return avail;

        }

        // debugger;

        if (isCookieAvail() === false) {
            $('form.login').prepend(hberror({error: 'I tuo cookie sono disabilitati! Ti preghiamo di abilitarli e tornare a trovarci'}));
            $btn_login.attr('disabled', true);
            $btn_registr.attr('disabled', true);
        }

    })()

    // data --> datepic
    // email
    // password

    // fade in e fade out di formd di log e regitrazione
    var $form_reg = $('#reg');
    var $form_log = $('#log');

    var $log_btn = $('#log-b');
    var $reg_btn = $('#reg-b');

    // debugger;

    $reg_btn.click(function () {

        $form_log.hide( 'highlight', {}, 400);
        setTimeout(function () {
            $form_reg.fadeIn(400);
        }, 600)

    });

    $log_btn.click(function () {

        $form_reg.hide( 'highlight', {}, 400);
        setTimeout(function () {
            $form_log.fadeIn(400);
        }, 600)

    });

    $form_reg.hide();


    /*
    // ================================= campi registrazione =================================

    // interfaccia della data
    var $datepc = $('#datepic');
    $datepc.datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: new Date(1950, 1 - 1, 1)
    });
    $datepc.datepicker( "option", "dateFormat", "yy-mm-dd" );


    var regex_rules = {
        name_surname: /^[-a-zA-Z]+$/,
        email: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        password: /^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20})$/
    }

    // nome e cognome
    $('.in-name-sur').blur(function () {
        var $this = $(this);

        if (!($this.val().match(regex_rules.name_surname))) {
            $this.addClass('error-text');
        }
        else
            $this.removeClass('error-text');
    });


    // gestione password
    $('#first-passwd').blur(function () {
        var $this = $(this);

        // debugger;
        if (!($this.val().match(regex_rules.password))) {
            $this.addClass('error-text');
        }
        else {
            $this.removeClass('error-text');
        }
    });

    $('#mail').blur(function () {
        var $this = $(this);

        // debugger;
        if (!($this.val().match(regex_rules.email))) {
            $this.addClass('error-text');
        }
        else {
            $this.removeClass('error-text');
        }
    });


    $('#rep-passwd').blur(function () {
        var $this = $(this);


        if (!($this.val() == $('#first-passwd').val())) {
            // debugger;
            $this.addClass('error-text');
        }
        else
            $this.removeClass('error-text');
    });

    // ================================= campi registrazione =================================
    */




});