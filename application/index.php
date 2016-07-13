<?php

// carica l'autoloader dei moduli php
require_once('./includes/init.comp.php');

// dai avvio alla "vera" esecuzione
CHome::getInstance()->start();

/*
$intestazione = "The Nerd Zone <info@thenerdzone.org>\r\n";
$intestazione .= "X-Priority: 2\r\n"; // 2 = urgente, 3 = normale, 4 = bassa priorità
$intestazione .= "X-Mailer: PHP/" . phpversion();

$parametri = "-f info@thenerdzone.org";
var_dump(mail('dongioac@icloud.com', 'prova oggetto', 'ciao mondo messaggio', $intestazione, $parametri));
*/

 ?>
