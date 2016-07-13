/**
 * Created by gioacchinocastorio on 29/06/16.
 */

$(document).ready(function () {

    $.ajaxSetup({ cache: false }); // non cachare i risultati

    var $listuser = $('#all-users > .row'); // contenitore totale statico

    // listener dinamico bottoni "segui"
    $listuser.on('click', 'button.follow', function () {

        var $btn_follow = $(this);
        var id_user = $(this).data('userid');

        $.ajax({
            url: './',
            data: {
                env: 'user',
                op: 'follow',
                id: id_user,
                ajax: true
            },
            typedataType: 'json',
            success: (function() {
                return function (data) {


                    if (data.response === 'success') {

                        $btn_follow.switchClass('btn-success follow', 'btn-danger unfollow', 300, function () {
                            $btn_follow.html('Smetti di seguire');
                            $btn_follow.unbind('click');
                        })
                    }

                }
            })()


        });


    });

    // listener dinamico bottoni "smetti di seguire"
    $listuser.on('click', 'button.unfollow', function () {

        // debugger
        var $btn_follow = $(this);
        var id_user = $(this).data('userid');

        $.ajax({
            data: {
                env: 'user',
                op: 'unfollow',
                id: id_user,
                ajax: true
            },
            typedataType: 'json',
            success: (function() {
                return function (data) {

                    //debugger;

                    if (data.response === 'success') {

                        $btn_follow.switchClass('btn-danger unfollow', 'btn-success follow' , 300, function () {
                            $btn_follow.html('Segui');
                            $btn_follow.unbind('click');
                        })


                    }

                }
            })(),

        });

    });

    // listener dinamico bottoni "promuovi" admin
    $listuser.on('click', 'button.promote', function () {

        $this = $(this);

        if(confirm('Sei sicuro di voler rendere admin?')) {

            $.ajax({
                url: './',

                data: {
                    ajax: true,
                    env: 'user',
                    op: 'promote_demote',
                    candidate: $this.data('userid'),
                    dest: 1
                },
                dataType: 'json',
                success: (function () {
                    return function (data) {

                        // debugger;

                        if (data.response === 'success') {

                            //debugger;
                            $this.switchClass('btn-success promote', 'btn-danger demote', 300, function () {

                                $this.html('Degrada');

                            });


                        }

                    }
                })()
            })

        }

    });

    // listener dinamico bottoni "degrada" admin
    $listuser.on('click', 'button.demote', function () {

        var $this = $(this);

        if(confirm('Sei sicuro di voler rendere normal user?')) {

            $.ajax({
                url: './',
                data: {
                    ajax: true,
                    env: 'user',
                    op: 'promote_demote',
                    candidate: $this.data('userid'),
                    dest: 0
                },
                dataType: 'json',
                success: ( function () {
                    return function (data) {

                        // debugger;

                        if (data.response === 'success') {

                            //debugger;
                            $this.switchClass('btn-danger demote', 'btn-success promote', 300, function () {

                                $this.html('Promuovi');

                            });

                        }

                    }
                })()
            })

        }

    });

    // listener dinamico bottoni "cancella" utente
    $listuser.on('click', 'button.delete', function () {

        var $this = $(this);

        if(confirm('Sei sicuro di voler cancellare?')) {

            $.ajax({
                url: './',
                data: {
                    ajax: true,
                    env: 'user',
                    op: 'remove',
                    toremove: $this.data('userid')
                },
                success: (function () {
                    return function (data) {

                        if (data.response === 'success') {

                            // elimina il post dal DOM
                            $user = $this.closest('div.user');
                            $user.remove();

                        }

                    }
                })()
            })

        }

    });

    // gestione download altri profili ajax
    (function () {

        // array di id di utenti già scaricati
        var already_downloaded = $('.user').map(function() {
                    return $(this).data('id');
                    }).get();

        var operation = $.getUrlParameters().op; // scopri l'operazione richiesta

        var required_par = {
            offset: 6,
            range: 3
        }

        var tpl_user; // contenitore template
        var $btn_more = $('#more-user-btn'); // bottone per altri utenti
        $btn_more.attr('disabled', true); // disabilita preventivamente

        // download template

        $.ajax({
            url: './templates/template/hendlebars/user_h.tpl',
            dataType: 'html',
            success: (function () {
                    return function (template) { // torna la stringa di template
                        tpl_user = Handlebars.compile(template); // compila il template
                        $btn_more.attr('disabled', false); // sblocca bottone more

                    }
                })()
            })


        $btn_more.click(function () {

            var $this = $(this);

            var data_ajax = {
                ajax: true,
                env: 'user',
                op: '',
                offset: required_par.offset,
                range: required_par.range,
                search: ''


            }

            if (operation === 'search') {
                data_ajax.op = 'searchother';
                data_ajax.search = $.getUrlParameters().search;
            }
            else if (operation === 'myfollowed') {
                data_ajax.op = 'otherfollowed';
            }


            $.ajax({
                url: './',
                data: data_ajax,
                dataType: 'json',
                success: (function () {

                    debugger;
                    var user_admin = (!($('button.delete').length === 0)) ? true : false; // se ci sono tasti di delete è un utente admin
                    // debugger;

                    return function (data) {

                        required_par.offset += required_par.range; // incrementa l'offset

                        debugger;

                        if (!(data.length === 0)) // se la risposta non è vuota
                            $.each(data, (function() {
                                return function (index, value) {

                                    debugger;
                                    //debugger
                                    if (value === 'no-more' ) {
                                        $this.addClass('hidden');
                                    }
                                    else {
                                        var us_id = parseInt(value.id);
                                        if ($.inArray(us_id, already_downloaded) === -1) {
                                            debugger;
                                            already_downloaded.push(us_id); // aggiungi l'id al mucchio
                                            value.is_admin = user_admin; // indica se l'utente che ha fatto la richiesta è admin
                                            value.isadmin = Boolean(value.isadmin == 1);
                                            $listuser.append(tpl_user(value));
                                        }


                                    }

                                    // debugger

                                    $listuser.find('.alert').remove(); // rimuovi alert di notifica


                                }
                            })())
                        else {
                            $listuser.find('.alert').remove(); // rimuovi alert di notifica
                            $this.addClass('hidden');
                            $listuser.append(hblog({msg: 'Non ci sono altri risultati'}));

                        }



                    }

                })(),
                error: function () {

                    $listuser.prepend(hberror({error: "C'è qualche problema con il server, ripassa più tardi"}));
                    $this.addClass('disabled', true);
                }
            })

            $listuser.append(hblog({msg: 'Siamo alla ricerca di risultati!'}));



        })


    })()



    });