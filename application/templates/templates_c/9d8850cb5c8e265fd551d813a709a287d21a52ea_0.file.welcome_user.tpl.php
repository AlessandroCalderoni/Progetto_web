<?php
/* Smarty version 3.1.29, created on 2016-06-21 11:56:30
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/welcome_user.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57690f4e0e6647_09332300',
  'file_dependency' => 
  array (
    '9d8850cb5c8e265fd551d813a709a287d21a52ea' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/welcome_user.tpl',
      1 => 1466502639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57690f4e0e6647_09332300 ($_smarty_tpl) {
?>
<div>
  Ti chiami: <?php echo $_smarty_tpl->tpl_vars['nome_cognome']->value;?>
 <br />
  email: <?php echo $_smarty_tpl->tpl_vars['email']->value;?>
 <br />
  admin: <?php echo $_smarty_tpl->tpl_vars['admin']->value;?>
 <br />
</div><?php }
}
