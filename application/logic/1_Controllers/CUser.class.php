<?php
/**
 * Author: Alessandro Calderoni, Antonio Tuzi
 * Date:2016-06-17
 * License: GNUgpl3
 * email: a.calderoni@hotmail.it, antoniotuzi@alice.it
 */
class CUser Extends USingleton {

    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe
    protected static $is_initialized = TRUE; // indica se si può instanziare (singleton)

    const POST_OFFSET = 0;
    const POST_RANGE = 8;

    // ========================= METODI PUBBLICI =========================
    /**
     * Instradatore di eventi
     *
     * @param UEvent $event Evento da gestire
     */
    public function rail(UEvent $event) {

        try {

            $result = null;

            // var_dump($event);

            switch ($event->getOperation()) {
                case 'register':
                    $result = $this->register($event);
                    break;

                case 'login':
                    $result = $this->login($event);
                    break;

                case 'logout':
                    $result = $this->logout();
                    break;

                case 'homepage':
                    $result = $this->homepage();
                    break;

                case 'profile':
                    $result = $this->profile($event);
                    break;

                case 'modifyme':
                    $result = $this->modify($event);
                    break;

                case 'viewtomodify':
                    $result = $this->viewToModify();
                    break;

                case 'myfollowed':
                    $result = $this->myFollowedList();
                    break;

                case 'otherfollowed':
                    $result = $this->getOtherFollowed($event);
                    break;

                case 'remove':
                    $result = $this->removeUser($event);
                    break;

                case 'follow':
                    $result = $this->addFollowed($event);
                    break;

                case 'unfollow':
                    $result = $this->removeFollowed($event);
                    break;

                case 'search':
                    $result = $this->search($event);
                    // var_dump($result);
                    break;

                case 'searchother':
                    $result = $this->searchother($event);
                    break;

                case 'register_confirm':
                    $result = $this->userConfirmation($event);
                    break;

                case 'promote_demote':
                    $result = $this->adminPromoteDemote($event);
                    break;

                case 'unique_mail':
                    $result = $this->uniqueMail($event);
                    break;

                default:
                    throw new Exception(UErrorHandler::NOSENSEQUERY_MSG);
            }

            return $result;

        }
        catch (Exception $err) {
            throw $err;
        }
    }

    /**
     * Controlla se l'utente è loggato
     *
     * @return bool TRUE se loggato
     */
    public function isLogged() {

        $logged = false;

        $session = USession::getInstance();
        $session->start();

        $usr = $session->getUserStatus();

        if (isset($usr) === TRUE) {
            $logged = TRUE;
        }
        else {
            $session->stop(); // se l'utente non è loggato chiudi la sessione
        }

        return $logged;

    }

    /** Controllo che l'utente sia ancora attivo
     * @return bool FALSE se l'utente non è più presente
     */
    public function controlActive() {

        $fuser = FUser::getInstance();
        $sess = USession::getInstance();
        $user = $sess->getUserStatus();


        $still_here = false; // default per sicurezza

        $still_here = $user->imStillActive();

        if ($still_here === FALSE) { // se l'utente non è attivo, chiudi la sessione
            $sess->stop();
        }

        return $still_here;
        
        
    }


    /**
     * Visualizzazione di un profilo utente
     * @param UEvent $event Richieta profilo --> user è l'id dell'utente richiesto ('self' per quello loggato)
     * @return string Rendering del profilo
     * @throws Exception
     */
    public function profile(UEvent $event) {

        $vhome = VHome::getInstance();
        $vuser = VUser::getInstance();
        $vpost = VPost::getInstance();

        $cpost = CPost::getInstance();

        $id_user = $event->getPayload('user');

        if ($id_user == 'self') {
            $arr_status = $this->userStatus(null); // stato completo dell'utente loggato
            $owner_sidebar = TRUE;
        }
        else {
            $arr_status = $this->userStatus($id_user); // stato completo dell'utente
            $owner_sidebar = FALSE;
        }



        // var_dump($arr_status);

        // carica 8 post dell'utente
        $arr_posts = $cpost->getPost($id_user, self::POST_OFFSET, self::POST_RANGE);

        // var_dump($arr_posts);

        // assegna un nome utente ad ogni post
        foreach ($arr_posts as $key => &$post) {

            if ($key !== UErrorHandler::SGN_ADDITIONAL && $key !== UErrorHandler::SGN_ERR) {
                $post['user_name'] = $arr_status['name'] . " " . $arr_status['surname'];
            }

        }

        // var_dump($arr_posts);

        $more_post = 1;

        $nomore_fol = $arr_posts[UErrorHandler::SGN_ADDITIONAL] == UErrorHandler::NOMORE_MSG;
        if ($nomore_fol === TRUE) {

            $more_post = 0;
            //$vpost->addPositiveLog('Non ci sono altri post da visualizzare!');
            unset($arr_posts[UErrorHandler::SGN_ADDITIONAL]);

        }

        if(count($arr_posts) === 0) {

            $more_post = 0;
            $vpost->addError('Non ci sono post finora!');

        }


        $to_render = $vhome->renderTopbar(); // rendering topbar

        $to_render .= $vuser->renderSidebar($arr_status, $owner_sidebar); // sidebar

        $to_render .= $vpost->renderPostList($arr_posts, $more_post); // rendering della lista di post


        $to_render .= $vhome->renderBottombar();

        return $to_render;

    }

    /**
     * Ricerca utenti nel database
     * @param UEvent $event Evento di ricerca --> search è la stringa di ricerca, con offset e range
     * @return array Risposta con i dati trovati
     * @throws Exception
     */
    public function searchOther(UEvent $event) {

        $fus = FUser::getInstance();

        $sess = USession::getInstance();

        $current_user = $sess->getUserStatus();

        // ci facciamo dare la lista degli id dei followed
        $arr_id_followed = $current_user->getFollowedID();

        // var_dump($arr_id_followed);

        $str_search = $event->getPayload('search');

        $offset = $event->getPayload('offset');
        $range = $event->getPayload('range');


        $res = [];
        try {
            $arr_user = $fus->smartNameSurnameFind($str_search, $offset, $range);
            
            if (count($arr_user) < $range) {

                $res[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::NOMORE_MSG;
            }



            foreach ($arr_user as &$user) {

                if ($user->getId() === $current_user->getID()) { // non mostrare te stesso nella lista dei risultati
                    unset($user);
                }
                else {

                    $row = [];

                    $row['id'] = $user->getId();
                    $row['completename'] = $user->getName() . ' ' . $user->getSurname();
                    $row['email'] = $user->getEmail();
                    $row['isadmin'] = $user->getIsadmin();

                    // var_dump($arr_id_followed);
                    $row['followed'] = in_array($user->getId(), $arr_id_followed, TRUE);

                    // var_dump($row);
                    $res[] = $row;

                }

            }
        }
        catch (Exception $e) {

            if ($e->getMessage() === UErrorHandler::EMPRYRESP_MSG) {
                $res = [];
            }
            else {
                throw $e;
            }

        }

        return $res;

    }

    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================


    /**
     * Promozione o degradamento di admin
     * @param UEvent $event Evento di promozione/degrado --> candidate è l'id del candidato, dest indica il suo destino (1 se promosso, 0 se degradato)
     * @return array Risposta del server
     * @throws Exception
     */
    private function adminPromoteDemote(UEvent $event) {

        $fus = FUser::getInstance();

        $sess = USession::getInstance();
        $us_maker = $sess->getUserStatus();

        $candidate_id = intval($event->getPayload('candidate'));

        // var_dump($candidate_id);

        $destiny = $event->getPayload('dest');

        // var_dump($destiny);

        $candidate = $fus->fetch($candidate_id);
        $candidate->setIsadmin($destiny);

        $res = [];
        try {
            $us_maker->changeStateAdmin($candidate);
            $res[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::SUCCESS_MSG;
        }
        catch (Exception $e) {
            if ($e->getMessage() === UErrorHandler::UNAUTH_MSG) {
                $res = [];
            }
            else
                throw $e;
        }

        return $res;

    }

    /** Ricerca di utenti (versione grafica)
     * @param UEvent $event Evento di ricerca analogo a searchother ma non prevede offset e range
     * @return string Lista di utenti renderizzata
     * @throws Exception
     */
    private function search(UEvent $event) {

        $vus = VUser::getInstance();
        $vhome = VHome::getInstance();

        $sess = USession::getInstance();
        $user = $sess->getUserStatus();

        $isadmin = $user->getIsAdmin();

        $str_search = $event->getPayload('search');


        if (empty($str_search)) {

            $vus->addError('Parametro di ricerca vuoto');

            $arr_users = [];
            $more_usr = 0;

        }
        else {

            $event->addPayload('offset', 0);
            $event->addPayload('range', 6);

            $arr_users = $this->searchOther($event);

            $nomore_users = $arr_users[UErrorHandler::SGN_ADDITIONAL] == UErrorHandler::NOMORE_MSG;
            // var_dump($arr_users[UErrorHandler::SGN_ADDITIONAL]);
            $more_usr = 1; // ci sono altri utenti
            if ($nomore_users === TRUE) {

                $more_usr = 0;
                unset($arr_users[UErrorHandler::SGN_ADDITIONAL]);

            }

            if(count($arr_users) === 0) { // risposta vuota
                $more_usr = 0;
                $vus->addError('Nessun risultato nella ricerca');
            }

        }

        $to_render = $vhome->renderTopbar($str_search); // rendering topbar
        $to_render .= $vus->renderFollowList($arr_users, $more_usr, $isadmin);
        $to_render .= $vhome->renderBottombar();

        return $to_render;



    }

    /**
     * Registra un nuovo utente
     *
     * @param UEvent $event Evento contenente i dati
     * @throws Exception
     */
    private function register(UEvent $event) {

        $vuser = VUser::getInstance();

        $error = FALSE; // se c'è stato un errore nella registrazione

        $fuser = FUser::getInstance();

        $arr_inserted = [];
        $arr_inserted['email'] = $event->getPayload('email');
        $arr_inserted['firstname'] = ucfirst($event->getPayload('firstname')); // nome capitalized
        $arr_inserted['lastname'] = ucfirst($event->getPayload('lastname')); // cognome capitalized
        $arr_inserted['password'] = $event->getPayload('password');
        $arr_inserted['password_conf'] = $event->getPayload('password-confirm');
        $arr_inserted['addr'] = $event->getPayload('address');
        $arr_inserted['brt_date'] = $event->getPayload('birthdate');


        $image = $event->getPayload('img')['user_pic']; // immagine di utente


        if (isset($image) && $image['error'] === 4) { // non è stata inviata nessuna immagine
            $image = null;
        }

        if (isset($image) && $image['error'] !== 0) {
            $error = TRUE;
            $vuser->addError("Errore di upload per l'immagine!");
            $image = null;
        }

        if (isset($image)) { // se è stata caricata l'immagine
            try {

                $objimg = new UImage();
                $objimg->setDoctype($image['type']);
                $objimg->encapsuleImage($image['tmp_name'], $image['size']);

            }
            catch (Exception $e) {

                if ($e->getMessage() === UErrorHandler::IMGTOOBIG_MSG) {
                    $vuser->addError("Immagine troppo grande");
                }

                if ($e->getMessage() === UErrorHandler::ERRORDOCTYPE_MSG) {
                    $vuser->addError("Formato immagine non accettato!");
                }

                $error = TRUE;

            }

        }
        else {
            $image = null;
        }


        // instanziazione e inizializzazione di un nuovo utente
        $us = new MUser();

        try {

            $us = $this->userDataInsert($us, $arr_inserted);

            $fuser->save($us, $objimg);

            $vuser->addPositiveLog("Registrato con successo");

        }
        catch (Exception $err) {

            $error = TRUE;
            $vuser->addError("L'inserimento non è andato a buon fine");

        }

        if ($error === FALSE) { // se non c'è errore
            $arr_inserted = null; // non rivisualizzare i vecchi valori
        }

        $result = $vuser->renderGuest(null, $arr_inserted); // se c'è errore visualizza vecchi valori di registrazione
        // null è per i vecchi valori di login

        return $result; // metti in visualizzazione del login

    }

    /**
     * Gestione del login
     *
     * @param UEvent $event Evento contenente email e password
     * @throws Exception
     */
    private function login(UEvent $event) {

        $fuser = FUser::getInstance();
        $vuser = VUser::getInstance();

        $email = $event->getPayload('email');
        $passwd = MUser::encryptPassword($event->getPayload('passwd')); // traduci in md5 la password ricevuta

        try {

            $user = $fuser->fetch($email); // retrieve dell'utente dal db

            if ($passwd == $user->getPassword()) { // ok

                // dai inizio alla sessione
                $sess = USession::getInstance();
                $sess->start();
                $sess->setUserStatus($user);

                // vai alla homepage
                $cuser = CUser::getInstance();
                $ret = $cuser->homepage();

            }
            else {
                throw new Exception(UErrorHandler::WREPASS_MSG);
            }

        }
        catch (Exception $e) {

            if ($e->getMessage() === UErrorHandler::EMPRYRESP_MSG) {

                $vuser->addError('Email errata!');

            }
            elseif ($e->getMessage() === UErrorHandler::WREPASS_MSG) {
                $vuser->addError('Password errata!');
            }
            else {
                throw $e;
            }

            $ret = $vuser->renderGuest(['email' => $email]); // visualizza di nuovo la login con il vecchio valore di email
        }

        return $ret;


    }

    /**
     * Effettua logout e vai su pagina di login
     *
     * @return string Stringa della pagina di login renderizzata da smarty
     * @throws Exception
     */
    private function logout() {

        $sess = USession::getInstance();

        $sess->stop();

        $vuser = VUser::getInstance();

        $vuser->addPositiveLog('LOG OUT effettuato con successo! Arrivederci!');

        return $vuser->renderGuest();
    }

    /**
     * Gestione rimozione di un utente
     * @param UEvent $event Evento di rimozione --> toremove è l'id dell'utente da rimuovere
     * @return array Risposta del server
     * @throws Exception
     */
    private function removeUser(UEvent $event) {
        
        $id_user = $event->getPayload('toremove'); // id utente da cancellare

        $sess = USession::getInstance();

        $user = $sess->getUserStatus();

        $result = [];

        try {

            $user->removeUser($id_user);
            $result[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::SUCCESS_MSG;

        }
        catch (Exception $e) {

            if ($e->getMessage() === UErrorHandler::UNAUTH_MSG) {
                $result[UErrorHandler::SGN_ERR] = $e->getMessage();
            }
            else
                throw $e;

        }

        return $result;

    }

    /**
     * Gestione della homepage
     * @return string Rendering della homepage
     * @throws Exception
     */
    private function homepage() {

        $vhome = VHome::getInstance();
        $vuser = VUser::getInstance();
        $vpost = VPost::getInstance();
        $cpost = CPost::getInstance();

        $arr_status = $this->userStatus(null); // stato completo dell'utente loggato

        $arr_fol_post = $cpost->getPost('followed', self::POST_OFFSET, self::POST_RANGE); // retrieve dei post dei followed

        $more_post = 1; // 1 se ci sono altri post da poter ottenere

        $nomore_fol = $arr_fol_post[UErrorHandler::SGN_ADDITIONAL] == UErrorHandler::NOMORE_MSG;
        if ($nomore_fol === TRUE) {

            $more_post = 0;
            // $vpost->addPositiveLog('Non ci sono altri post da visualizzare!');
            unset($arr_fol_post[UErrorHandler::SGN_ADDITIONAL]);

        }

        if(count($arr_fol_post) === 0) { // risposta vuota

            $more_post = 0;
            $vpost->addError('Nessuno dei follower ha postato!');


        }

        $to_render = $vhome->renderTopbar(); // rendering topbar

        $to_render .= $vuser->renderSidebar($arr_status); // sidebar

        $to_render .= $vpost->renderPostList($arr_fol_post, $more_post); // rendering della lista di post

        $to_render .= $vhome->renderBottombar();

        return $to_render;

    }

    /**
     * Gestione lista followed
     * @return string Rendering della lista dei followed
     * @throws Exception
     */
    private function myFollowedList() {

        // controlla se l'utente è admin
        $sess = USession::getInstance();
        $user = $sess->getUserStatus();
        $isadmin = $user->getIsAdmin();

        $vuser = VUser::getInstance();
        $vhome = VHome::getInstance();

        // evento fittizio per ottenere i dati dei primi 5 amici
        $ev = new UEvent();
        $ev->addPayload('offset', 0);
        $ev->addPayload('range', 6);

        $data = $this->getOtherFollowed($ev);

        $more_followed = 1; // vero se non sono stati visualizzati tutti i followed

        $nomore_fol = $data[UErrorHandler::SGN_ADDITIONAL] == UErrorHandler::NOMORE_MSG;
        if ($nomore_fol === TRUE) {

            // var_dump($nomore_fol);
            $more_followed = 0;
            // $vuser->addPositiveLog('Non ci sono altri followed da visualizzare!');
            unset($data[UErrorHandler::SGN_ADDITIONAL]);

        }

        if(count($data) === 0) {
            $more_followed = 0;
            $vuser->addPositiveLog('Non hai followed!');

        }

        $to_render = $vhome->renderTopbar();
        $to_render .= $vuser->renderFollowList($data, $more_followed, $isadmin);
        $to_render .= $vhome->renderBottombar();

        return $to_render;

    }

    private function userStatus($id_user = null) {

        if ($id_user === null) { // utente loggato

            $sess = USession::getInstance();

            $user = $sess->getUserStatus();

        }
        else { // un altro utente

            $fuser = FUser::getInstance();

            $user = $fuser->fetch(intval($id_user));

        }


        return $user->getState();

    }

    /**
     * Gestisce richiesta AJAX di aggiunta di un nuovo followed
     *
     * Parametro 'id': id dell'utente da seguire
     *
     * @param UEvent $event Evento da gestire
     * @return array Risposta AJAX
     * @throws Exception
     */
    private function addFollowed(UEvent $event) {

        $id_followed = $event->getPayload('id');

        $sess = USession::getInstance();

        $us = $sess->getUserStatus();

        $res = []; // risultato

        try {
            $us->addFollowed($id_followed);
            $res[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::SUCCESS_MSG;
        }
        catch (Exception $e) {
            if ($e->getMessage() === UErrorHandler::SELFFOLLOW_MSG) {
                $res = []; // in ajax non è possibile seguire sè stessi
            }
            else
                throw $e;
        }

        return $res;

    }

    /**
     * Gestisce richiesta AJAX di rimozione di un followes
     *
     * Parametro 'id': id dell'utente da non seguire più
     *
     * @param UEvent $event Evento da gestire
     * @return array Risposta AJAX
     * @throws Exception
     */
    private function removeFollowed(UEvent $event) {

        $id_followed = $event->getPayload('id');

        $sess = USession::getInstance();

        $us = $sess->getUserStatus();

        $us->removeFollowed($id_followed);
        $res[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::SUCCESS_MSG;

        return $res;

    }

    /**
     * Richiesta ulteriori utenti followed
     * @param UEvent $event Evento di richiesta ---> offset e range
     * @return array Dati dei followed
     * @throws Exception
     */
    private function getOtherFollowed(UEvent $event) {

        $offset = $event->getPayload('offset');
        $range = $event->getPayload('range');

        $sess = USession::getInstance();

        $us = $sess->getUserStatus();

        $res = []; // risposta

        try {

            $arr_followed = $us->getFollowed($offset, $range);

            if (count($arr_followed) < $range) {
                $res[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::NOMORE_MSG;
            }

            foreach ($arr_followed as $followed) {

                $row = [];

                $row['id'] = $followed->getId();
                $row['completename'] = $followed->getName() . ' ' . $followed->getSurname();
                $row['email'] = $followed->getEmail();
                $row['followed'] = TRUE;
                $row['isadmin'] = $followed->getIsadmin();

                $res[] = $row;

            }

        }
        catch (Exception $e) {

            if($e->getMessage() === UErrorHandler::EMPRYRESP_MSG) { // risposta vuota
                // non fare nulla, restituisce l'array vuoto
            }
            else {
                throw $e;
            }

        }


        return $res;

    }

    private function userConfirmation (UEvent $event) {

        // TODO conferma utente
    }

    /**
     * Modifica dell'utente
     * @param UEvent $event Evento di modifica con tutti i dati utente -->
     * option: data-user --> email, password, firstname, lastname, password-confirm, address, birthdate
     * option: img-user --> img
     * @return string PAgina di modifica renderizzata
     * @throws Exception
     */
    private function modify(UEvent $event) {

        $sess = USession::getInstance();

        $vuser = VUser::getInstance();


        $us = $sess->getUserStatus();

        $type = $event->getPayload('option');

        if ($type === 'data-user') {

            $arr_inserted = [];
            $arr_inserted['email'] = $event->getPayload('email');
            $arr_inserted['firstname'] = $event->getPayload('firstname');
            $arr_inserted['lastname'] = $event->getPayload('lastname');
            $arr_inserted['password'] = $event->getPayload('password');
            $arr_inserted['password_conf'] = $event->getPayload('password-confirm');
            $arr_inserted['addr'] = $event->getPayload('address');
            $arr_inserted['brt_date'] = $event->getPayload('birthdate');



            try {

                $user_new_data = $this->userDataInsert($us, $arr_inserted);

                // var_dump($user_new_data->getState());

                $fuser = FUser::getInstance();

                $fuser->update($user_new_data);

                $sess->setUserStatus($user_new_data); // aggiorna la sessione

            }
            catch (Exception $e) {

                $vuser->addError('Modifica non effettuata');

            }


        }
        elseif ($type === 'img-user') {

            $image = $event->getPayload('img')['user_pic']; // immagine di utente

            if (isset($image) && $image['error'] !== 0) {
                $vuser->addError("Errore di upload per l'immagine!");
                $image = null;
            }

            if (isset($image)) { // se è stata caricata l'immagine
                try {

                    $objimg = new UImage();
                    $objimg->setOwner($us->getId()); // assegna il proprietario all'immagine [l'utente corrente]
                    $objimg->setDoctype($image['type']);
                    $objimg->encapsuleImage($image['tmp_name'], $image['size']);

                }
                catch (Exception $e) {

                    if ($e->getMessage() === UErrorHandler::IMGTOOBIG_MSG) {
                        $vuser->addError("Immagine troppo grande");
                    }

                    if ($e->getMessage() === UErrorHandler::ERRORDOCTYPE_MSG) {
                        $vuser->addError("Formato immagine non accettato!");
                    }

                    $objimg = null;

                }

            }

            if (isset($objimg)) {

                $fimage = FImage::getInstance();

                $fimage->update($objimg);

            }

        }
        else {
            throw new Exception(UErrorHandler::NOSENSEQUERY_MSG);
        }


        return $this->viewToModify();

    }

    /**
     * Visualizzazione pagina modifica utente con vecchi dati
     *
     * @return string Pagina di modifica renderizzata
     * @throws Exception
     */
    private function viewToModify() {

        $vuser = VUser::getInstance();
        $vhome = VHome::getInstance();

        $sess = USession::getInstance();

        $us = $sess->getUserStatus();

        $to_render = $vhome->renderTopbar(); // rendering topbar
        $to_render .= $vuser->renderProfileToModify($us->getState());
        $to_render .= $vhome->renderBottombar(); // rendering bottombar

        return $to_render;
    }

    /**
     * Modifica dell'utente
     *
     * @param MUser $us Utente da modifcare
     * @param $arr_inserted Nuovi dati utente array associativo
     * @return MUser Utente modificato
     * @throws Exception
     */
    private function userDataInsert(MUser &$us, $arr_inserted) {

        $vuser = VUser::getInstance();

        try {

            if ($us->getEmail() !== $arr_inserted['email']) {

                $fuser = FUser::getInstance();

                $used = $fuser->isEmailUsed($arr_inserted['email']);

                if ($used === TRUE) {

                    throw new Exception('used-email');

                }
            }

            $us->setEmail($arr_inserted['email']);

        }
        catch (Exception $e) {

            if ($e->getMessage() === 'used-email') {
                $vuser->addError("Email già in uso");
            }
            else {
                $vuser->addError("Email non valida");
            }

            throw $e;
        }

        try {
            if ($arr_inserted['password'] !== $arr_inserted['password_conf']) {
                throw new Exception('not-equal');
            }
            $us->setPassword($arr_inserted['password']);
        }
        catch (Exception $e) {

            if ($e->getMessage() === 'not-equal') {
                $vuser->addError("Le due password non corrispondono");
            }
            else {
                $vuser->addError("Password in formato non valido");
            }

            throw $e;
        }

        try {
            $us->setName($arr_inserted['firstname']);
            $us->setSurname($arr_inserted['lastname']);

        }
        catch (Exception $e) {
            $vuser->addError("Inserire un nome valido");
            throw $e;
        }

        $us->setAddress($arr_inserted['addr']);

        try {
            $us->setBirthDate($arr_inserted['brt_date']);
        }
        catch (Exception $e) {
            $vuser->addError("Data di nascita in formato non valido");
            throw $e;
        }

        return $us;

    }

    /**
     * Controlla se l'email è sta usata
     *
     * @param UEvent $ev Evento da gestire
     * @return array Risposta AJAX
     * @throws Exception
     */
    private function uniqueMail(UEvent $ev) {

        $res = [];
        $mail = $ev->getPayload('mail');

        $fuser = FUser::getInstance();

        $res[UErrorHandler::SGN_ADDITIONAL] = $fuser->isEmailUsed($mail);

        return $res;

    }

    // ========================= METODI PRIVATI =========================
}

