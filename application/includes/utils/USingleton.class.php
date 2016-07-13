<?php

 abstract class USingleton {

     protected static $is_initialized = TRUE; // indica se si può instanziare (singleton); di dafault instanziabile

    public static function getInstance() {

        if (static::$is_initialized === FALSE) {
            throw new Exception(UErrorHandler::NINITIALIZED_MSG);
        }

        if (static::$instance === null) {
            $instance_class = static::$class; // riferimento al costruttuore della classe chiamante
            static::$instance = new $instance_class; // instanzia per la prima volta
        }

        return static::$instance;
    }

    protected function __construct() {
      // imponi costruttore non visibile all'esterno
    }
  }
