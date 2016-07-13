/**
 * Created by gioacchinocastorio on 03/07/16.
 */

$(document).ready(function () {

    // gestione eliminazione dell'utente
    $('#self-eliminate').click(function () {

        $this = $(this);

        debugger;


        if (confirm('Sei sicuro di volerci abbandonare?')) {

            $.get({

                url: './',
                dataType: 'json',
                data: {
                    ajax: true,
                    env: 'user',
                    op: 'remove',
                    toremove: $this.data('userid')
                },
                success: function (data) {

                    if (data.response === 'success') {

                        window.alert('Grazie per essere stato con noi');

                        $(location).attr('href', './?env=user&op=logout'); // logout

                    }

                    if (data.error === 'action-forbidden-for-user') {

                        //window.alert('Hai fatto la magagna!')
                        $('#mod-user-data').prepend(hberror({error: "Hai fatto la magagna"}));

                    }

                },
                error: function () {
                    $('#mod-user-data').prepend(hberror({error: "Qualcosa non ha funzionato nel server"}));
                }

            })

        }


    });

});