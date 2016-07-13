<?php

/**
 * Created by PhpStorm.
 * User: gioacchinocastorio
 * Date: 24/06/16
 * Time: 15:40
 */
class CImage extends USingleton {

    protected static $instance = null;
    protected static $class = __CLASS__; // nome della classe


    // ========================= METODI PUBBLICI =========================
    /**
     * Instrada l'evento verso l'operazione corretta
     * @param UEvent $event Evento da instradare
     * @throws Exception
     */
    public function rail(UEvent $event) {


        switch ($event->getOperation()) {

            case 'user_pic':
                $this->getUserPic($event);
                break;

            case 'post_pic':
                $this->getPostPic($event);
                break;

            case 'aux_pic':
                $this->getAux($event);
                break;

            default:
                throw new Exception('operation-not-allowed');
                break;

        }

    }
    // ========================= METODI PUBBLICI =========================

    // ========================= METODI PRIVATI =========================

    /**
     * Richiedi alle fondazioni l'immagine dell'utente
     * @param UEvent $ev Evento di richiesta --> user_id dell'utente
     * @throws Exception
     */
    private function getUserPic(UEvent $ev) {

        $fimage = FImage::getInstance();

        $id_user = $ev->getPayload('user_id');

        $image = $fimage->fetch($id_user);


        $vimage = VImage::getInstance();

        $vimage->setImage($image);

        $vimage->render();


    }

    /** Richiedi alle fondazioni l'immagine di un post
     * @param UEvent $ev Evento di richiesta --> post_id del post
     * @throws Exception
     */
    private function getPostPic(UEvent $ev) {

        $fimage = FImage::getInstance();

        $id_img = $ev->getPayload('post_id');
        $image = $fimage->fetch($id_img, FImage::POST);

        $vimage = VImage::getInstance();

        $vimage->setImage($image);

        $vimage->render();

    }

    /**
     * Richiedi alle fondazioni l'immagine ausiliaria al funzionamento dell'applicazione
     * @param UEvent $ev Evento di richiesta --> id dell'immagine
     * @throws Exception
     */
    public function getAux(UEvent $ev) {

        $fimage = FImage::getInstance();
        $vimage = VImage::getInstance();

        $id = $ev->getPayload('id');

        $img = $fimage->fetchAux($id);


        $vimage->setImage($img);

        $vimage->render();

    }

    // ========================= METODI PRIVATI =========================

}