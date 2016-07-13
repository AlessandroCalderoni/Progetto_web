<?php

class MComment Extends MPost {

  private $id_parent_of_comment = 0;

  // ========================= METODI PUBBLICI =========================
  /**
   * Set del valore dell'ID del post cui si riferisce
   *
   * @param integer $id_parent ID del post padre
   */
  public function setIdParent($id_parent) {
    $this->id_parent_of_comment = $id_parent;
  }

  /**
   * Get del valore dell'ID del post cui si riferisce
   *
   * @return integer ID del post padre
   */
  public function getIdParent() {
    return $this->id_parent_of_comment;
  }

  /** Get intero stato del commento
   * @return array Stato
   */
  public function getState()
  {
    $res = parent::getState();
    $res['parent'] = $this->getIdParent();
    return $res;
  }
  // ========================= METODI PUBBLICI =========================


}
