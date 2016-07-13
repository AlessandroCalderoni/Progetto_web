<?php
/* Smarty version 3.1.29, created on 2016-06-21 17:30:15
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/list_followed.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57695d871167a2_76344206',
  'file_dependency' => 
  array (
    '91eb728cf7301f3aabf69fb08299239191f377f2' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/list_followed.tpl',
      1 => 1466523004,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57695d871167a2_76344206 ($_smarty_tpl) {
?>
<div>
    <?php
$_from = $_smarty_tpl->tpl_vars['arr_followed']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_followed_0_saved_item = isset($_smarty_tpl->tpl_vars['followed']) ? $_smarty_tpl->tpl_vars['followed'] : false;
$_smarty_tpl->tpl_vars['followed'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['followed']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['followed']->value) {
$_smarty_tpl->tpl_vars['followed']->_loop = true;
$__foreach_followed_0_saved_local_item = $_smarty_tpl->tpl_vars['followed'];
?>
        ID: <?php echo $_smarty_tpl->tpl_vars['followed']->value['ID'];?>
 <br />
        Nome: <?php echo $_smarty_tpl->tpl_vars['followed']->value['Name'];?>
 <br />
        Cognome: <?php echo $_smarty_tpl->tpl_vars['followed']->value['Surname'];?>
 <br />
        Email: <?php echo $_smarty_tpl->tpl_vars['followed']->value['Email'];?>
 <br />
        ------------------------- <br />
    <?php
$_smarty_tpl->tpl_vars['followed'] = $__foreach_followed_0_saved_local_item;
}
if ($__foreach_followed_0_saved_item) {
$_smarty_tpl->tpl_vars['followed'] = $__foreach_followed_0_saved_item;
}
?>
</div><?php }
}
