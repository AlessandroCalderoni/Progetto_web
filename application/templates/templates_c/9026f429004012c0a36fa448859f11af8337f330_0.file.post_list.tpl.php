<?php
/* Smarty version 3.1.29, created on 2016-07-08 18:24:22
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/post_list.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577fd3b6d5d5d9_88848023',
  'file_dependency' => 
  array (
    '9026f429004012c0a36fa448859f11af8337f330' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/post_list.tpl',
      1 => 1467994814,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577fd3b6d5d5d9_88848023 ($_smarty_tpl) {
?>
<div id="main-post" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main"> <!-- contenitore di tutti i post -->


    <?php
$_from = $_smarty_tpl->tpl_vars['error']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_single_0_saved_item = isset($_smarty_tpl->tpl_vars['single']) ? $_smarty_tpl->tpl_vars['single'] : false;
$_smarty_tpl->tpl_vars['single'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['single']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['single']->value) {
$_smarty_tpl->tpl_vars['single']->_loop = true;
$__foreach_single_0_saved_local_item = $_smarty_tpl->tpl_vars['single'];
?>
        <div class="row">
            <div class="col-md-12 alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['single']->value;?>
</div>
        </div>
    <?php
$_smarty_tpl->tpl_vars['single'] = $__foreach_single_0_saved_local_item;
}
if ($__foreach_single_0_saved_item) {
$_smarty_tpl->tpl_vars['single'] = $__foreach_single_0_saved_item;
}
?>

    <?php
$_from = $_smarty_tpl->tpl_vars['positive_log']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_single_1_saved_item = isset($_smarty_tpl->tpl_vars['single']) ? $_smarty_tpl->tpl_vars['single'] : false;
$_smarty_tpl->tpl_vars['single'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['single']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['single']->value) {
$_smarty_tpl->tpl_vars['single']->_loop = true;
$__foreach_single_1_saved_local_item = $_smarty_tpl->tpl_vars['single'];
?>
        <div class="row">
            <div class="col-md-12 alert alert-success"><?php echo $_smarty_tpl->tpl_vars['single']->value;?>
</div>
        </div>
    <?php
$_smarty_tpl->tpl_vars['single'] = $__foreach_single_1_saved_local_item;
}
if ($__foreach_single_1_saved_item) {
$_smarty_tpl->tpl_vars['single'] = $__foreach_single_1_saved_item;
}
?>


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
    <?php
$_from = $_smarty_tpl->tpl_vars['post_list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_post_2_saved_item = isset($_smarty_tpl->tpl_vars['post']) ? $_smarty_tpl->tpl_vars['post'] : false;
$_smarty_tpl->tpl_vars['post'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['post']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
$_smarty_tpl->tpl_vars['post']->_loop = true;
$__foreach_post_2_saved_local_item = $_smarty_tpl->tpl_vars['post'];
?>
        <?php echo $_smarty_tpl->tpl_vars['post']->value;?>

    <?php
$_smarty_tpl->tpl_vars['post'] = $__foreach_post_2_saved_local_item;
}
if ($__foreach_post_2_saved_item) {
$_smarty_tpl->tpl_vars['post'] = $__foreach_post_2_saved_item;
}
?>
    </div>

    <?php if ($_smarty_tpl->tpl_vars['more']->value == true) {?>
        <div class="row">
            <button id="more-post" class="btn btn-success">Altri post</button>
        </div>
    <?php }?>


 </div>
<?php }
}
