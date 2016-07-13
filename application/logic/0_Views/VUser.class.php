<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 21/06/16
 * Time: 09:38
 */
class VUser Extends USingleton
{

    // ========================= STATIC =========================
    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe
    protected static $is_initialized = FALSE; // indica se si può instanziare (singleton)

    private static $vrenderer = null; // conterrà riferimento al renderer

    public static function initializeRenderer (VRenderer $vren) {

        self::$vrenderer =  $vren;
        self::$is_initialized = TRUE;

    }
    // ========================= STATIC =========================



    private $vren = null; // template engine wrapper

    private $error = [];
    private $positive_log = [];
    private $template_to_use = '';

    // ========================= METODI PUBBLICI =========================
    /** Set renderer smarty
     * @param VRenderer $vr Renderer
     */
    public function setRenderer(VRenderer $vr) {
        $this->vren = $vr;
    }

    /**
     * Set stringa di erroe
     *
     * @param string $error_str Messaggio di errore
     */
    public function addError($error_str)
    {
        $this->error[] = $error_str;
    }

    /**
     * Set stringa di segnalazione positiva
     * @param string $positive_str MEssaggio positivo
     */
    public function addPositiveLog($positive_str) {

        $this->positive_log[] = $positive_str;

    }

    /**
     * Assegna un template alla view
     *
     * @param string $template_to_use Nome del template
     */
    public function setTemplateToUse($template_to_use) {
        $this->template_to_use = $template_to_use;
    }

    /**
     * Visualizzazione login
     * @return string Stringa compilata da smarty
     */
    public function renderGuest($old_val_arr = null, $old_register_data = null) {

        $this->vren->assign('error', $this->error);
        $this->vren->assign('positive_log', $this->positive_log);

        $this->setTemplateToUse('login.tpl');

        if (isset($old_val_arr)) // se è un nuovo tentativo di login
            $this->vren->assign('old_login_val', $old_val_arr );
        else
            $this->vren->assign('old_login_val', []);

        $this->vren->assign('old_register_val', $old_register_data ); // se si fa un nuovo tentativo di registrazione

        // inserisci la lista degli errori se presente
        $this->vren->append('errors', $this->error);

        // inserisci il css del login
        $this->vren->append('style', 'login');

        // inserisci il js del login
        $this->vren->append('js', 'login');
        $this->vren->append('js', 'form_validation');

        return $this->render();


    }

    /**
     * Rendering della sidebar
     * @param array $arr_user_values Stato dell'utente
     * @param bool $is_user TRUE se è l'utente loggato
     * @return string Sidebar renderizzata
     */
    public function renderSidebar($arr_user_values, $is_user = TRUE) {

        // $this->vren->assign('error', $this->error);
        // $this->vren->assign('positive_log', $this->positive_log);

        $this->vren->assign('sidebar_self', $is_user); // per controllare se è l'utente loggato o un profilo esterno

        $this->setTemplateToUse('sidebar_user.tpl');

        $this->vren->assign('info_user', $arr_user_values);

        $this->vren->append('style', 'sidebar_user');
        // $this->vren->append('js', 'sidebar_user');

        return $this->render();
        
    }

    /**
     * Rendering di una lista di utenti
     *
     * @param array $arr_user Info degli utenti
     * @param int $more 1 Se ci sono ancora utenti da visualizzre
     * @param bool $user_admin TRUE se l'utente corrente è admin
     * @return string Lista renderizzata
     */
    public function renderFollowList($arr_user, $more = 1, $user_admin = false) {

        $this->vren->assign('positive_log', $this->positive_log);
        $this->vren->assign('error', $this->error);

        $this->vren->assign('more', $more);

        $this->vren->assign('is_admin', $user_admin);

        $this->setTemplateToUse('list_user.tpl');

        $this->vren->assign('arr_followed', $arr_user);

        $this->vren->append('style', 'list_user');
        $this->vren->append('js', 'list_user');

        return $this->render();


    }

    /** Rendering pagina di modifica dell'utente corrente
     * @param array $arr_user_status Stato dell'utente loggato
     * @return string View renderizzata
     */
    public function renderProfileToModify($arr_user_status) {

        $this->vren->assign('error', $this->error);

        $this->setTemplateToUse('form_profile_modify.tpl');

        $this->vren->assign('old_val', $arr_user_status);

        $this->vren->append('style', 'form_profile_modify');

        $this->vren->append('js', 'form_validation');
        $this->vren->append('js', 'self_eliminate');

        return $this->render();
    }
    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================
    /**
     * Operazione di rendering
     * @return string View renderizzata
     */
    private function render() {
        return $this->vren->fetch($this->template_to_use);
    }

    protected function __construct () {
        $this->setRenderer(self::$vrenderer);
    }
    // ========================= METODI PRIVATI =========================

}