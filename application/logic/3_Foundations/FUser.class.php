<?php
/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 16/06/16
 * Time: 23:00
 */

/**
 * Class FUser
 */
class FUser Extends USingleton {

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
    const TABLE = 'user';
    const PRIMARY_KEY = 'ID';
    const SECONDARY_KEY = 'Email';

    const DEFAULT_IMAGE_ID = 2;
    // ========================= CONST =========================



    private $db = null; // riferimento al dbhendeler



    // ========================= METODI PUBBLICI =========================
    /**
     * Assegna un riferimento ad un'istanza di un gestore di Database
     *
     * @param IFdbhendeler $hendeler Riferimento ad una istanza
     */
    public function setDBHandler(FMariaDBHandler $hendeler) {
        $this->db = $hendeler;
    }


    /**
     * Fetch dell'utente dal database
     * @param integer/string $identifier ID o email dell'utente
     * @return MUser/MAdmin Utente richiesto
     * @throws Exception
     */
    public function fetch($identifier) {

        // var_dump($identifier);
        if (is_string($identifier) === TRUE) {

            $whr_col = self::SECONDARY_KEY;

        }
        else {
            $whr_col = self::PRIMARY_KEY;
        }

        // $whr_val = $this->db->tidyForInput($identifier);

        $arr_result = $this->db->shortcutFetch(self::TABLE, $whr_col, $identifier);

        return $this->structureUser($arr_result)[0]; // primo elemento dell'array

    }


    /**
     * Modifica i dati utente su DBMS
     * @param MUser $input Riferimento all'utente
     * @throws Exception
     */
    public function update(MUser &$input) {

        $table = self::TABLE;

        $colkey = self::PRIMARY_KEY;
        $keyvalue = $input->getId();

        $str_set = '';

        $str_set .= '`Email`=' . $this->db->tidyForInput($input->getEmail()) . ', ';
        $str_set .= '`Password`=' . $this->db->tidyForInput($input->getPassword()) . ', ';
        $str_set .= '`Name`=' . $this->db->tidyForInput($input->getName()) . ', ';
        $str_set .= '`Surname`=' . $this->db->tidyForInput($input->getSurname()) . ', ';
        $str_set .= '`Address`=' . $this->db->tidyForInput($input->getAddress()) . ', ';
        $str_set .= '`Birth_date`=' . $this->db->tidyForInput($input->getBirthDate()) . ', ';
        $str_set .= '`isadmin`=' . $this->db->tidyForInput($input->getIsadmin());

        $querystr = "UPDATE $table SET $str_set WHERE `$colkey` = $keyvalue";


        // var_dump($querystr);
        $this->db->query($querystr);


    }

    /**
     * Rimuovi l'utente per ID
     *
     * @param integer $id_number ID dell'utente da eliminare
     * @throws Exception
     */
    public function remove($id_number) {

        $this->db->shortcutDelete(self::TABLE, self::PRIMARY_KEY, $id_number);
        
    }

    /**
     * Memorizza utente nel database
     *
     * @param MUser $input Riferimento al nuovo utente
     * @param UImage $image Immagine utente (opzionale)
     * @throws Exception
     */
    public function save(MUser &$input, UImage $image = null) {

        $this->db->query("START TRANSACTION;");

        $arr_data = [];

        $state = $input->getState(); // stato dell'utente

        $arr_data[] = NULL; // non ha un id
        $arr_data[] = $state['email'];
        $arr_data[] = $state['passwd'];
        $arr_data[] = $state['name'];
        $arr_data[] = $state['surname'];
        $arr_data[] = $state['address'];
        $arr_data[] = $state['birth_date'];
        $arr_data[] = $state['isadmin'];


        $newid = $this->db->shortcutSave(self::TABLE, $arr_data);

        $input->setId($newid);

        $fimage = FImage::getInstance();

        if ($image === null) {

            $image = $fimage->fetchAux(self::DEFAULT_IMAGE_ID);

        }

        $image->setOwner($newid); // assegna un id di utente all'immagine

        $fimage->save($image);

        $this->db->query("COMMIT;");

    }

    /**
     * Restituisce info sugli utenti seguiti
     *
     * @param MUser $follower Riferimento all'utente follower
     * @param  integer $offset  Per range di risultati; inidica il punto di inizio
     * @param integer $range Per range di risultati: indica quanto è ampio il range stesso
     *
     * @return array Array di utenti
     */
    public function getFollowed(MUser $follower, $offset = 0, $range = 1) {

        $id_follower = $follower->getId();

        $max = $range;

        $query = "SELECT `us`.* FROM `follow` as `f` INNER JOIN `user` as `us` ON `f`.`Id_followed` = `us`.`ID` WHERE `f`.`Id_follower` = $id_follower LIMIT $offset, $max";

        $res = $this->db->query($query);

        $arr_result = $this->db->responseToArray($res);

        return $this->structureUser($arr_result);
    }

    /**
     * Aggiungi un utente followed
     *
     * @param MUser $follower Riferimento a chi segue
     * @param integer $id_followed ID di chi è seguito
     * @throws Exception
     */
    public function addFollowed(MUser $follower, $id_followed) {

        $arr_inserted = [$follower->getId(), $id_followed]; // id follower - id followed

        $table = 'follow';

        $this->db->shortcutSave($table, $arr_inserted);

    }

    /**
     * Rimuovi un utente followed
     *
     * @param MUser $follower Riferimento a chi segue
     * @param integer $id_followed ID di chi è seguito
     * @throws Exception
     */
    public function removeFollowed(MUser $follower, $id_followed) {

        $id_follower = $follower->getId();

        $table = 'follow';
        $follower = 'Id_follower';
        $followed = 'Id_followed';

        $querystr = "DELETE FROM `$table` WHERE `$follower` = $id_follower AND `$followed` = $id_followed;";

        $this->db->query($querystr);

    }

    /**
     * Controllo di utilizzo di una email
     *
     * @param string $stremail Email da controllare
     * @return bool TRUE se è usata
     * @throws Exception
     */
    public function isEmailUsed($stremail) {

        $used = TRUE;;

        try {

            $this->db->shortcutFetch(self::TABLE, self::SECONDARY_KEY, $stremail);

        }
        catch (Exception $err) {
            if ($err->getMessage() === UErrorHandler::EMPRYRESP_MSG) {
                $used = FALSE;
            }
            else
                throw $err;
        }


        return $used;
    }

    
    /**
     * Rendi admin un utente
     *
     * @param MUser $user Utente a cui cambiare stato
     * @throws Exception
     */
    public function changeStateAdmin(MUser $user) {

        $table = self::TABLE;

        $colkey = self::PRIMARY_KEY;

        $id_user = $user->getId(); // id dell'user

        $toggle = $user->getIsadmin(); // stato attuale dell'utente

        $querystr = "UPDATE $table SET `isadmin` = $toggle WHERE `$colkey` = $id_user";

        $this->db->query($querystr);


    }

    /** Ricerca di utenti nel DB
     * @param $search_str Stringa di ricerca
     * @param int $offset Offset nei risultati
     * @param int $range Range nei risultati
     * @return array Dati utente
     */
    public function smartNameSurnameFind($search_str, $offset = 0, $range = 1) {

        $search_str_arr = explode(' ', $search_str); // split in base agli spazi

        $max = $range;

        $col_name = 'Name';

        $col_surname = 'Surname';

        $where = '';

        foreach ($search_str_arr as $key => $value) {

            $where .= "`$col_name` LIKE '%$value%' OR `$col_surname` LIKE '%$value%'";

            if (isset($search_str_arr[$key+1])) {
                $where .= " AND ";
            }

        }

        $table = self::TABLE;

        $str_query = "SELECT * FROM `$table` WHERE $where ORDER BY $col_name, $col_surname LIMIT $offset, $max;";

        // var_dump($str_query);

        $result = $this->db->query($str_query); // potrebbe lanciare l'eccezione di risposta vuota

        $arr_res = $this->db->responseToArray($result);

        // var_dump($arr_res);

        return $this->structureUser($arr_res);

    }

    /** Controllo permanenza nel database di un utente
     * @param int $user_id ID dell'utente
     * @return bool TRUE se persiste
     */
    public function userExists($user_id) {

        $table = self::TABLE;
        $id = self::PRIMARY_KEY;

        $exists = false;

        $str_query = "SELECT `$id` FROM `$table` WHERE `$id` = $user_id;";

        $response = $this->db->query($str_query); // se la risposta non è vuota l'utente esite
        if ($response->num_rows !== 0) {
            $exists = true;
        }


        return $exists;

    }

    /** ID degli utenti seguiti
     * @param MUser $user Utente che segue
     * @return array Array di ID
     */
    public function getFollowedIds(MUser $user) {

        $id_user = $user->getId();

        $str_query = "SELECT `Id_followed` FROM `follow` WHERE `Id_follower` = $id_user;";

        $result = $this->db->query($str_query); // potrebbe lanciare l'eccezione di risposta vuota

        $arr_res = $this->db->responseToArray($result);

        foreach ($arr_res as &$row) {

            $row = $row['Id_followed'];

        }

        return $arr_res;

    }
    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================

    /**
     * FUser constructor.
     */
    protected function __construct () {
        $this->setDBHandler(self::$database);
    }

    /**
     * Restituisce un array di utenti a partire dalle loro informazioni
     *
     * @param array $result Array delle informazioni di utente
     * @return array Array di MUser corrispondente
     */
    private function structureUser($result) {

        // var_dump($result);

        $operation = function ($row) {

            $nuser = new MUser();

            $nuser->setId($row['ID']);
            $nuser->setEmail($row['Email']);
            $nuser->setPassword($row['Password'], TRUE);
            $nuser->setName($row['Name']);
            $nuser->setSurname($row['Surname']);
            $nuser->setAddress($row['Address']);
            $nuser->setBirthDate($row['Birth_date']);
            $nuser->setIsadmin($row['isadmin']);

            return $nuser;
        };

        return array_map($operation, $result);
    }

    // ========================= METODI PRIVATI =========================




}