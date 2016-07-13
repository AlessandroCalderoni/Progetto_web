<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 17/06/16
 * Time: 17:29
 */

/**
 * Class FPost
 */
class FPost Extends USingleton {

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
    const TABLE = 'post';
    const PRIMARY_KEY = 'Post_id';
    // ========================= CONST =========================



    private $db = null; // riferimento al dbhendeler

    // ========================= METODI PUBBLICI =========================
    /**
     * Assegna un riferimento ad un'istanza di un gestore di Database
     *
     * @param FMariaDBhendeler $hendeler Riferimento ad una istanza
     */
    public function setDBHandler(FMariaDBHandler $hendeler) {
        $this->db = $hendeler;
    }

    /**
     * Fetch di un Post o un commento dal database
     *
     * @param integer $id ID del post
     * @return mixed Torna un post o un commento
     */
    public function fetch($id) {

        $arr_result = $this->db->shortcutFetch(self::TABLE, self::PRIMARY_KEY, $id);

        return $this->generatePostComment($arr_result)[0];


    }

    /**
     * Fetch dei commenti legati a un Post dal database
     *
     * @param integer $post_id Id del post di cui leggere i commenti
     * @param integer $offset offset  per il numero di commenti da selezionare
     * @param integer $range numero di commenti da selezionare
     * @return mixed Torna un'array di post o di commento
     */
    public function fetchComments($post_id, $offset = 0, $range = 1) {

        $table = self::TABLE; // post table
        $usert = FUser::TABLE; // user table
        $us_primary_key = FUser::PRIMARY_KEY; // chiave primaria dell'user
        $p_primary_key = FPost::PRIMARY_KEY;

        $max = $range; // limite commenti da visualizzare

        $query = "SELECT `com`.*, `us`.`Name` AS `authn`, `us`.`Surname` AS `auths` FROM `$table` AS `p`, `$table` AS `com`, `$usert` AS `us`  WHERE `p`.`Post_id` = `com`.`Id_parent_of_comment` AND `us`.`$us_primary_key` = `com`.`User_id` AND `p`.`$p_primary_key` = $post_id ORDER BY `com`.`Date_last_change` DESC LIMIT $offset, $max ;";
        
        $result = $this->db->query($query);

        $arr_result = $this->db->responseToArray($result);

        return $this->generatePostComment($arr_result);

    }

    /**
     * Fetch dei commenti legati ad un utente
     * @param integer $id_user utente di cui leggere i post
     * @param integer $offset offset  per il numero di commenti da selezionare
     * @param integer $range numero di commenti da selezionare
     * @return mixed Torna un'array di post o di commento
     */
    public function getUserPosts($id_user, $offset = 0, $range = 1) {
        $max = $range;

        $query = "SELECT `p`.* FROM `post` as `p` WHERE `p`.`User_id` = $id_user AND `p`.`Id_parent_of_comment` IS NULL ORDER BY `p`.`Date_last_change` DESC   LIMIT $offset, $max;";

        $result = $this->db->query($query);

        $arr_result = $this->db->responseToArray($result);

        return $this->generatePostComment($arr_result);
    }

    /**
     * Fetch dei post di un utente followed
     *
     * @param MUser utente di cui leggere i post
     * @param integer $offset offset  per il numero di elementi da selezionare
     * @param integer $range numero di elementi da selezionare
     * @return array Torna un'array di post o di commento
     */
    public function getFollowedPosts(MUser $us, $offset = 0, $range = 1) {

        $usert = FUser::TABLE;
        $us_primary_key = FUser::PRIMARY_KEY;

        $id_user = $us->getId();

        $max =$range;

        $strquery = "SELECT `fp`.*, `us`.`Name` AS `authn`, `us`.`Surname` AS `auths` FROM `post` as `fp`, `follow` as `fol`, `$usert` AS `us` WHERE  `fol`.`Id_followed` = `fp`.`User_id` AND `fol`.`Id_follower` = $id_user AND `us`.`$us_primary_key` = `fol`.`Id_followed` AND `fp`.`Id_parent_of_comment` IS NULL ORDER BY `fp`.`Date_last_change` DESC LIMIT $offset, $max;";

        // var_dump($strquery);
        $result = $this->db->query($strquery);

        $arr_result = $this->db->responseToArray($result);

        return $this->generatePostComment($arr_result);
    }

    /**
     * Memorizza commento / post nel database; assegna un ID all'oggetto
     *
     * @param MPost $input Riferimento al commento / post da memorizzare
     * @param UImage $image Immagine del post (opzionale)
     * @throws Exception
     */
    public function save(MPost &$input, UImage $image = null) {

        $this->db->query("START TRANSACTION;");

        $arr_data = [];

        $arr_data[] = NULL;
        $arr_data[] = $input->getUserId();
        $arr_data[] = $input->getDateLastChangeSeconds();
        $arr_data[] = $input->getTextContent();

        if ($input instanceof MComment) { // se è un commento
            $arr_data[] = $input->getIdParent(); // ha un post padre
        }
        else {
            $arr_data[] = NULL;
        }

        $newid = $this->db->shortcutSave(self::TABLE, $arr_data);

        $input->setPostId($newid);

        if ($image !== null) {

            $image->setIdPost($newid);

            $fimage = FImage::getInstance();

            $fimage->save($image, FImage::POST);

        }

        $this->db->query("COMMIT;");

    }

    /**
     * Rimuovi un commento / post dal database
     *
     * @param $id_number ID del commento / post
     * @throws Exception
     */
    public function delete($id_number) {
        $this->db->shortcutDelete(self::TABLE, self::PRIMARY_KEY, $id_number);
    }

    // ========================= METODI PRIVATI =========================

    /**
     * Da un array di info di post, ottieni un array di MPost / MComment
     *
     * @param array $result Array di info
     * @return array Array di MPost / MComment corrispondente
     */
    private function generatePostComment($result) {

        $operation = function ($post) {

            if (isset($post['Id_parent_of_comment'])) { // se c'è un post "genitore", allora si tratta di un commento
                $obj = new MComment();

                $obj->setIdParent($post['Id_parent_of_comment']);
            }
            else {
                $obj = new MPost();
            }

            $obj->setPostId($post['Post_id']);
            $obj->setUserId($post['User_id']);
            $obj->setDateLastChange($post['Date_last_change']);
            $obj->setContent($post['text_content']);

            if (isset($post['authn'])) { // se viene restituito un valore per il nome dell'autore
                $obj->setAuthorName($post['authn'] . " " . $post['auths']);
            }

            // controlla se c'è un immagine nel db associata al post
            $fimage = FImage::getInstance();
            $has_image = $fimage->postHasImage($obj);
            $obj->setHasImage($has_image);


            return $obj;
        };

        return array_map($operation, $result);
    }

    /**
     * FPost constructor.
     */
    protected function __construct () {
        $this->setDBHandler(self::$database);

    }

    // ========================= METODI PRIVATI =========================


}