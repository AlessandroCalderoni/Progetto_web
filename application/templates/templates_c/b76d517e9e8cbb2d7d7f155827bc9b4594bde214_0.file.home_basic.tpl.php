<?php
/* Smarty version 3.1.29, created on 2016-07-05 17:32:59
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/home_basic.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577bd32b71eff3_04135336',
  'file_dependency' => 
  array (
    'b76d517e9e8cbb2d7d7f155827bc9b4594bde214' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/home_basic.tpl',
      1 => 1467732775,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577bd32b71eff3_04135336 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta tag -->
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="3600" />
        <meta name="revisit-after" content="2 days" />
        <meta name="robots" content="index,follow" />
        <meta name="author" content="Designed by Glingegneri / Gioacchino Castorio, Antonio Tuzi, Alessandro Calderoni & Doppio Mareino" />
        <meta name="distribution" content="global" />
        <meta name="description" content="Your container description here" />
        <meta name="keywords" content="Your keywords, keywords, keywords, here" />

        <!-- fogli di stile -->
        <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./templates/template/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./templates/template/css/dashboard.css" />
        <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./templates/template/css/jquery-ui.min.css" />
        <?php
$_from = $_smarty_tpl->tpl_vars['style']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_css_0_saved_item = isset($_smarty_tpl->tpl_vars['css']) ? $_smarty_tpl->tpl_vars['css'] : false;
$_smarty_tpl->tpl_vars['css'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['css']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['css']->value) {
$_smarty_tpl->tpl_vars['css']->_loop = true;
$__foreach_css_0_saved_local_item = $_smarty_tpl->tpl_vars['css'];
?>
        <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./templates/template/css/<?php echo $_smarty_tpl->tpl_vars['css']->value;?>
.css" />
        <?php
$_smarty_tpl->tpl_vars['css'] = $__foreach_css_0_saved_local_item;
}
if (!$_smarty_tpl->tpl_vars['css']->_loop) {
?>
            <!-- no css -->
        <?php
}
if ($__foreach_css_0_saved_item) {
$_smarty_tpl->tpl_vars['css'] = $__foreach_css_0_saved_item;
}
?>

        <!-- script js -->
        <?php echo '<script'; ?>
 src="./js/libs/jquery-3.0.0.min.js"><?php echo '</script'; ?>
> <!-- jquery 3.0.0 -->
        <?php echo '<script'; ?>
 src="./js/libs/jquery-ui.min.js"><?php echo '</script'; ?>
> <!-- jquery UI -->
        <?php echo '<script'; ?>
 src="./js/libs/manage_url.js"><?php echo '</script'; ?>
> <!-- jquery UI -->
        <?php echo '<script'; ?>
 src="./js/libs/handlebars-v4.0.5.js"><?php echo '</script'; ?>
> <!-- handlebars -->
        <?php echo '<script'; ?>
 src="./js/libs/jquery.cookie.js"><?php echo '</script'; ?>
> <!-- handlebars -->

        <?php
$_from = $_smarty_tpl->tpl_vars['js']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_script_1_saved_item = isset($_smarty_tpl->tpl_vars['script']) ? $_smarty_tpl->tpl_vars['script'] : false;
$_smarty_tpl->tpl_vars['script'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['script']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['script']->value) {
$_smarty_tpl->tpl_vars['script']->_loop = true;
$__foreach_script_1_saved_local_item = $_smarty_tpl->tpl_vars['script'];
?>
        <?php echo '<script'; ?>
 src="./js/opt/<?php echo $_smarty_tpl->tpl_vars['script']->value;?>
.js"><?php echo '</script'; ?>
>
            <?php
$_smarty_tpl->tpl_vars['script'] = $__foreach_script_1_saved_local_item;
}
if (!$_smarty_tpl->tpl_vars['script']->_loop) {
?>
            <!-- no other js -->
        <?php
}
if ($__foreach_script_1_saved_item) {
$_smarty_tpl->tpl_vars['script'] = $__foreach_script_1_saved_item;
}
?>

        <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>

        <!-- ?id=1&env=image&op=aux_pic -->
        <link rel="icon" type="image/jpeg" href="./?id=3&env=image&op=aux_pic" />
    </head>

        <!-- qui inizia il body -->

    <body>
        <?php echo $_smarty_tpl->tpl_vars['body_content']->value;?>

    </body>
</html><?php }
}
