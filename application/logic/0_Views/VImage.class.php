<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 24/06/16
 * Time: 10:41
 */
class VImage extends USingleton
{

    // ========================= STATIC =========================
    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe
    // ========================= STATIC =========================


    private $image = null;

    // ========================= METODI PUBBLICI =========================

    /**
     * Set dell'immagine da visualizzare
     *
     * @param UImage $im Immagine da visualizzare
     */
    public function setImage (UImage $im) {

        $this->image = $im;

    }

    /**
     * Visualizza l'immagine settata
     */
    public function render() {

        $mime_type = $this->image->getDoctype();
        $img = $this->image->getImg();

        header("Content-type: $mime_type");

        echo $img; // invia dati binari

    }
    // ========================= METODI PUBBLICI =========================


    // ========================= METODI PRIVATI =========================
    // ========================= METODI PRIVATI =========================
}