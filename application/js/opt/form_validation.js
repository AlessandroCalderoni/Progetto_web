/**
 * Created by gioacchinocastorio on 03/07/16.
 */

$(document).ready(function () {

    // ================================= campi registrazione =================================

    // interfaccia della data
    var $datepc = $('#datepic');
    var old_var = $datepc.data('val');

    var par_date = {
        changeMonth: true,
        changeYear: true,
        minDate: new Date(1950, 1 - 1, 1)
        //defaultDate: new Date(old_var)
    };

    $datepc.datepicker(par_date);
    $datepc.datepicker( "option", "dateFormat", "yy-mm-dd" );
    $datepc.datepicker('setDate', old_var);


    var regex_rules = {
        name_surname: /^[-a-zA-Z ]+$/,
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

        $.get({
            url: './',
            data: {
                ajax: true,
                env: 'user',
                op: 'unique_mail',
                mail: $this.val()
            },
            success: (function () {

                return function (data) {

                    if (data.response === true) { // se l'email è gia in uso notifica con un messaggio
                        $this.addClass('error-text');
                        $this.val('Mail già usata');
                        // debugger;
                    }

                }


            })()
        })

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


})