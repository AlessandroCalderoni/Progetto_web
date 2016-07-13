<?php
/**
 * Author: Alessandro Calderoni, Antonio Tuzi
 * Date:2016-06-17
 * License: GNUgpl3
 * email: a.calderoni@hotmail.it, antoniotuzi@alice.it
 */

class CHome Extends USingleton{

    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe
    

    // ========================= METODI PUBBLICI =========================

    /**
     * Punto di inizio di tutta l'applicazione
     */
    public function start() {


        // gestore dell'interfaccia
        $vhome = VHome::getInstance();

        // wrapp dell'evento
        $event = VHome::generateEvent();

        try {


            $error = $event->getPayload(UErrorHandler::SGN_ERR);

            if (isset($error)) { // "corsia preferenziale" per errori di inizializzazione
                throw new Exception($error);
            }

            // controllo di login
            $cuser = CUser::getInstance();
            $logged = $cuser->isLogged();


            // utente sta cercando di loggarsi?
            $is_login_attempt = ($logged === FALSE) && ($event->getEnvironment() === 'user' && ($event->getOperation() === 'login'));

            // utente sta cercando di registrarsi?
            $is_register_attempt = ($event->getEnvironment() === 'user' && ($event->getOperation() === 'register'));

            // sta cercando login pic
            $aux_pic =($event->getEnvironment() === 'image' && ($event->getOperation() === 'aux_pic'));

            // controllo unicità mail
            $unique_mail = ($event->getEnvironment() === 'user' && ($event->getOperation() === 'unique_mail'));



            if ($logged === true) {

                // update della sessione
                $aj =  $event->getPayload('ajax');
                $env = $event->getEnvironment();
                $is_ajax = ($aj !== NULL);
                $is_img = ($env === 'image');
                

                if (!($is_ajax || $is_login_attempt || $is_register_attempt || $is_img)) { // se non è uno di questi casi

                    // controlla se l'utente è ancora nel db
                    $logged = $cuser->controlActive();
                    //var_dump($logged);

                }

            }

            if ($logged === TRUE || $is_login_attempt === TRUE || $is_register_attempt === TRUE  || $aux_pic === TRUE || $unique_mail === TRUE) { // se l'utente è loggato o sta cercando di loggarsi

                $result = $this->rail($event); // instrada l'evento

            }
            else { // altrimenti mostra la pagina di login

                $vuser_guest = VUser::getInstance();

                $result = $vuser_guest->renderGuest();

            }

        }
        catch (Exception $e) { // eccezione generica non gestita

            $result = $this->manageError($e, $event); // gestisci l'evento generico che arriva
        }


       $vhome->render($result);



    }

    /**
     * Instradatore di eventi
     *
     * @param UEvent $event Evento da gestire
     */
    public function rail(UEvent $event) {

        $result = null;

        try {

            switch ($event->getEnvironment()) {

                case 'user':
                    $controller = CUser::getInstance();
                    $result = $controller->rail($event);
                    break;

                case 'post':
                    $controller = CPost::getInstance();
                    $result = $controller->rail($event);
                    break;

                case 'image':
                    $controller = CImage::getInstance();
                    $controller->rail($event);
                    break;

                default: // se c'è un inserimento non valido
                    throw new Exception(UErrorHandler::NOSENSEQUERY_MSG);

            }

        }
        catch (Exception $err) {

            throw $err;

        }

        return $result;

    }

    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================

    /**
     * Gestione degli errori che non sono stati gestiti diversamente
     *
     * @param Exception $error Errore non gestito
     * @param UEvent $event Evento
     * @return array/string Risposta renderizzata
     * @throws Exception
     */
    private function manageError(Exception $error, UEvent $event) {

        if ($event->getPayload('ajax')) { // se è richiesta ajax, restituisce un array

            $response = [UErrorHandler::SGN_ERR => $error->getMessage()];

        }
        else { // altrimenti imposta la pagina di errore

            $vhome = VHome::getInstance();

            switch ($error->getMessage()) {

                case UErrorHandler::DBNR_MSG:
                    $message = 'Abbiamo problemi con il nostro database che non risponde!';
                    break;

                case UErrorHandler::FAILQUERY_MSG:
                case UErrorHandler::NOSENSEQUERY_MSG:
                    $message = 'Hai fatto una richiesta inconsistente!';
                    break;

                default:
                    $message = 'Scusaci, abbiamo sbagliato qualcosa!';
                    break;

            }

            $vhome->addError($message);
            $response = $vhome->renderError();


        }

        return $response;
    }

    // ========================= METODI PRIVATI =========================

}
