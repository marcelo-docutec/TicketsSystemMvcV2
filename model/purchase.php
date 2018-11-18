<?php
namespace model;

use model\User;
use helpers\Collection;
use mode\LinePurchase;

class Purchase
{
  private $id_purchases;
  private $linesPurchases;
  private $user;
  private $datePurchase;

  public function __construct () {
    $this->linesPurchases = new Collection();
  }

  //GETTERS

  public function getId() {
    return $this->id_purchase;
  }

  public function getUser()
  {
    return $this->user;
  }

  public function getDatePurchase() {
    return $this->datePurchase;
  }

  public function getLinesPurchases () {
    return $this->linesPurchases;
  }

  //SETTERS

  public function setUser(User $user)
  {
    $this->user = $user;
    return $this;
  }

  public function setDatePurchase($value)
  {
    $this->datePurchase = $value;
    return $this;
  }

  //Collection
  public function addLinePurchase (LinesPurchases $value) {
    $this->linesPurchases->add($value);
    return $this->linesPurchases;
  }

}
