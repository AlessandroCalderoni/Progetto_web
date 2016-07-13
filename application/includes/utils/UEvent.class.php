<?php

/**
 * Author: Alessandro Calderoni, Antonio Tuzi
 * Date:2016-06-17
 * License: GNUgpl3
 * email: a.calderoni@hotmail.it, antoniotuzi@alice.it
 */

class UEvent {

    private $environment; // per identificare il controller
    private $operation; // per identificare la function all'interno dello specifico controller
    private $payload = array(); // ulteriori informazioni

    // ========================= METODI PUBBLICI =========================

    /**
     * @param string $environment
     */
    public function setEnvironment($environment){
        $this->environment = $environment;
    }

    /**
     * @param string $operation
     */
    public function setOperation($operation) {
        $this->operation = $operation;
    }

    /**
     * @param string $payload
     * @param mixed $value
     */
    public function addPayload($key, $value) {
        $this->payload[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @return mixed
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return array
     */
    public function getPayload($key)
    {
        $result = null;
        if (isset($this->payload[$key]))
            $result = $this->payload[$key];
        
        return $result;
    }
    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================
    // ========================= METODI PRIVATI =========================
}
