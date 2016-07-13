<?php

 class MUser {

     // ========================= STATIC =========================

     /**
      * Restituisce un valore criptato per una stringa
      *
      * @param string $password Stringa da criptare
      * @return string Stringa criptata
      */
     public static function encryptPassword($password) {
         return md5($password);
     }

     // ========================= STATIC =========================

     // attributi fondamentali per riconoscere l'utente nel database
     private $id = 0;
     private $email = 'unknown@notvalid.not';
     private $passwd = 'not-a-secure-password';

     // anagrafica
     private $name = 'unknown';
     private $surname = 'unknown';
     private $address = 'unknown';
     private $birth_date = '1970-01-01';

     private $isadmin = 0;


     // ========================= METODI PUBBLICI =========================

     /**
      * Crea un post
      *
      * @param $content Contenuto del post
      * @return MPost Riferimento al nuovo post
      * @throws Exception
      */
     public function makePost($content_text, UImage $img = null) {


         $post = new MPost();

         $post->setTextContent($content_text);
         $post->setUserId($this->getId());

         $fpost = FPost::getInstance();

         $fpost->save($post, $img);

         return $post;
     }

     /**
      * Crea commento a post
      *
      * @param integer $id_post ID del post che si commenta
      * @param mixed $content Contenuto del commento
      * @return MComment Riferimento al nuovo post
      * @throws Exception
      */
     public function makeComment($id_post, $content) {

         $comment = new MComment();
         $comment->setTextContent($content);

         $comment->setIdParent($id_post);
         $comment->setUserId($this->id);

         $fpost = FPost::getInstance();

         $fpost->save($comment, null); // i commenti non prevedono immagini

         return $comment;
     }

     /**
      * Cancellazione di un commento / post che deve essere dell'utente
      *
      * @param integer $id_post ID del commento / post
      * @throws Exception
      */
     public function removePostComment($id_post) {

         $fpost = FPost::getInstance();

         try {

             $post = $fpost->fetch($id_post);

             if ($post->getUserId() == $this->getId() || $this->isadmin == TRUE) {

                 $fpost->delete($id_post);

             }
             else {
                 throw new Exception(UErrorHandler::UNAUTH_MSG);
             }


         }
         catch (Exception $err) {
             throw $err;
         }


     }

     public function canIDelete(MPost $post) {

         $ret = false;

         if ($this->isadmin == 1 || $post->getUserId() == $this->getId()) {

             $ret = true;

         }

         // var_dump($ret);

         return $ret;

     }

     /**
      * Aggiungi un utente da seguire
      *
      * @param integer $followed_id ID dell'utente da seguire
      * @throws Exception
      */
     public function addFollowed($followed_id) {

         if ($followed_id == $this->getId()) {
             throw new Exception(UErrorHandler::SELFFOLLOW_MSG);
         }

         $fuser = FUser::getInstance();

         $fuser->addFollowed($this, $followed_id);

     }

     /**
      * Smetti di seguire un utente
      *
      * @param $followed_id ID dell'utente che non si vuole più seguire
      * @throws Exception
      */
     public function removeFollowed($followed_id) {

         $fuser = FUser::getInstance();

         $fuser->removeFollowed($this, $followed_id);

     }

     /*

     public function alterPost(MPost $post, $newcontent) {

         if (($post->getUserId() === $this->getId()) || $this->isadmin == TRUE) {
             // autorizzato se a modificare è l'autore del post o un admin


             $post->setTextContent($newcontent);

             $fpost = FPost::getInstance();

             $fpost->update($post);


         }
         else {

             throw new Exception(UErrorHandler::UNAUTH_MSG);

         }

     }
     */

     /**
      * Rimuovi un qualsiasi utente che non sia admin
      *
      * @param $user_id ID dell'user da modificare
      */
     public function removeUser($user_id) {
         
         if ( ($user_id == $this->getId()) || $this->isadmin == TRUE){
            // e' autorizzato a cancellare un utente l'utente stesso o un admin

             $u=FUser::getInstance();
             $u->remove($user_id);
         }
         else{

             throw new Exception(UErrorHandler::UNAUTH_MSG);
         }
     }

     /**
      * Fai diventare admin un utente comune
      *
      * @param MUser $candidate Riferimento all'user da far diventare admin
      */
     public function changeStateAdmin(MUser $candidate) {
         if ($this->isadmin == TRUE){

             $u=FUser::getInstance();
             $u->changeStateAdmin($candidate);
         }
         else{

             throw new Exception(UErrorHandler::UNAUTH_MSG);
         }

     }

     /**
      * Richiesta dati utenti seguitivi
      * @param int $offset Offset nella risposta
      * @param int $range Range nella risposta
      * @return Array Dati followed
      * @throws Exception
      */
     public function getFollowed($offset = 0, $range = 5) {

         $fuser = FUser::getInstance();

         return $fuser->getFollowed($this, $offset, $range);

     }

     /**
      * Richiesta ID utenti seguiti
      * @return array Id utenti seguiti
      * @throws Exception
      */
     public function getFollowedID() {

         $fuser = FUser::getInstance();

         try {
             $ret = $fuser->getFollowedIds($this);
         }
         catch (Exception $e) {
             if ($e->getMessage() === UErrorHandler::EMPRYRESP_MSG) { // l'utente non ha followed
                 $ret = []; // torna array vuoto
             }
             else
                 throw $e;
         }

         return $ret;


     }


     /** Controlla che l'utente corrente sia attivo (presente nel db)
      * @return bool TRUE se attivo
      * @throws Exception
      */
     public function imStillActive() {

         $fuser = FUser::getInstance();

         $active = $fuser->userExists($this->id);

         return $active;

     }


     // --------------------------- getter / setter ---------------------------

     /**
      * Get del valore di Id
      *
      * @return integer
      */
     public function getId()
     {
         return $this->id;
     }

     /**
      * Set del valore di Id
      *
      * @param integer id
      *
      * @return self
      */
     public function setId($id)
     {
         $this->id = $id;

         return $this;
     }

     /**
      * Get del valore di Email
      *
      * @return string
      */
     public function getEmail()
     {
         return $this->email;
     }

     /**
      * Set del valore di Email
      *
      * Restituisce un eccezione se il valore non è valido
      *
      * @param string email Email dell'utente
      *
      */
     public function setEmail($email)
     {
         try {
             $this->validateAttribute('email',$email);
             $this->email = $email;
         }
         catch (Exception $err) {
             throw $err;
         }
     }

     /**
      * Get del valore di Password
      *
      * @return string
      */
     public function getPassword()
     {
         return $this->passwd;
     }

     /**
      * Set del valore di Password
      *
      * Restituisce un eccezione se il valore non è valido
      *
      * @param string $password Password utente
      * @param boolean $authomatic TRUE se l'inserimento è da database
      *
      */
     public function setPassword($password, $authomatic = FALSE)
     {
         try {
             if ($authomatic === FALSE) {

                 $this->validateAttribute('password',$password); // controllo di validità

                 $password = MUser::encryptPassword($password); // effettua encryption

             }


             $this->passwd = $password;
         }
         catch (Exception $err) {
             throw $err;
         }
     }

     /**
      * Get del valore di Name
      *
      * @return string
      */
     public function getName()
     {
         return $this->name;
     }

     /**
      * Set del valore di Name
      *
      * Restituisce un eccezione se il valore non è valido
      *
      * @param string name Nome dell'utente
      *
      */
     public function setName($name)
     {
         try {
             $this->validateAttribute('name',$name);
             $this->name = $name;
         }
         catch (Exception $err) {
             throw $err;
         }
     }

     /**
      * Get del valore di Surname
      *
      * @return string
      */
     public function getSurname()
     {
         return $this->surname;
     }

     /**
      * Set del valore di Surname
      *
      * Restituisce un eccezione se il valore non è valido
      *
      *
      * @param string surname Cognome dell'utente
      *
      */
     public function setSurname($surname)
     {
         try {
             $this->validateAttribute('surname',$surname);
             $this->surname = $surname;
         }
         catch (Exception $err) {
             throw $err;
         }
     }

     /**
      * Get del valore di Address
      *
      * @return string
      */
     public function getAddress()
     {
         return $this->address;
     }

     /**
      * Set del valore di Address
      *
      * @param string address
      *
      */
     public function setAddress($address)
     {
         $this->address = $address;
     }

     /**
      * Get del valore di Birth Date
      *
      * Ritorna in formato ISO
      *
      * @return string
      */
     public function getBirthDate()
     {
         return $this->birth_date;
     }

     /**
      * Set del valore di Birth Date
      *
      * @param string birth_date Data in formato ISO
      *
      */
     public function setBirthDate($birth_date)
     {
         try {
             $this->validateAttribute('dateISO',$birth_date);
             $this->birth_date = $birth_date;
         }
         catch (Exception $err) {
             throw $err;
         }

     }

     /** Get valore isadmin
      * @return int 1 se admin
      */
     public function getIsadmin()
     {
         return $this->isadmin;
     }

     /** Set valore isadmi
      * @param int $isadmin TRUE se l'utente è admin
      */
     public function setIsadmin($isadmin)
     {
         $this->isadmin = $isadmin;
     }

     /**
      * Get intero stato corrente dell'utente
      * @return array Stato dell'utente
      */
     public function getState() {

         $result = [];

         foreach ($this as $attribute => $value) {

             $result[$attribute] = $value;

         }

         return $result;

     }
     // ========================= METODI PUBBLICI =========================


     // ========================= METODI PRIVATI =========================

     /**
      * Permette di validare gli attributi che si vogliono imporre in set
      *
      * Attributi controllabili: email, password, email, name, surname
      *
      * @param     string $attribute tipo di attibuto
      * @param     string $value valore da controllare per l'attributo
      */
     private function validateAttribute($attribute, $value) {
         $is_valid = false;

         // espressioni regolari
         $regex = array(
             'email' => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
             // 'email' => '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',
             'password' => '/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20})$/',
             'name' => '/^[-a-zA-Z ]+$/',
             'surname' => '/^[-a-zA-Z ]+$/',
             'dateISO' => '/^[12][0-9]{3,3}-((0[1-9])|(1[0-2]))-(([012][0-9])|(3[01]))$/'
         );

         // controlla se c'è match
         if (preg_match($regex[$attribute], $value)) {
             $is_valid = true;
         }
         else
             throw new Exception("$attribute-not-valid");
     }

     // ========================= METODI PRIVATI =========================



}
