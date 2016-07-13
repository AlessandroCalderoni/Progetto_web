<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/06/2016
 * Time: 17:24
 */
class FImage Extends USingleton
{


    // ========================= STATIC =========================
    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe
    protected static $is_initialized = FALSE; // indica se si può instanziare (singleton)

    private static $database = null;

    /** Inizializza collegamento a db
     * @param FMariaDBHandler $handl Riferimento all'handler
     */
    public static function initializeDBHandler (FMariaDBHandler $handl) {

        self::$database =  $handl;
        self::$is_initialized = TRUE;

    }

    // ========================= STATIC =========================

    // ========================= CONST =========================
    const PROFILE = 'profile_pic';
    const POST = 'post_pic';
    const PROFILE_SECONDARY = 'owner';
    const POST_SECONDARY = 'id_post';

    const AUXILARY = 'aux_pic';
    const AUX_ID = 'id';
    // ========================= CONST =========================



    private $db = null; // riferimento al dbhendeler


    // ========================= METODI PUBBLICI =========================
    /**
     * Assegna un riferimento ad un'istanza di un gestore di Database
     *
     * @param FMariaDBHandler $hendeler Riferimento ad una istanza
     */
    public function setDBHandler(FMariaDBHandler $hendeler) {
        $this->db = $hendeler;
    }


    /**
     * Ritorna un'immagine dal database
     *
     * @param mixed $identifier ID dell'immagine
     * @param string $location Tabella in cui si fa la ricerca
     * @return Immagine richiesta
     */
    public function fetch($identifier, $location = self::PROFILE) {

        if ($location === self::POST) {
            $col_where = self::POST_SECONDARY;
        }
        else {
            $col_where = self::PROFILE_SECONDARY;
        }



        $response = $this->db->shortcutFetch($location, $col_where, $identifier );

        return $this->generateImage($response)[0];
    }

    /** Fetch immagini ausiliarie
     * @param int $id Id dell'immagine
     * @return UImage Immagine richiesta
     */
    public function fetchAux($id) {
        $response = $this->db->shortcutFetch(self::AUXILARY, self::AUX_ID, $id );
        return $this->generateImage($response)[0];
    }

    public function postHasImage(MPost $post) {

        $has = FALSE;

        $id_post = $post->getPostId();

        $table = FImage::POST;

        $result = $this->db->query("SELECT `id` FROM `$table` WHERE `id_post` = $id_post;");

        if ($result->num_rows !== 0) { // se c'è una risposta non nulla
            $has = TRUE; // c'è un'immagine
        }

        return $has;

    }

    /**
     * Memorizza un'immagine nel database
     *
     * @param UImage $image Immagine da memorizzare
     * @param string $location Costante tabella in cui si memorizza
     */
    public function save(UImage &$image, $location = self::PROFILE) {

        if ($location === self::POST) {
            $col_where = self::POST_SECONDARY;
        }
        else {
            $col_where = self::PROFILE_SECONDARY;
        }

        $arr_data = [];

        $arr_data[] = NULL;
        $arr_data[] = $image->getDoctype();
        $arr_data[] = $image->getImg();


        $id_owner = $image->getOwner();
        if (isset($id_owner)) {
            $arr_data[] = $id_owner;
        }


        $id_post = $image->getIdPost();

        if (isset($id_post)) {
            $arr_data[] = $id_post;
        }
        
        $id_img = $this->db->shortcutSave($location, $arr_data);

        $image->setId($id_img);

    }

    public function update(UImage $image) {

        $table = self::PROFILE;

        $id_owner = $image->getOwner(); // id del proprietario

        $str_set = '`doctype`=' . $this->db->tidyForInput($image->getDoctype()) . ', ';
        $str_set .= '`img`=' . $this->db->tidyForInput($image->getImg());

        $querystr = "UPDATE `$table` SET $str_set WHERE `owner` = $id_owner";

        $this->db->query($querystr);

    }

    /**
     * Cancella un'immagine profilo dal database
     *
     * @param int $user_id Immagine utente da cancellare
     * @param string $location Tabella in cui si fa la cancellazione
     */
    public function deleteUserImage($user_id) {

        $this->db->shortcutDelete(self::PROFILE, self::PROFILE_SECONDARY, $user_id);

    }
    

    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================

    /**
     * Da un array di info, ottieni un array di UImage
     *
     * @param array $result Array di info immagine
     * @return array Array di UImage corrispondente
     */
    private function generateImage($response) {

        $operation = function ($row) {

            $newimage = new UImage();

            $newimage->setId($row['id']);
            $newimage->setDoctype($row['doctype']);
            $newimage->setImg($row['img']);

            if (isset($row['id_post'])) { // in caso di immagine di post
                $newimage->setIdPost($row['id_post']);
            }

            if(isset($row['owner'])) { // in caso di immagine di profilo
                $newimage->setOwner($row['owner']);
            }

            return $newimage;

        };

        return array_map($operation, $response);

    }

    /**
     * FImage constructor.
     */
    protected function __construct () {
        $this->setDBHandler(self::$database);
    }
    // ========================= METODI PRIVATI =========================


}




?>