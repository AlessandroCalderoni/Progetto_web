<div class="col-md-5 post" data-id="{$post.post_id}">

    <div class="row">
        <!-- immagine profilo di chi ha scritto -->
        <div class="col-md-2">
            <img class="imm-profilo-post" src="./?env=image&op=user_pic&user_id={$post.user_id}" alt="Profilo" />
        </div>


        <div class="col-md-10">

            <div class="row">
                <!-- nome, cognome utente e data -->
                <div class="col-md-12">
                    <span class="post-user-name"><a href="./?env=user&op=profile&user={$post.user_id}">{$post.user_name}</a></span>
                </div>

                <div class="col-md-12">
                    <span class="post-date">{$post.date_h_readable}</span>
                </div>

            </div>

        </div>


    </div>



    <!-- testo del post -->
    <div class="row">
        <p class="col-md-12 post-text">{$post.text_content}</p>
    </div>


    <div>
        <!-- ci può essere un'immagine per un post -->
        {if $post.hasimage eq TRUE}
            <img class="imm-post" src="./?env=image&op=post_pic&post_id={$post.post_id}" alt="Immagine post"/>
        {/if}
    </div>


    <hr />

    <div class="row">
      <button class="btn btn-default btn-comment col-sm-offset-1 col-sm-4" role="button" data-postid="{$post.post_id}">Vedi Commenti &raquo;</button>
        {if $post.delete eq true}
            <button class="btn btn-danger col-sm-offset-2 col-sm-4 remove-post" data-id="{$post.post_id}">Cancella post!</button>
        {/if}
    </div>



    <div class="container-fluid">

        <div class="row">
            <div class="box-comments hidden col-md-12">
            </div>
        </div>

        <div class="row">
          <form class="home-append-comment-botton">
              <textarea class="comment-textarea col-sm-8" placeholder="Lascia un commento..."></textarea>
              <input class="btn btn-default col-sm-3 col-md-offset-1 btn-new-comment" value="Commenta" data-id="{$post.post_id}" name="follow-commenter" type="submit" />
          </form>
        </div>
    </div>

</div><!-- chiusura del blocco di post -->