<div class="container-fluid">

  <div id="mod-user-data" class="row container-fluid">

    <form class="col-md-12" id="modify-data" method="post" action="./?env=user&op=modifyme&option=data-user">


      {foreach $error as $single}
        <div class="row">
          <div class="col-md-12 alert alert-danger">{$single}</div>
        </div>
      {/foreach}


      {if isset($old_val)}

        {$name = $old_val.name}
        {$surname = $old_val.surname}
        {$email = $old_val.email}
        {$addr = $old_val.address}
        {$addr = $old_val.address}
        {$birth = $old_val.birth_date}

      {/if}
      <!-- dati anagrafici -->
      <div class="row">
        <label class="col-sm-2 col-sm-offset-5">Modifica i tuoi dati</label> <br />
        <input class="col-sm-2 col-sm-offset-5 in-name-sur" type="text" placeholder="Nome" name="firstname" value="{$name}" />
      </div>

      <div class="row">
        <input class="col-sm-2 col-sm-offset-5 in-name-sur" type="text" placeholder="Cognome" name="lastname" value="{$surname}" />
      </div>

      <div class="row">
        <input class="col-sm-2 col-sm-offset-5" type="text" placeholder="Indirizzo" name="address" value="{$addr}"/>
      </div>

      <div class="row">
        <input id="datepic" class="col-sm-2 col-sm-offset-5" type="text" placeholder="Data nascita" name="birthdate" data-val="{$birth}"/>
      </div>

      <div class="row">
        <input id="mail" class="col-sm-2 col-sm-offset-5" type="text" placeholder="Nuova email" name="email" value="{$email}"/>
      </div>

      <div class="row password">
        <label class="col-sm-2 col-sm-offset-5 text-info small">Reinserire la vecchia password o una nuova</label> <br />
        <input id="first-passwd" class="col-sm-1 col-sm-offset-5" type="password" placeholder="Password" name="password" />
        <input id="rep-passwd" class="col-sm-1" type="password" placeholder="Conferma" name="password-confirm"/>
      </div>

      <div class="row">
        <input type="submit" class="btn btn-success btn-sm col-sm-2 col-sm-offset-5" value="Modifica dati" />
      </div>

    </form>

  </div>

  <hr />

  <div class="row">

    <form id="modify-img" method="post" action="./?env=user&op=modifyme&option=img-user" enctype="multipart/form-data">

      <div class="row">
        <label class="col-sm-2 col-sm-offset-5 text-info text-justify small">Modifica la tua immagine [JPEG o PNG max 1Mb]</label> <br />
        <input class="col-sm-2 col-sm-offset-5" type="file" name="user_pic" />
      </div>


      <div class="row">
        <input type="submit" class="btn btn-success btn-sm col-sm-2 col-sm-offset-5" value="Modifica immagine" />
      </div>


    </form>

  </div>

  <hr />

  <div class="row">
    <button id="self-eliminate" class="btn btn-danger col-sm-1 col-sm-offset-10" data-userid="{$old_val.id}" title="Cancellati dal social">Addio mondo!</button>
  </div>

</div>