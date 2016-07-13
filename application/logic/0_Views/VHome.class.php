<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 20/06/16
 * Time: 09:33
 */
class VHome Extends USingleton {

    // ========================= STATIC =========================
    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe
    protected static $is_initialized = FALSE; // indica se si può instanziare (singleton)

    private static $vrenderer = null;

    public static function initializeRenderer ($vren) {

        if (!($vren === null || $vren instanceof VRenderer)) {
            throw new Exception();
        }
        self::$vrenderer =  $vren;
        self::$is_initialized = TRUE;

    }
    // ========================= STATIC =========================

    private $vren = null; // template engine wrapper
    private $template_to_use = '';
    private $error = []; // Array di errori

    // ========================= METODI DI CLASSE =========================
    /**
     * Compone un evento richiesto mediante le richieste HTTP
     *
     * @return UEvent Riferimento ad un nuovo evento
     */
    public static function generateEvent() {

        // genera un nuovo evento
        $event = new UEvent();


        if (!empty($_REQUEST)) {

            // fetch dei parametri passati in GET e POST
            foreach ($_REQUEST as $key => $value) {
                if ($key === 'env')
                    $event->setEnvironment($value);
                elseif ($key === 'op')
                    $event->setOperation($value);
                else
                    $event->addPayload($key, $value);
            }

            // mantieni eventuali riferimenti a immagini
            $event->addPayload('img', $_FILES);
            // var_dump($_FILES);
        }
        else {
            $event->setEnvironment('user');
            $event->setOperation('homepage');
        }

        return $event;
    }

    // ========================= METODI DI CLASSE =========================

    

    // ========================= METODI PUBBLICI =========================

    /**
     * Assegna un template alla view
     *
     * @param string $template_to_use Nome del template
     */
    public function setTemplateToUse($template_to_use)
    {
        $this->template_to_use = $template_to_use;
    }

    /**
     * Set del Wrapper smarty
     * @param VRenderer $vr Wrapper smarty
     */
    public function setRenderer($vr) {

        $this->vren = $vr;

    }

    /**
     * Rendering della topbar
     *
     * @param string $old_search Parametro opzionale della vecchia ricerca
     * @return string Topbar renderizzata
     */
    public function renderTopbar($old_search = null) {

        $this->setTemplateToUse('topbar.tpl');

        $this->vren->append('js', 'topbar');

        $this->vren->append('style', 'topbar');
        $this->vren->assign('old_search', $old_search);
        
        return $this->vren->fetch($this->template_to_use);

    }

    /** Rendering della bottombar
     * @return string Bottombar renderizzata
     */
    public function renderBottombar() {

        $this->setTemplateToUse('bottombar.tpl');

        $this->vren->append('style', 'bottombar');

        return $this->vren->fetch($this->template_to_use);

    }

    /** Rendering errori gravi
     * @return string Pagina renderizzata
     */
    public function renderError() {

        $this->setTemplateToUse('error.tpl');

        $this->vren->append('style', 'error');

        $this->vren->assign('errors', $this->error); // assegna gli errori

        return $this->vren->fetch($this->template_to_use);
    }

    /**
     * Visualizza output completo
     *
     * @param mixed $bodyfinal Stringa compilata da smarty oppure un array da inviare come JSON
     */
    public function render($bodyfinal) {

        if (is_array($bodyfinal) === FALSE) {

            $this->setTemplateToUse('home_basic.tpl');

            $this->vren->assign('title', 'The Nerd Zone');

            // js di validità globale
            $this->vren->append('js', 'global_error');

            // controllo di presenza script
            $css = $this->vren->getTemplateVars('style');
            $js = $this->vren->getTemplateVars('js');

            if ($css === null) {
                $this->vren->assign('style', []);
            }

            if ($js === null) {
                $this->vren->assign('js', []);
            }

            $this->vren->assign('body_content', $bodyfinal);
            $this->vren->display($this->template_to_use);
            
        }
        else {

            // var_dump($bodyfinal);
            header('Content-Type: application/json'); // content type di JSON

            echo json_encode($bodyfinal);

        }


    }

    /**
     * Aggiungi un errore agli output
     *
     * @param string $error_str Stringa di errore
     */
    public function addError($error_str)
    {
        $this->error[] = $error_str;
    }
    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================
    /**
     * VHome constructor.
     */
    protected function __construct () {
        $this->setRenderer(self::$vrenderer);
    }
    // ========================= METODI PRIVATI =========================

}