<?php

/**
 * Class FMariaDBHandler
 */

class FMariaDBHandler Extends mysqli {

    // ========================= METODI PUBBLICI =========================
    /**
     * Restituisce un oggetto  con i dati richiesti al dbms
     *
     * @param string $table Nome della tabella a cui si fa la richiesta
     * @param string $attr_where Attributo su cui si fa il controllo
     * @param mixed $val_where Valore di controllo
     * @return array Table richiesta
     */
    public function shortcutFetch($table, $attr_where, $val_where) {

        $val_where = $this->tidyForInput($val_where);

        $query = "SELECT * FROM `$table` WHERE `$attr_where` = $val_where;";


        // var_dump($query);

        $res = $this->query($query);


        return $this->responseToArray($res);

    }


    /**
     * Salvataggio di una riga
     *
     * @param string $table Tabella in uso
     * @param $arr_new_values Valori da inserire nella riga
     * @return integer ID della nuova riga
     * @throws Exception
     */
    public function shortcutSave($table, $arr_new_values) {

        $str_new_values = '';
        foreach ($arr_new_values as $key => $value) {

            $str_new_values .= $this->tidyForInput($value);

            if ($key !== (sizeof($arr_new_values) - 1)) // se non è l'ultimo elemento aggiungi virgola e spazio
                $str_new_values .=', ';
        }

        $query = "INSERT INTO `$table` VALUE ($str_new_values);";

       // var_dump($query);

        $this->query($query);

        return $this->insert_id;

    }

    /** Cancella una riga da una tabellla
     * @param string $table Tabella
     * @param string $attr_where Attributo di selezione
     * @param string $val_where Valore dell'attributo
     */
    public function shortcutDelete($table, $attr_where, $val_where) {

        $val_where = $this->tidyForInput($val_where);
        $query = "DELETE FROM `$table` WHERE `$attr_where` = $val_where;";

        $this->query($query);

    }

    /**
     * Effettua una query controllata al dbms
     *
     * @param string $querystr Stringa con il valore della query
     * @return bool|mysqli_result Risultato della query
     * @throws Exception
     */
    public function query($querystr) {

        $this->isStillReachable();
        
        $last_error = $this->error;

        // var_dump($querystr);

        $result = parent::query($querystr); // effettua la query

        if ($this->error !== $last_error) { // c'è stato un errore
            throw new Exception(UErrorHandler::FAILQUERY_MSG, $this->errno); // segnala l'errore con il relativo codice
        }

        return $result;


    }

    /**
     * Controlla se il DB è ancora raggiungibile
     *
     * @throws Exception
     */
    public function isStillReachable() {
        if (!$this->ping()) {
            throw new Exception(UErrorHandler::DBNR_MSG);
        }
    }

    /**
     * Formatta correttamente il valore per mariaDB
     *
     * @param mixed $item Valore da formattare
     * @return string Valore nel formato corretto per mariaDB
     */
    public function tidyForInput($item) {

        $result = '';

        if (is_string($item)) {
            $result .= "'" . $this->escape_string($item). "'";
        }
        elseif ($item === null) {
            $result .= 'NULL';
        }
        else {
            $result .= $item;
        }

        return $result;

    }


    /**
     * Inserisci le righe di una risposta mysqli in un array (multidimensionale)
     *
     * @param $result Risposta mysqli
     * @return array Array di righe della risposta
     * @throws Exception
     */
    public function responseToArray($result) {

        if ($result->num_rows !== 0) { // se la risposta non è vuota

            $arr_res = [];

            while ($arr_values = $result->fetch_assoc()) {

                $arr_res[] = $arr_values;
            }

            return $arr_res;

        }
        else
            throw new Exception(UErrorHandler::EMPRYRESP_MSG);



    }


    /**
     * FMariaDBhendeler destructor.
     */
    public function __destruct() {
        $this->close(); // chiudi la connessione
    }

    // ========================= METODI PUBBLICI =========================



    // ========================= METODI PRIVATI =========================
    // ========================= METODI PRIVATI =========================

}
