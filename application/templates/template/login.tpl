<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="wrap">
                <p class="form-title">
                    The nerd Zone
                </p>
                <form class="login" id="log" method="post" action="./?env=user&op=login">

                    {if isset($old_login_val.email)}
                        {$mail = $old_login_val.email}
                    {else}
                        {$mail = ''}
                    {/if}

                    <input type="text" placeholder="Email" value="{$mail}" name="email" />


                    <input type="password" placeholder="Password" name="passwd"/>
                    <input id='btn-login' type="submit" value="Log-in" class="btn btn-success btn-sm" />
                    <label id="reg-b">Registrati</label>
                </form>

                <form class="login" id="reg" method="post" action="./?env=user&op=register" enctype="multipart/form-data">

                    {if isset($old_register_val)}
                        {$name = $old_register_val.firstname}
                        {$surname = $old_register_val.lastname}
                        {$email = $old_register_val.email}
                        {$addr = $old_register_val.addr}

                    {else}
                        {$name = ''}
                        {$surname = ''}
                        {$email = ''}
                        {$addr = ''}

                    {/if}

                    <!-- dati anagrafici -->
                    <input class="in-name-sur" type="text" placeholder="Nome" name="firstname" value="{$name}" />
                    <input class="in-name-sur" type="text" placeholder="Cognome" name="lastname" value="{$surname}" />
                    <input type="text" placeholder="Indirizzo" name="address" value="{$addr}"/>

                    <input id="datepic" type="text" placeholder="Data nascita" name="birthdate"/>

                    <!-- dati utente -->
                    <input id="mail" type="text" placeholder="Nuova email" name="email" value="{$email}"/>

                    <label class="text-primary text-justify">La password deve contenere da 6 a 20 caratteri tra cui un carattere speciale, una lettera maiuscola e una cifra</label>
                    <input id="first-passwd" type="password" placeholder="Nuova password" name="password" />
                    <input id="rep-passwd" type="password" placeholder="Conferma" name="password-confirm"/>


                    <label class="text-muted  text-justify">Immagine di profilo JPEG o PNG (non obbligatoria)</label>
                    <input type="file" name="user_pic" />

                    <input id='btn-registration' type="submit" value="Log-on" class="btn btn-success btn-sm" />
                    <label id="log-b">Login</label>
                </form>

            </div>

        </div>
    </div>


    {if isset($error) || isset($postive_log)}

        <div class="row alerts col-md-3">

            <div class="col-md-12">
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
            </div>

        </div>

    {/if}

    <div class="posted-by">Copyright Gligegneri tutti i diritti sono riservati</div>
</div>

