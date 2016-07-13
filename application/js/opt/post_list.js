/**
 * Created by gioacchinocastorio on 28/06/16.
 */

$(document).ready(function () {

    // query url, parametri get
    var get_url = $.getUrlParameters();


    // ============================ download template ============================
    // download dei template di post e commenti
    var tpl_comment;
    var tpl_post;

    // nascondi il bottone di more post e comment
    var $btn_more_post = $('#more-post');
    var $btn_more_comment =  $('button.btn-comment');
    $btn_more_post.hide();
    $btn_more_comment.hide();

    // fetch post template
    var promise_post = $.get({
        url: './templates/template/hendlebars/post_h.tpl',
        dataType: 'html',
        success: (function () {
            return function (template) { // torna la stringa di template

                tpl_post = Handlebars.compile(template);

            }
        })()
    });

    // fetch comment template
    var promise_comment = $.get({
        url: './templates/template/hendlebars/comment_h.tpl',
        dataType: 'html',
        success: (function () {
            return function (template) { // torna la stringa di template

                tpl_comment = Handlebars.compile(template);

            }
        })()
    });

    // se le due promesse hanno successo, mostra i bottoni
    $.when(promise_post,promise_comment ).done(function () {
        $('#more-post').show();
        $('button.btn-comment').show();
    })
    // ============================ download template ============================


    // array dei post/commenti già scaricati
    var arr_downloaded_posts = $('.post').map(function() {
        return $(this).data('id');
    }).get();
    // debugger;

    // ==================== rimozione post ==========================
    // rimozione di post se si è admin o proprietari
    $(document).on('click', 'button.remove-post', function () {

        $this = $(this);

        if(confirm('Sei sicuro di voler cancellare?')) {

            $.ajax({
                data: {
                    ajax: true,
                    env: 'post',
                    op: 'remove',
                    toremove: $this.data('id')
                },
                success: function (data) {

                    if (data.response === 'success') {

                        // elimina il post dal DOM
                        $post = $this.closest('div.post');
                        $post.remove();
                    }

                    if (data.error !== undefined ) {

                        var $mainbox = $('.main');

                        if (data.error === ERRORS.unauth)
                            $mainbox.prepend(hberror({error: 'Non permesso a questo utente'}))
                        else
                            $mainbox.prepend(hberror({error: 'Il database non risponde'}))

                    }

                },
                error: function () {
                    $('.main').prepend(hberror({error: 'Errore interno del server'}))
                }
            })

        }

    } )
    // ==================== rimozione post ==========================



    // ==================== download commenti ==========================
    var number_of_retrieved_comments = {
        offset: 0,
        range: 4
    }

    // limiti di download per ogni bottone
    $btn_more_comment.prop('limit', number_of_retrieved_comments);

    // metti in ascolto i bottoni more comment
    $(document).on('click', 'button.btn-comment', function () {

        var $this = $(this);

        var post_id = $this.data('postid'); // id del post con commenti

        var limit = $this.prop('limit');

        // debugger;

        // raggiungi il box dei commenti del post
        $box_post = $this.closest('div.post');
        $box_comment = $box_post.find('div.box-comments');

        $.ajax({
            data: {
                env: 'post',
                op: 'getothercomments',
                parent: post_id,
                offset: limit.offset,
                range: limit.range
            },
            dataType: 'json',
            success: (function () {

                return function (data) {

                    // aggiorna il range da scaricare
                    limit.offset += limit.range;
                    $this.prop('limit', limit);

                    // se non ci sono più post da visualizzare
                    if (data.response === 'no-more' || data.length == 0) {
                        // togli event listner
                        delete data.response;
                        $this.hide(); // nascondi il bottone morecomment e togli event listner
                        $this.unbind('click');

                    }

                    if (data.length == 0) {
                        data.push({info: 'Nulla di nuovo!'});
                    }
                    // debugger

                    $.each(data, ( function() {
                        return function (index, value) {

                            // debugger;
                            if ($.inArray(parseInt(value.post_id), arr_downloaded_posts) === -1) {
                                // debugger;
                                arr_downloaded_posts.push(value.post_id);
                                $box_comment.append(tpl_comment(value));

                                //debugger;
                            }

                        }
                    })());



                }

            })(),
            error: function () {
                $('.main').prepend(hberror({error: 'Errore interno del server'}))
            },
            complete: function () {
                $box_comment.find('.alert').first().hide(); // nascondi box di caricamento
            }
        })

        $box_comment.removeClass('hidden'); // non nascondere il box commenti
        $box_comment.prepend(hblog({msg: 'Vediamo se ci sono nuovi commenti...'}))
        debugger;




    })
    // ==================== download commenti ==========================

    // ==================== download commenti post ==========================
    var number_of_retrieved_posts = {
        offset: 8,
        range: 4
    }

    // metti in ascolto il bottone di more post
    $btn_more_post.click((function() {
        return function () {

            var $this = $(this);

            var owner_name; // conterrà il nome dell'autore del post
            var id_owner = 'followed'; // di default cerchiamo i post dei followed

            if (get_url.op === 'profile' || get_url.op === 'addpost') { // se vero siamo in un profile
                owner_name = $("#ownername").html(); // prendi nome da sidebar
                if (get_url.op === 'addpost')
                    id_owner = 'self'; // id dell'user
                else
                    id_owner = get_url.user; // id dell'user
            }


            $.ajax({
                url: "./",
                data: {
                    ajax: true,
                    env: 'post',
                    op: 'getother',
                    owner: id_owner,
                    offset: number_of_retrieved_posts.offset,
                    range: number_of_retrieved_posts.range
                },
                dataType: 'json',
                success: (function() {
                    return function (data) {

                        number_of_retrieved_posts.offset += number_of_retrieved_posts.range; // aumenta l'offset


                        if (data.response === 'no-more' || data.length == 0) {
                            // togli event listner
                            delete data.response;
                            $this.hide(); // nascondi il bottone morepost e togli event listner
                            $this.unbind('click');

                        }


                        $.each(data, function (index, value) {
                            if (owner_name !== undefined) {
                                value.user_name = owner_name;
                            }


                            if ($.inArray(parseInt(value.post_id), arr_downloaded_posts) === -1) {
                                // debugger;
                                arr_downloaded_posts.push(value.post_id);


                                var newpost = tpl_post(value)

                                $('#post-list').append(newpost);
                                var $last_arrived = $('#post-list').children().last();

                                $last_arrived.find('.btn-comment').prop('limit', {
                                    offset: 0,
                                    range: 4
                                });

                                $last_arrived.find('.btn-new-comment').attr('disabled', true);



                            }


                        })

                    }
                })(),
                error: function (err) {
                    //debugger;
                },
                complete: function () {
                    //debugger;
                    $('#post-list').find('.alert').last().hide()
                }


            });

            $('#post-list').append(hblog({msg: 'Stiamo lavorando per te...'})) // mostra messaggio di attesa

            // debugger;
        }
    })());
    // ==================== download commenti post ==========================


    // =========================== invio nuovi commenti ===========================

    var $btn_new_comment = $('.btn-new-comment'); // tutti i bottoni di commento
    $btn_new_comment.attr('disabled', true); // disabilitati finquando non si scrive

    $('#post-list').on('keyup','.comment-textarea', function () {

        var $btn_new_comment = $(this).siblings('.btn-new-comment');

        if($(this).val().length !== 0)
            $btn_new_comment.attr('disabled', false);
        else
            $btn_new_comment.attr('disabled', true);

    });

    $('#post-list').on('click', '.btn-new-comment', function (e) {

        debugger;
        e.preventDefault();
        e.stopPropagation();

        var $this = $(this);

        debugger;

        $.ajax({

            url: './',
            data: {
                env: 'post',
                op: 'addcomment',
                text: $this.siblings('.comment-textarea').val(),
                post_id: $this.data('id')
            },
            dataType: 'json',

            success: (function () {
                return function (data) {

                    debugger
                    $this.siblings('.comment-textarea').val(''); // svuota textarea
                    $this.attr('disabled', true); // disabilita

                    $box_post = $this.closest('div.post');
                    $box_comment = $box_post.find('div.box-comments');
                    $box_comment.removeClass('hidden');

                    if (data.error === undefined) {
                        $box_comment.prepend(tpl_comment(data));
                        arr_downloaded_posts.push(data.post_id);
                    }
                    else {
                        $box_comment.prepend(tpl_comment({error: true})); // mostra errore
                    }




                }
            })(),
            error: ( function () {

                return function (err) {

                    debugger;

                    $box_post = $this.closest('div.post');
                    $box_comment = $box_post.find('div.box-comments');
                    $box_comment.removeClass('hidden');
                    $box_comment.prepend(tpl_comment({error: true})); // mostra errore


                }
            })()


        })

    });

    // =========================== invio nuovi commenti ===========================


});