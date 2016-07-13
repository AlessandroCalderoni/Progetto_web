<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 22/06/16
 * Time: 10:54
 */
class UImage
{

    const MAXSIZE = 1000000; // massima dimensione di un'immagine 

    private $id = -1;
    private $doctype = 'unknown';
    private $img = 'unknown'; // per SQL l'immagine è una stringa
    private $owner = null;
    private $id_post = null;

    // ========================= METODI PUBBLICI =========================
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $doctype
     */
    public function setDoctype($doctype)
    {
        if ($doctype !== 'image/jpeg' && $doctype !== 'image/png')
            throw new Exception(UErrorHandler::ERRORDOCTYPE_MSG);

        $this->doctype = $doctype;
    }

    /**
     * @param null $id_post
     */
    public function setIdPost($id_post)
    {
        $this->id_post = $id_post;
    }

    /**
     * @param string $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * Traduce il file indicato mediante path in una raw byte sequence
     *
     * @param string $tmp_path Path temporaneo del file
     */
    public function encapsuleImage($tmp_path, $size) {

        if ($size >= self::MAXSIZE) {
            throw new Exception(UErrorHandler::IMGTOOBIG_MSG);
        }
        $file_content = file_get_contents($tmp_path);

        $this->setImg($file_content);

    }

    /**
     * @param null $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getDoctype()
    {

        return $this->doctype;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getIdPost()
    {
        return $this->id_post;
    }

    /**
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @return null
     */
    public function getOwner()
    {
        return $this->owner;
    }
    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================
    // ========================= METODI PRIVATI =========================

}