<?php
/* Smarty version 3.1.29, created on 2016-07-04 10:11:11
  from "/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/login.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577a1a1f7de2c6_78231309',
  'file_dependency' => 
  array (
    '716f412b9ad692abd5e76d44b20df6190a8d113e' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/progetto_web/application/templates/template/login.tpl',
      1 => 1467619186,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577a1a1f7de2c6_78231309 ($_smarty_tpl) {
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="wrap">
                <p class="form-title">
                    The nerd Zone
                </p>
                <form class="login" id="log" method="post" action="./?env=user&op=login">

                    <?php if (isset($_smarty_tpl->tpl_vars['old_login_val']->value['email'])) {?>
                        <?php $_smarty_tpl->tpl_vars['mail'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_login_val']->value['email'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'mail', 0);?>
                    <?php } else { ?>
                        <?php $_smarty_tpl->tpl_vars['mail'] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'mail', 0);?>
                    <?php }?>

                    <input type="text" placeholder="Email" value="<?php echo $_smarty_tpl->tpl_vars['mail']->value;?>
" name="email" />


                    <input type="password" placeholder="Password" name="passwd"/>
                    <input id='btn-login' type="submit" value="Log-in" class="btn btn-success btn-sm" />
                    <label id="reg-b">Registrati</label>
                </form>

                <form class="login" id="reg" method="post" action="./?env=user&op=register" enctype="multipart/form-data">

                    <?php if (isset($_smarty_tpl->tpl_vars['old_register_val']->value)) {?>
                        <?php $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_register_val']->value['firstname'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'name', 0);?>
                        <?php $_smarty_tpl->tpl_vars['surname'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_register_val']->value['lastname'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'surname', 0);?>
                        <?php $_smarty_tpl->tpl_vars['email'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_register_val']->value['email'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'email', 0);?>
                        <?php $_smarty_tpl->tpl_vars['addr'] = new Smarty_Variable($_smarty_tpl->tpl_vars['old_register_val']->value['addr'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'addr', 0);?>

                    <?php } else { ?>
                        <?php $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'name', 0);?>
                        <?php $_smarty_tpl->tpl_vars['surname'] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'surname', 0);?>
                        <?php $_smarty_tpl->tpl_vars['email'] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'email', 0);?>
                        <?php $_smarty_tpl->tpl_vars['addr'] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'addr', 0);?>

                    <?php }?>

                    <!-- dati anagrafici -->
                    <input class="in-name-sur" type="text" placeholder="Nome" name="firstname" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" />
                    <input class="in-name-sur" type="text" placeholder="Cognome" name="lastname" value="<?php echo $_smarty_tpl->tpl_vars['surname']->value;?>
" />
                    <input type="text" placeholder="Indirizzo" name="address" value="<?php echo $_smarty_tpl->tpl_vars['addr']->value;?>
"/>

                    <input id="datepic" type="text" placeholder="Data nascita" name="birthdate"/>

                    <!-- dati utente -->
                    <input id="mail" type="text" placeholder="Nuova email" name="email" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
"/>

                    <label class="text-primary text-justify">La password deve contenere da 6 a 20 caratteri tra cui un carattere speciale, una lettera maiuscola e una cifra</label>
                    <input id="first-passwd" type="password" placeholder="Nuova password" name="password" />
                    <input id="rep-passwd" type="password" placeholder="Conferma" name="password-confirm"/>


                    <label class="text-muted  text-justify">Immagine di profilo JPEG o PNG (non obbligatoria)</label>
                    <input type="file" name="user_pic" />

                    <input id='btn-registration' type="submit" value="Log-on" class="btn btn-success btn-sm" />
                    <label id="log-b">Login</label>
                </form>

            </div>

        </div>
    </div>


    <?php if (isset($_smarty_tpl->tpl_vars['error']->value) || isset($_smarty_tpl->tpl_vars['postive_log']->value)) {?>

        <div class="row alerts col-md-3">

            <div class="col-md-12">
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
            </div>

        </div>

    <?php }?>

    <div class="posted-by">Copyright Gligegneri tutti i diritti sono riservati</div>
</div>

<?php }
}
