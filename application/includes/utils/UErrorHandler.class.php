<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 19/06/16
 * Time: 09:19
 */
class UErrorHandler Extends USingleton {

    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe




    // ========================= COSTANTI =========================

    // segnalazioni
    const SGN_ERR = 'error';
    const SGN_FATAL = 'fatal';
    const SGN_ADDITIONAL = 'response';

    // messaggi di errore
    const FATAL_MSG = 'server-not-capable';
    const UNAUTH_MSG = 'action-forbidden-for-user';
    const EMPRYRESP_MSG = 'empty-response';
    const SELFFOLLOW_MSG = 'no-self-follow';
    const DBNR_MSG = 'db-not-recheable';
    const FAILQUERY_MSG = 'failed-query';
    const NINITIALIZED_MSG = 'class-not-initialized';
    const NOSENSEQUERY_MSG = 'no-sense-query';
    const IMGTOOBIG_MSG = 'img-too-big';
    const ERRORDOCTYPE_MSG = 'not-valid-format';
    const WREPASS_MSG = 'wrong-password';
    const INTERROR_MSG = 'internal-error';

    //messaggi signaling
    const NOMORE_MSG = 'no-more';
    const SUCCESS_MSG = 'success';

    // ========================= COSTANTI =========================

    // ========================= METODI PUBBLICI =========================
    public function manageGeneric(Exception $e) {

        $msg = $e->getMessage();

        return [self::SGN_ERR => $msg];


    }
    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================

    // ========================= METODI PRIVATI =========================

}