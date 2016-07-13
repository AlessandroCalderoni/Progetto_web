<?php
/**
 * Author: Alessandro Calderoni, Antonio Tuzi
 * Date:2016-06-17
 * License: GNUgpl3
 * email: a.calderoni@hotmail.it, antoniotuzi@alice.it
 */
class CPost Extends USingleton {

    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe
    protected static $is_initialized = TRUE; // indica se si può instanziare (singleton)


    // ========================= METODI PUBBLICI =========================
    /**
     * Instradatore di eventi
     *
     * @param UEvent $event Evento da gestire
     */
    public function rail(UEvent $event) {

        $result = null;

        switch ($event->getOperation()) {

            case 'getother':
                $result = $this->showOtherPost($event);
                break;

            case 'addpost':
                $result = $this->addPost($event);
                break;

            case 'addcomment':
                $result = $this->addComment($event);
                break;

            case 'getothercomments':
                $result = $this->getOtherComments($event);
                break;

            case 'remove':
                $result = $this->removePost($event);
                break;

            default:
                throw new Exception(UErrorHandler::NOSENSEQUERY_MSG);


        }

        return $result;
    }


    /**
     * Chiedi nuovi post per un utente specificato
     *
     * Indicare:
     * - owner: id utente (oppure 'self' per l'utente loggato, 'followed' per gli utenti followed)
     * - offset
     * - range
     *
     * @param mixed $owner id_owner
     * @return array Array di post da visualizzare
     * @throws Exception Errore generico
     */
    public function getPost($owner = "self", $offset = 0, $range = 5) {


        $session = USession::getInstance(); // dati utente
        $us = $session->getUserStatus();


        $fpost = FPost::getInstance();

        // var_dump($owner);

        if ($owner === 'self' || $owner === 'followed') { // se è l'utente loggato

            $us_id = $us->getId();
        }
        else {
            $us_id = intval($owner);
        }

        // var_dump($us_id);

        $arr_post = [];
        try {
            if ($owner === 'followed') {
                // echo 'ciao';
                $arr_post = $fpost->getFollowedPosts($us, $offset, $range );
            }

            else
                $arr_post = $fpost->getUserPosts($us_id, $offset, $range);


            foreach ($arr_post as &$post) { // ritorna lo stato del post come array

                $isdeletable = $us->canIDelete($post); // controlla se user ha i diritti di cancellazione
                $post = $post->getState();

                $post['delete'] = $isdeletable;



            }
            if (sizeof($arr_post) < $range) { // se si hanno meno item di quelli richiesti, indica la fine delle risposte
                $arr_post[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::NOMORE_MSG;
            }
        }
        catch (Exception $e) {

            if ($e->getMessage() === UErrorHandler::EMPRYRESP_MSG) { // se la risposta è vuota
                $arr_post = [];
            }
            else {
                throw $e;
            }
        }

        return $arr_post;


    }

    /** Richiesta altri post da visualizzare
     * @param UEvent $event Evento da gestire
     * @return array Array di post
     * @throws Exception
     */
    public function showOtherPost(UEvent $event) {

        $owner = $event->getPayload('owner');
        $offset = $event->getPayload('offset');
        $range = $event->getPayload('range');

        return $this->getPost($owner, $offset, $range);

    }

    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================


    /**
     * Aggiunta di un commento
     * @param UEvent $event Evento di aggiunta ---> text del commento, post_id del post padre
     * @return array Risposta (formato utile per JSON)
     * @throws Exception
     */
    private function addComment(UEvent $event) {

        $text = $event->getPayload('text'); // testo del commento
        $post_id = $event->getPayload('post_id'); // testo del commento

        $sess = USession::getInstance();

        $commenter = $sess->getUserStatus();


        $response = [];
        try {
            $comment = $commenter->makeComment($post_id, $text);
            $response[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::SUCCESS_MSG;
            $response['user_id'] = $commenter->getId();
            $response['user_name'] = $commenter->getName() . " " . $commenter->getSurname();
            $response['date_h_readable'] = $comment->getDateLastChangeHumanReadable();
            $response['text_content'] = $comment->getTextContent();
            $response['post_id'] = $comment->getPostId();

        }
        catch (Exception $e) {

            $response[UErrorHandler::SGN_ERR] = UErrorHandler::INTERROR_MSG;

        }


        return $response;

    }

    /**
     * Eliminazione di un post o di un commento dal database
     *
     * Paramentro 'toremove': id del post/commento da cancellare
     *
     * @param UEvent $event Evento instradato
     * @return array Array di risposta per AJAX
     * @throws Exception
     */
    private function removePost (UEvent $event) {

        $session = USession::getInstance();
        $user = $session->getUserStatus();

        $id_post = $event->getPayload('toremove'); // id post da cancellare

        $result = [];

        try {

            $user->removePostComment($id_post);
            $result[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::SUCCESS_MSG;

        }
        catch (Exception $e) {

            if ($e->getMessage() === UErrorHandler::UNAUTH_MSG) {
                $result[UErrorHandler::SGN_ADDITIONAL] = $e->getMessage();
            }
            else
                throw $e;

        }

        return $result;

    }


    /**
     * Aggiungi un post
     * @param UEvent $event Evento di aggiunta di un post --> text del post, img opzionale
     * @return string Rendering del profilo
     * @throws Exception
     */
    private function addPost(UEvent $event) {


        $cuser = CUser::getInstance();

        $text = $event->getPayload('text'); // testo del post
        $img_data = $event->getPayload('img')['image']; // una sola immagine per post
        // var_dump($img_data);

        $sess = USession::getInstance();

        $user = $sess->getUserStatus();

        try {

            // gestione dell'immagine
            if (isset($img_data) && $img_data['error'] !== 4) {
                $image = new UImage();
                $image->encapsuleImage($img_data['tmp_name'], $img_data['size']);
                $image->setDoctype($img_data['type']);
            }
            else {
                $image = null;
            }


            // var_dump($image);

            $user->makePost($text, $image);

        }
        catch (Exception $err) {

            $vpost = VPost::getInstance();

            if ($err->getMessage() === UErrorHandler::IMGTOOBIG_MSG) {

                $vpost->addError("Il post non è stato inserito perchè l'immagine è troppo grande");

            }
            elseif ($err->getMessage() === UErrorHandler::ERRORDOCTYPE_MSG) {
                $vpost->addError("Formato file non supportato [solo Jpeg e PNG] ");
            }
            else {
                $vpost->addError("Il post non è stato inserito per errori interni");

            }

        }

        // aggiungi all'evento un campo user per far tornare il profilo dell'utente
        $event->addPayload('user', 'self');

        // var_dump($event);
        return $cuser->profile($event);



    }


    /** Richiesta ulteriori commenti
     * @param UEvent $event Evento di richiesta --> parent id del post padre, offset dall'inizio dei commenti, range dall'offset
     * @return array Dati dei commenti
     * @throws Exception
     */
    private function getOtherComments(UEvent $event) {

        $fpost = FPost::getInstance();

        // var_dump($event);

        $parent = $event->getPayload('parent');
        $offset = $event->getPayload('offset');
        $range = $event->getPayload('range');

        $arr_comment = [];

        try {
            // sleep(20);
            $arr_comment = $fpost->fetchComments($parent, $offset, $range);

            foreach ($arr_comment as &$post) {
                $post = $post->getState();
            }
            if (sizeof($arr_comment) < $range) { // se si hanno meno item di quelli richiesti, indica la fine delle risposte
                $arr_comment[UErrorHandler::SGN_ADDITIONAL] = UErrorHandler::NOMORE_MSG;
            }
        }
        catch (Exception $e) {

            if ($e->getMessage() === UErrorHandler::EMPRYRESP_MSG) { // se la risposta è vuota
                $arr_comment = [];

            }
            else {
                throw $e;
            }
        }

        return $arr_comment;

    }
    

    // ========================= METODI PRIVATI =========================
}

