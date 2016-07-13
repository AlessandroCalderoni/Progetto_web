<?php
/* Smarty version 3.1.29, created on 2016-07-05 12:42:18
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/list_user.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577b8f0a4c9091_02160651',
  'file_dependency' => 
  array (
    '9d1db5b84d2228b6d48009801244683a9eef7c01' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/list_user.tpl',
      1 => 1467715332,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577b8f0a4c9091_02160651 ($_smarty_tpl) {
?>
<!-- <div>
    
        ID:  <br />
        Nome e cognome:  <br />
        Email:  <br />
        ------------------------- <br />
    

    More:  <br >
</div> -->

<div id="all-users" class="container-fluid">
    <div class="row">

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

        <?php
$_from = $_smarty_tpl->tpl_vars['arr_followed']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_followed_2_saved_item = isset($_smarty_tpl->tpl_vars['followed']) ? $_smarty_tpl->tpl_vars['followed'] : false;
$_smarty_tpl->tpl_vars['followed'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['followed']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['followed']->value) {
$_smarty_tpl->tpl_vars['followed']->_loop = true;
$__foreach_followed_2_saved_local_item = $_smarty_tpl->tpl_vars['followed'];
?>
            <div class="col-md-4 user"  data-id="<?php echo $_smarty_tpl->tpl_vars['followed']->value['id'];?>
">

                <div class="users">

                    <img class="profile-img" src="./?env=image&op=user_pic&user_id=<?php echo $_smarty_tpl->tpl_vars['followed']->value['id'];?>
" alt="Nessuna immagine" />
                    <p class="user-name"><a href="./?env=user&op=profile&user=<?php echo $_smarty_tpl->tpl_vars['followed']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['followed']->value['completename'];?>
</a></p>
                    <p class="user-email"><?php echo $_smarty_tpl->tpl_vars['followed']->value['email'];?>
</p>

                    <?php if ($_smarty_tpl->tpl_vars['followed']->value['followed'] == true) {?>
                        <button class="btn btn-danger unfollow" data-userid="<?php echo $_smarty_tpl->tpl_vars['followed']->value['id'];?>
">Smetti di seguire</button>
                    <?php } else { ?>
                        <button class="btn btn-success follow" data-userid="<?php echo $_smarty_tpl->tpl_vars['followed']->value['id'];?>
">Segui</button>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['is_admin']->value == true) {?>
                        <button class="btn btn-danger delete" data-userid="<?php echo $_smarty_tpl->tpl_vars['followed']->value['id'];?>
">Elimina utente</button>
                        <?php if ($_smarty_tpl->tpl_vars['followed']->value['isadmin']) {?>
                            <button class="btn btn-danger demote" data-userid="<?php echo $_smarty_tpl->tpl_vars['followed']->value['id'];?>
">Degrada</button>
                        <?php } else { ?>
                            <button class="btn btn-success promote" data-userid="<?php echo $_smarty_tpl->tpl_vars['followed']->value['id'];?>
">Promuovi</button>
                        <?php }?>

                    <?php }?>


                </div>


            </div>
        <?php
$_smarty_tpl->tpl_vars['followed'] = $__foreach_followed_2_saved_local_item;
}
if ($__foreach_followed_2_saved_item) {
$_smarty_tpl->tpl_vars['followed'] = $__foreach_followed_2_saved_item;
}
?>

    </div>

</div>

<div class="container-fluid">
    <?php if ($_smarty_tpl->tpl_vars['more']->value == true) {?>
        <hr />
        <div class="row">
            <button id="more-user-btn" class="btn btn-success col-md-1 col-md-offset-10">Altri!</button>
        </div>
    <?php }?>
</div><?php }
}
