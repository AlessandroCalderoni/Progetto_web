<?php
/**
 * Author: Gioacchino Castorio
 * Date: 2016-6-10
 * License: GNUgpl3
 * email: castorio.gioacchino.work@gmail.com
 * tel: +39 (328) 9193607
 */

// invocazione funzione di autoconfigurazione
call_user_func(function () {

  // elimina warning
  error_reporting(E_ERROR | E_PARSE);

  // ========================= APERTURA startup-config.ini ========================
  // ottieni dati dal file di configurazione
  $path_ini = './etc/startup-config.ini';
  $arr_config = parse_ini_file($path_ini, true);
  // ========================= APERTURA startup-config.ini ========================

  // ========================= ATTIVA class autoloader ========================
  spl_autoload_register(function ($classname) {

    $controlchar = $classname[0];
    if ($controlchar === 'I') {
      $type = 'interface';
      $controlchar = $classname[1];
    }
    else {
      $type = 'class';
    }

    $arr_includes = array(
        'V' => "./logic/0_Views/",
        'C' => "./logic/1_Controllers/",
        'M' => "./logic/2_Models/",
        'F' => "./logic/3_Foundations/",
        'U' => "./includes/utils/"
    );

    if (in_array($controlchar, array_keys($arr_includes))) {
      $required = $arr_includes[$controlchar] . "$classname.$type.php";

      require_once($required);
    }


  });
  // ========================= ATTIVA class autoloader ========================

  // ========================= GESTIONE sessione grafica ========================

  if (isset($_REQUEST['ajax'])) { // se la richiesta è AJAX

    $vrenderer = null;
  }
  else {

    // inizializza il template engine
    $par_template_engine = $arr_config['template-engine'];

    $vrenderer = new VRenderer();

    $vrenderer->configuration($par_template_engine);

    // $vrenderer->testInstall();

    // assegna renderer alle varie view
    VPost::initializeRenderer($vrenderer);
    VUser::initializeRenderer($vrenderer);
    
  }

  VHome::initializeRenderer($vrenderer); // vhome deve essere inizializzata in ogni caso


  // ========================= GESTIONE sessione grafica ========================

  // ================== SET timezone_abbreviations_list ========================
  date_default_timezone_set($arr_config['time']['zone']);
  // ================== SET timezone_abbreviations_list ========================

  // ========================= INIZIALIZZAZIONE dbms ========================
  try {


    $arr_mysql_config = $arr_config['database'];

    $msqli_inst = new FMariaDBHandler();

    $success = $msqli_inst->real_connect(
        $arr_mysql_config['ip_address'],
        $arr_mysql_config['username'],
        $arr_mysql_config['table'],
        $arr_mysql_config['database'],
        $arr_mysql_config['port_number'],
        $arr_mysql_config['sock_config']
    );


    if ($success === FALSE) {
      throw new Exception(UErrorHandler::DBNR_MSG);
    }

    // inizializzazione delle classi foundation
    FPost::initializeDBHandler($msqli_inst);
    FUser::initializeDBHandler($msqli_inst);
    FImage::initializeDBHandler($msqli_inst);

  }
  catch (Exception $err) {

    $_REQUEST[UErrorHandler::SGN_ERR] = $err->getMessage();

  }
  // ========================= INIZIALIZZAZIONE dbms ========================
});




