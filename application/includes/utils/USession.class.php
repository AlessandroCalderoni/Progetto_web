<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 20/06/16
 * Time: 09:50
 */
class USession Extends USingleton {

    // per essere singleton
    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe

    // ========================= METODI PUBBLICI =========================
    /**
     * Dai inizio alla sessione
     */
    public function start() {
        session_start(); // fai partire la sessione
    }

    /**
     * Dai fine alla sessione
     */
    public function stop() {

        session_unset();
        session_destroy();

    }

    /**
     * Get dello stato della sessione
     *
     * @return array Una copia dello stato
     */
    public function getSessionState() {
        return (new ArrayIterator($_SESSION))->getArrayCopy(); // deep clone dell'array
    }

    /**
     * Get di una componente dello stato
     *
     * @param string $key Nome della componente
     * @return string Componente richiesta
     */
    public function getValue($key) {

        $val = null;

        if (isset($_SESSION[$key])) {
            $val = $_SESSION[$key];
        }

        return $val;
    }

    /**
     * Set di una componente dello stato
     *
     * @param string $key Nome della componente
     * @param mixed $value Nuovo valore
     */
    public function setValue($key, $value) {

        $_SESSION[$key] = $value;

    }

    public function getUserStatus() {

        $ret = null;
        $usr = $this->getValue('user_state');
        if (isset($usr)) {
            $ret = unserialize($usr);
        }
        return $ret;
    }

    public function setUserStatus(MUser $user) {
        $ser = serialize($user);
        $this->setValue('user_state',$ser );
    }
    // ========================= METODI PUBBLICI =========================


    // ========================= METODI PRIVATI =========================
    // ========================= METODI PRIVATI =========================

}