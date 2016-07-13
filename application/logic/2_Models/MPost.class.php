<?php

/**
 * Class MPost
 */
class MPost {

    private $post_id = -1; // sarà modificato solo quando reso noto dal database

    private $user_id = -1;

    // questa info non verrà memorizzata nel database (dato che è ricavabile con un join)
    private $user_name = 'unknown';

    private $date_last_change = 0;

    private $text_content = 'no-content'; // contenuto di default

    private $hasimage = FALSE; // se ha un'immagine

    /**
     * Cambia il contenuto testuale e aggiorna la data di modifica
     *
     * @param string $new_content Nuovo contenuto testuale
     */
    public function setTextContent($new_content) {
        $this->setContent($new_content);

        $this->setDateLastChange(time());
    }

    /**
     * Get dell'attributo Post Id
     *
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * Get dell'attributo User Id
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }


    /**
     * Get dell'attributo Date Last Change in formato ISO
     *
     * @return string Data formato ISO
     */
    public function getDateLastChangeHumanReadable()
    {
        $hour_advance_rome = 2;
        $sec_rome = 3600 * $hour_advance_rome;
        return gmdate("Y-m-d -- H:i:s", $this->date_last_change + $sec_rome);
    }

    /**
     * Get dell'attributo Date Last Change in Secondi
     *
     * @return string Data in secondi da UNIX epoch
     */
    public function getDateLastChangeSeconds()
    {
        return $this->date_last_change;
    }

    /**
     * Get dell'attributo Text Content
     *
     * @return mixed
     */
    public function getTextContent()
    {
        return $this->text_content;
    }


    /**
     * Set del valore di Post Id
     *
     * @param mixed post_id
     *
     * @return self
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;

        return $this;
    }

    /**
     * Set del valore di User Id
     *
     * @param mixed user_id
     *
     * @return self
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Set del valore di Date Last Change
     *
     * @param string $date_last_change Orario in formato ISO
     *
     */
    public function setDateLastChange($date_last_change)
    {
        $this->date_last_change = $date_last_change;
    }

    /**
     * Set del valore di Content
     * 
     * @param string $content Contenuto del post
     */
    public function setContent($content) {
        $this->text_content = $content;
    }

    /**
     * Set nome dell'autore
     *
     * @param string $fullname Nome completo dell'autore
     */
    public function setAuthorName($fullname) {
        $this->user_name = $fullname;
    }

    /**
     * Get nome dell'autore
     * @return string Nome completo
     */
    public function getAuthorName() {
        return $this->user_name;
    }

    public function getState() {

        $result = [];

        foreach ($this as $attribute => $value) {

            $result[$attribute] = $value;

        }

        $result['date_h_readable'] = $this->getDateLastChangeHumanReadable(); // aggiungi data come stringa leggibile

        return $result;

    }

    /**
     * Controlla se al post è associato un'immagine
     *
     * @return boolean
     */
    public function getHasimage()
    {
        return $this->hasimage;
    }

    /**
     * Set se al post è associato un'immagine
     *
     * @param boolean $hasimage
     */
    public function setHasimage($hasimage)
    {
        $this->hasimage = $hasimage;
    }

}
