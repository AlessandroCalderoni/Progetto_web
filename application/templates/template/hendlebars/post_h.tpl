<!-- <script type="text/x-handlebars-template"> -->
<div class="col-md-5 post">

  <div class="row">
    <!-- immagine profilo di chi ha scritto -->
    <div class="col-md-2">
      <img class="imm-profilo-post" src="./?env=image&op=user_pic&user_id={{user_id}}" alt="Profilo" />
    </div>


    <div class="col-md-10">

      <div class="row">
        <!-- nome, cognome utente e data -->
        <div class="col-md-12">
          <span class="post-user-name"><a href="./?env=user&op=profile&user={{user_id}}">{{user_name}}</a></span>
        </div>

        <div class="col-md-12">
          <span class="post-date">{{date_h_readable}}</span>
        </div>

      </div>

    </div>


  </div>

  <!-- testo del post -->
  <div class="row">
    <p class="col-md-12 post-text">{{text_content}}</p>
  </div>

  <div>
    <!-- ci può essere un'immagine per un post -->
    {{#if hasimage}}
      <img class="imm-post" src="./?env=image&op=post_pic&post_id={{post_id}}" alt="Immagine post"/>
    {{/if}}
  </div>

  <hr />

  <div class="row">
    <button class="btn btn-default btn-comment col-sm-offset-1 col-sm-4" role="button" data-postid="{{post_id}}">Vedi Commenti &raquo;</button>
    {{#if delete}}
      <button class="btn btn-danger col-sm-offset-2 col-sm-4 remove-post" data-id="{{post_id}}">Cancella post!</button>
    {{/if}}
  </div>





  <div class="container-fluid">

    <div class="row">
      <div class="box-comments hidden col-md-12">
      </div>
    </div>

    <div class="row">
      <form class="home-append-comment-botton">
        <textarea class="comment-textarea col-sm-8" placeholder="Lascia un commento..."></textarea>
        <input class="btn btn-default col-sm-3 col-md-offset-1 btn-new-comment" value="Commenta" data-id="{{post_id}}" name="follow-commenter" type="submit" />
      </form>
    </div>
  </div>

</div><!-- chiusura del blocco di post -->
<!-- </script> -->