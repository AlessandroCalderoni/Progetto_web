<!-- <div>
    {*foreach $arr_followed as $followed*}
        ID: {*$followed.id*} <br />
        Nome e cognome: {*$followed.completename*} <br />
        Email: {*$followed.email*} <br />
        ------------------------- <br />
    {*/foreach*}

    More: {*$more*} <br >
</div> -->

<div id="all-users" class="container-fluid">
    <div class="row">

        {foreach $error as $single}
            <div class="row">
                <div class="col-md-12 alert alert-danger">{$single}</div>
            </div>
        {/foreach}

        {foreach $positive_log as $single}
            <div class="row">
                <div class="col-md-12 alert alert-success">{$single}</div>
            </div>
        {/foreach}

        {foreach $arr_followed as $followed}
            <div class="col-md-4 user"  data-id="{$followed.id}">

                <div class="users">

                    <img class="profile-img" src="./?env=image&op=user_pic&user_id={$followed.id}" alt="Nessuna immagine" />
                    <p class="user-name"><a href="./?env=user&op=profile&user={$followed.id}">{$followed.completename}</a></p>
                    <p class="user-email">{$followed.email}</p>

                    {if $followed.followed eq true}
                        <button class="btn btn-danger unfollow" data-userid="{$followed.id}">Smetti di seguire</button>
                    {else}
                        <button class="btn btn-success follow" data-userid="{$followed.id}">Segui</button>
                    {/if}

                    {if $is_admin eq true}
                        <button class="btn btn-danger delete" data-userid="{$followed.id}">Elimina utente</button>
                        {if $followed.isadmin}
                            <button class="btn btn-danger demote" data-userid="{$followed.id}">Degrada</button>
                        {else}
                            <button class="btn btn-success promote" data-userid="{$followed.id}">Promuovi</button>
                        {/if}

                    {/if}


                </div>


            </div>
        {/foreach}

    </div>

</div>

<div class="container-fluid">
    {if $more eq true}
        <hr />
        <div class="row">
            <button id="more-user-btn" class="btn btn-success col-md-1 col-md-offset-10">Altri!</button>
        </div>
    {/if}
</div>