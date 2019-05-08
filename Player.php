<?php

namespace DominoGame;

class Player {

  private $playerCantPlay;
  private $name;
  private $hand;
  private $color;


  public function __construct(string $name) {

    $this->newPlayer($name);
  }

  /**
   * Creates new player.
   *
   * @param string $name
   */
  private function newPlayer(string $name)
  {
    $this->setName($name);
    $this->setColor();
    $this->playercantPlay = false;
  }

  private function setColor(){


    $rand = mt_rand(0, 5);
    $colors = ['green', 'red', 'orange', 'blue', 'yellow', 'purple' ];
    $this->color = $colors[$rand];
  }

  public function setHand($hand) {

    $this->hand = $hand;
  }

  public function getHand() {
    return $this->hand;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  /**
   * If two players can't play the game must be stopped.
   * @param $turn
   */
  public function setPlayerCantPlay()
  {
    $this->playerCantPlay = true;
  }

  /**
   * @param $turn
   */
  public function setPlayerPlays()
  {
    $this->playerCantPlay = false;
  }

  private function getColor(){
    return $this->color;
  }

  public function styledName()
  {
    $styledName = "<em \"style=\"color:{$this->getColor()}\" >{$this->getName()} </em>";
    return $styledName;
  }

}