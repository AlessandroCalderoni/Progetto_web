<?php
/* Smarty version 3.1.29, created on 2016-07-03 12:15:10
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/form_profile_modify.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5778e5ae2089b7_39796402',
  'file_dependency' => 
  array (
    '3190e16fa18d2e8ba79cda1439b21fef328fb62a' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/form_profile_modify.tpl',
      1 => 1467540571,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5778e5ae2089b7_39796402 ($_smarty_tpl) {
?>
<div class="container-fluid">

  <div id="mod-user-data" class="row container-fluid">

    <form class="col-md-12" id="modify-data" method="post" action="./?env=user&op=modifyme&option=data-user">


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


      <?php if (isset($_smarty_tpl->tpl_vars['old_val']->value)) {?>

        <?php $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_val']->value['name'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'name', 0);?>
        <?php $_smarty_tpl->tpl_vars['surname'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_val']->value['surname'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'surname', 0);?>
        <?php $_smarty_tpl->tpl_vars['email'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_val']->value['email'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'email', 0);?>
        <?php $_smarty_tpl->tpl_vars['addr'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_val']->value['address'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'addr', 0);?>
        <?php $_smarty_tpl->tpl_vars['addr'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_val']->value['address'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'addr', 0);?>
        <?php $_smarty_tpl->tpl_vars['birth'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_val']->value['birth_date'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'birth', 0);?>

      <?php }?>
      <!-- dati anagrafici -->
      <div class="row">
        <label class="col-sm-2 col-sm-offset-5">Modifica i tuoi dati</label> <br />
        <input class="col-sm-2 col-sm-offset-5 in-name-sur" type="text" placeholder="Nome" name="firstname" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" />
      </div>

      <div class="row">
        <input class="col-sm-2 col-sm-offset-5 in-name-sur" type="text" placeholder="Cognome" name="lastname" value="<?php echo $_smarty_tpl->tpl_vars['surname']->value;?>
" />
      </div>

      <div class="row">
        <input class="col-sm-2 col-sm-offset-5" type="text" placeholder="Indirizzo" name="address" value="<?php echo $_smarty_tpl->tpl_vars['addr']->value;?>
"/>
      </div>

      <div class="row">
        <input id="datepic" class="col-sm-2 col-sm-offset-5" type="text" placeholder="Data nascita" name="birthdate" data-val="<?php echo $_smarty_tpl->tpl_vars['birth']->value;?>
"/>
      </div>

      <div class="row">
        <input id="mail" class="col-sm-2 col-sm-offset-5" type="text" placeholder="Nuova email" name="email" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
"/>
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
        <label class="col-sm-2 col-sm-offset-5 text-info text-justify small">Modifica la tua immagine: il campo vuoto indica default</label> <br />
        <input class="col-sm-2 col-sm-offset-5" type="file" name="user_pic" />
      </div>


      <div class="row">
        <input type="submit" class="btn btn-success btn-sm col-sm-2 col-sm-offset-5" value="Modifica immagine" />
      </div>


    </form>

  </div>

  <hr />

  <div class="row">
    <button id="self-eliminate" class="btn btn-danger col-sm-1 col-sm-offset-10" data-userid="<?php echo $_smarty_tpl->tpl_vars['old_val']->value['id'];?>
" title="Cancellati dal social">Addio mondo!</button>
  </div>

</div><?php }
}
