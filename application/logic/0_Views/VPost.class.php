<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 21/06/16
 * Time: 10:21
 */
class VPost Extends USingleton {

    // ========================= STATIC =========================
    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe
    protected static $is_initialized = FALSE; // indica se si può instanziare (singleton)

    private static $vrenderer = null;

    public static function initializeRenderer (VRenderer $vren) {

        self::$vrenderer =  $vren;
        self::$is_initialized = TRUE;

    }
    // ========================= STATIC =========================


    private $vren = null;

    private $error = [];
    private $positive_log = [];
    private $template_to_use = '';

    private $arr_post = [];

    // ========================= METODI PUBBLICI =========================
    /** Set del riferimento al Template engine
     * @param VRenderer $vr Riferimento al Template engine
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

    public function addPositiveLog($positive_str) {

        $this->positive_log[] = $positive_str;

    }

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
     * Render di un singolo post
     *
     * @param array $arr_post Array associativo dello stato del post
     * @return string Stringa compilata da smarty
     */
    public function addPost($arr_post) {

        $this->setTemplateToUse('post.tpl');

        $this->vren->assign('post', $arr_post ); // inserisci dati nel template

        return $this->render();

    }

    /**
     * Box per l'inserimento di un nuovo post
     *
     * @return string Stringa compilata da smarty
     */
    public function renderNewPostBox() {
        
        $this->setTemplateToUse('post_list.tpl');

        $this->vren->append('style', 'new_post');
        $this->vren->append('js', 'new_post');

        return $this->render();

    }

    /**
     * Render di una lista di post passata come parametro
     *
     * @param array $post_list Stringhe di post compilate da smarty
     * @return string Stringa compilata da smarty
     */
    public function renderPostList($post_list, $more_post = 0) {

        // var_dump($post_list);

        $this->vren->assign('error', $this->error);
        $this->vren->assign('positive_log', $this->positive_log);

        // usa handlebars
        $this->vren->assign('use_handlebars', true);


        $this->vren->append('style', 'post_list');
        $this->vren->append('js', 'post_list');

        $this->vren->assign('more', $more_post);

        foreach ($post_list as $post) {

            $post_parsed = $this->renderPost($post); // rendering del singolo post
            $this->vren->append('post_list', $post_parsed);

        }

        $this->setTemplateToUse('post_list.tpl');

        return $this->render();

    }
    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================
    /**
     * Rendering
     * @return string View renderizzata
     */
    private function render() {
        $res = $this->vren->fetch($this->template_to_use);
        $this->error = [];
        $this->positive_log = [];
        $this->template_to_use = '';
        return $res;
    }

    protected function __construct () {
        $this->setRenderer(self::$vrenderer);
    }

    /**
     * Render del singolo post
     * @param array $arr_data_post Dati del post
     * @return string Stringa compilata da smarty
     */
    private function renderPost($arr_data_post) {

        $this->setTemplateToUse('post.tpl');

        $this->vren->assign('post',$arr_data_post );

        return $this->vren->fetch($this->template_to_use); // per non cancellare i log e gli errori

    }
    // ========================= METODI PRIVATI =========================

}