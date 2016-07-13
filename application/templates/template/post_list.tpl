<div id="main-post" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main"> <!-- contenitore di tutti i post -->


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


    <!-- nuovo post -->

    <div class="row">

        <div id="form-newpost" class="col-md-8 col-md-offset-1">

            <label>Inserisci un nuovo post sulla <em>TUA</em> bacheca</label>

            <form method="post" action="?env=post&op=addpost" enctype="multipart/form-data">

                <textarea id="new-post-text" placeholder="Nuovo post..." name="text"></textarea>

                <br />


                <div id="send" class="row">
                    <div class="row">
                        <p class="text-info col-md-3 col-md-offset-1">Immagine JPEG o PNG max 1Mb</p>
                    </div>

                    <div class="row">
                        <input class="col-md-7 col-md-offset-1" id="new-post-img" type="file" name="image"/>

                        <input class="btn btn-default col-md-3" type="submit" value="Posta!" />
                    </div>

                </div>


            </form>

        </div>

    </div>


    <div id="post-list" class="row">
    {foreach $post_list as $post}
        {$post}
    {/foreach}
    </div>

    {if $more eq true}
        <div class="row">
            <button id="more-post" class="btn btn-success">Altri post</button>
        </div>
    {/if}


 </div>
