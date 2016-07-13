<!-- <div>
  id: {*$info_user.id*}<br>
  add: {*$info_user.address*}<br>
  Ti chiami: {*$info_user.name*} {*$info_user.surname*} <br />
  email: {*$info_user.email*} <br />
  admin: {*$info_user.isadmin*} <br />
  birth: {*$info_user.birth_date*}<br / >
</div> -->

{if $sidebar_self eq true}
  {$sidebar_msg = 'Sei loggato come '}
{else}
  {$sidebar_msg = 'Profilo pubblico di'}
{/if}

<div class="col-md-2 sidebar">

     <!-- immagine dell'utente -->
  <img id="user-image-sidebar" src="./?env=image&op=user_pic&user_id={$info_user.id}" alt="img non disponibile"/>

  <!-- dati di utente -->
  <div id="user-data">
    <span class="anag">{$sidebar_msg} <br /></span> <span id="ownername" class="anag-info">{$info_user.name} {$info_user.surname}</span>! <br />
    <span class="anag">Email:</span><br /><span class="anag-info">{$info_user.email}</span> <br />
    <span class="anag">Data nascita:</span> <span class="anag-info">{$info_user.birth_date}</span> <br />
    <span class="anag">Indirizzo:</span> <span class="anag-info"><br />{$info_user.address}</span> <br />
    {if $info_user.isadmin eq true}
      <p id="admin-advise">Admin!</p>
    {/if}

  </div>

  <hr class="sep" />

  <ul class="nav nav-sidebar">
    <li><a href="./?env=user&op=homepage">Home</a></li>
    <li><a href="./?env=user&op=profile&user=self">I miei post</a></li>
    <li><a href="./?env=user&op=myfollowed">Followed</a></li>
    <li><a href="./?env=user&op=viewtomodify">Modifica il mio profilo</a></li>
  </ul>


  <hr class="sep" />

  <ul class="nav nav-sidebar">
    <li><a href="./?env=user&op=logout">Logout</a></li>
  </ul>



</div>