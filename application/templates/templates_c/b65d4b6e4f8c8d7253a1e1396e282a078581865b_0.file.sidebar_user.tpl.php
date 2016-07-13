<?php
/* Smarty version 3.1.29, created on 2016-07-05 17:38:42
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/sidebar_user.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577bd482b794f4_08441658',
  'file_dependency' => 
  array (
    'b65d4b6e4f8c8d7253a1e1396e282a078581865b' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/sidebar_user.tpl',
      1 => 1467733119,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577bd482b794f4_08441658 ($_smarty_tpl) {
?>
<!-- <div>
  id: <br>
  add: <br>
  Ti chiami:   <br />
  email:  <br />
  admin:  <br />
  birth: <br / >
</div> -->

<?php if ($_smarty_tpl->tpl_vars['sidebar_self']->value == true) {?>
  <?php $_smarty_tpl->tpl_vars['sidebar_msg'] = new Smarty_Variable('Sei loggato come ', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'sidebar_msg', 0);
} else { ?>
  <?php $_smarty_tpl->tpl_vars['sidebar_msg'] = new Smarty_Variable('Profilo pubblico di', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'sidebar_msg', 0);
}?>

<div class="col-md-2 sidebar">

     <!-- immagine dell'utente -->
  <img id="user-image-sidebar" src="./?env=image&op=user_pic&user_id=<?php echo $_smarty_tpl->tpl_vars['info_user']->value['id'];?>
" alt="img non disponibile"/>

  <!-- dati di utente -->
  <div id="user-data">
    <span class="anag"><?php echo $_smarty_tpl->tpl_vars['sidebar_msg']->value;?>
 <br /></span> <span id="ownername" class="anag-info"><?php echo $_smarty_tpl->tpl_vars['info_user']->value['name'];?>
 <?php echo $_smarty_tpl->tpl_vars['info_user']->value['surname'];?>
</span>! <br />
    <span class="anag">Email:</span><br /><span class="anag-info"><?php echo $_smarty_tpl->tpl_vars['info_user']->value['email'];?>
</span> <br />
    <span class="anag">Data nascita:</span> <span class="anag-info"><?php echo $_smarty_tpl->tpl_vars['info_user']->value['birth_date'];?>
</span> <br />
    <span class="anag">Indirizzo:</span> <span class="anag-info"><br /><?php echo $_smarty_tpl->tpl_vars['info_user']->value['address'];?>
</span> <br />
    <?php if ($_smarty_tpl->tpl_vars['info_user']->value['isadmin'] == true) {?>
      <p id="admin-advise">Admin!</p>
    <?php }?>

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



</div><?php }
}
