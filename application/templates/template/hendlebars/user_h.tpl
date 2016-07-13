<div class="col-md-4 user">
<div class="users">

  <img class="profile-img" src="./?env=image&op=user_pic&user_id={{id}}" alt="Nessuna immagine" />
  <p class="user-name"><a href="./?env=user&op=profile&user={{id}}">{{completename}}</a></p>
  <p class="user-email">{{email}}</p>

  {{#if followed }}
    <button class="btn btn-danger unfollow" data-userid="{{id}}">Smetti di seguire</button>
  {{else}}
    <button class="btn btn-success follow" data-userid="{{id}}">Segui</button>
  {{/if}}

  {{#if is_admin }}
    <button class="btn btn-danger delete" data-userid="{{id}}">Elimina utente</button>
    {{#if isadmin}}
      <button class="btn btn-danger demote" data-userid="{{id}}">Degrada</button>
    {{else}}
      <button class="btn btn-success promote" data-userid="{{id}}">Promuovi</button>
    {{/if}}

  {{/if}}


</div>
  </div>