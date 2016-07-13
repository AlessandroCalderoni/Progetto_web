<?php
/* Smarty version 3.1.29, created on 2016-07-04 11:40:16
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/topbar.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577a2f00c83d02_05822746',
  'file_dependency' => 
  array (
    'be75d292290f577ee589d78503e21f1dfda67de8' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/topbar.tpl',
      1 => 1467625214,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577a2f00c83d02_05822746 ($_smarty_tpl) {
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./?env=user&op=homepage">Zona NERD</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            <?php if (isset($_smarty_tpl->tpl_vars['old_search']->value) == true) {?>
                <?php $_smarty_tpl->tpl_vars['old_s'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_search']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'old_s', 0);?>
            <?php } else { ?>
                <?php $_smarty_tpl->tpl_vars['old_s'] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'old_s', 0);?>
            <?php }?>
            <form class="navbar-form navbar-right" method="get" action="./">
                <div class="form-group">
                    <input type="text" id="searchbox" placeholder="Cerca un utente" class="form-control" name="search" value="<?php echo $_smarty_tpl->tpl_vars['old_s']->value;?>
">
                    <input type="hidden" class="form-control" name="env" value="user">
                    <input type="hidden" class="form-control" name="op" value="search">
                </div>
                <button id="search-submit" type="submit" class="btn btn-success">Search</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>

<div class="container-fluid" id="total-container"> <!-- container di tutto ciò che è tra la topbar e la bottombar -->
    <div class="row"><?php }
}
