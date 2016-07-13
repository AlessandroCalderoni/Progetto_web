<?php
/* Smarty version 3.1.29, created on 2016-07-05 17:13:07
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/post.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577bce838bf6f8_61141949',
  'file_dependency' => 
  array (
    '3f4394ea5aa8849a619f1719eaa9323bbf29f28c' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/post.tpl',
      1 => 1467731480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577bce838bf6f8_61141949 ($_smarty_tpl) {
?>
<div class="col-md-5 post" data-id="<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
">

    <div class="row">
        <!-- immagine profilo di chi ha scritto -->
        <div class="col-md-2">
            <img class="imm-profilo-post" src="./?env=image&op=user_pic&user_id=<?php echo $_smarty_tpl->tpl_vars['post']->value['user_id'];?>
" alt="Profilo" />
        </div>


        <div class="col-md-10">

            <div class="row">
                <!-- nome, cognome utente e data -->
                <div class="col-md-12">
                    <span class="post-user-name"><a href="./?env=user&op=profile&user=<?php echo $_smarty_tpl->tpl_vars['post']->value['user_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['post']->value['user_name'];?>
</a></span>
                </div>

                <div class="col-md-12">
                    <span class="post-date"><?php echo $_smarty_tpl->tpl_vars['post']->value['date_h_readable'];?>
</span>
                </div>

            </div>

        </div>


    </div>



    <!-- testo del post -->
    <div class="row">
        <p class="col-md-12 post-text"><?php echo $_smarty_tpl->tpl_vars['post']->value['text_content'];?>
</p>
    </div>


    <div>
        <!-- ci può essere un'immagine per un post -->
        <?php if ($_smarty_tpl->tpl_vars['post']->value['hasimage'] == TRUE) {?>
            <img class="imm-post" src="./?env=image&op=post_pic&post_id=<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
" alt="Immagine post"/>
        <?php }?>
    </div>


    <hr />

    <div class="row">
      <button class="btn btn-default btn-comment col-sm-offset-1 col-sm-4" role="button" data-postid="<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
">Vedi Commenti &raquo;</button>
        <?php if ($_smarty_tpl->tpl_vars['post']->value['delete'] == true) {?>
            <button class="btn btn-danger col-sm-offset-2 col-sm-4 remove-post" data-id="<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
">Cancella post!</button>
        <?php }?>
    </div>



    <div class="container-fluid">

        <div class="row">
            <div class="box-comments hidden col-md-12">
            </div>
        </div>

        <div class="row">
          <form class="home-append-comment-botton">
              <textarea class="comment-textarea col-sm-8" placeholder="Lascia un commento..."></textarea>
              <input class="btn btn-default col-sm-3 col-md-offset-1 btn-new-comment" value="Commenta" data-id="<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
" name="follow-commenter" type="submit" />
          </form>
        </div>
    </div>

</div><!-- chiusura del blocco di post --><?php }
}
