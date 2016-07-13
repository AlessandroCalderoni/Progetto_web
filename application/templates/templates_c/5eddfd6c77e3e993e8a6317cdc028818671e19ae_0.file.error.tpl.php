<?php
/* Smarty version 3.1.29, created on 2016-07-01 18:31:48
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/error.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57769af474b674_60413387',
  'file_dependency' => 
  array (
    '5eddfd6c77e3e993e8a6317cdc028818671e19ae' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/error.tpl',
      1 => 1467390706,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57769af474b674_60413387 ($_smarty_tpl) {
?>
<div>
  <?php
$_from = $_smarty_tpl->tpl_vars['errors']->value;
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
  <div class="col-md-12 alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['single']->value;?>
</div>
  <?php
$_smarty_tpl->tpl_vars['single'] = $__foreach_single_0_saved_local_item;
}
if ($__foreach_single_0_saved_item) {
$_smarty_tpl->tpl_vars['single'] = $__foreach_single_0_saved_item;
}
?>

  <div class="col-md-12 alert alert-info">Ti preghiamo di tornare alla <a href="./">homepage</a></div>
</div>

<?php }
}
