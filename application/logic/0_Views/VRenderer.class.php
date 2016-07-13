<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 20/06/16
 * Time: 12:34
 */
// require_once('./libs/smarty/Autoloader.php');
require_once('./libs/smarty/Smarty.class.php');

class VRenderer Extends Smarty{

    // ========================= METODI PUBBLICI =========================
    /**
     * Configurazione di smarty
     * @param array $conf Array di configurazione smarty
     */
    public function configuration($conf) {

        $this->setTemplateDir($conf['main_dir'] . $conf['template_dir']);
        $this->setCompileDir($conf['main_dir'] . $conf['compile_dir']);
        $this->setConfigDir($conf['main_dir'] . $conf['config_dir']);
        $this->setCacheDir($conf['main_dir'] . $conf['cache_dir']);
        $this->caching = $conf['caching'];
        // $this->testInstall();
    }
    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================
    // ========================= METODI PRIVATI =========================

}