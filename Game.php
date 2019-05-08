<?php

namespace DominoGame;

require_once('Player.php');

class Game
{
  private $turn;
  private $turnNumber;
  private $endGame;

  public function prepareGame(array $players, Stock $stock)
  {
    foreach ($players as $player) {
      $this->provideHand($player, $stock);
    }

    $this->setBeginningPlayer($players);
    $this->endGame = FALSE;
  }

  private function setBeginningPlayer($players){

    $randTurn = mt_rand(0, (count($players)-1));
    $this->setTurn($players[$randTurn]->getName());

  }

  public function playGame(array $players, Stock $stock, Printer $printer) {

    while ($this->endGame === False ) {

      $turn = $this->getTurn();

      foreach ($players as $player) {
        if ($player->getName() === $turn) {

          $currentPlayer = $player;

        }
        else {
          $waitingPlayer = $player;
        }
      }


      $this->turn($currentPlayer, $stock, $printer);
      $this->checkGameStatus($players);
      $stock->setTwoEnds();

      $this->setTurn($waitingPlayer->getName());
    }
  }


  private function provideHand(Player $player, Stock $stock) {

    $stockStack = $stock->getStock();

    $hand = array_slice($stockStack, 0, 7);

    for ($i = 0; $i<=6; $i++) {
      unset($stockStack[$i]);
    }
    $stockStack = array_values($stockStack);

    $stock->setStock($stockStack);
    $player->setHand($hand);
  }

  /**
   * Here starts the game. The players alternate trough this step till the game
   * has ended.
   */
  public function checkGameStatus($players)
  {
    // Stop the game, both players can't play.
    if ($players[0]->playercantPlay === true && $players[1]->playercantPlay === true) {
      echo "<p>Both players can\'t play.</p>";
      $this->setEndGame(True);
      return;
    }

    // Check if there is a winner.
    if (empty($players[0]->getHand())) {
      $name = $players[0]->getName();
//      $styledName = $this->styledName($name, 1);
      echo "<p>{$name} has won.</p>";
      $this->setEndGame(True);
      return;
    }

    // Check if there is a winner.
    if (empty($players[1]->getHand())) {
      $name = $players[1]->getName();
      //      $styledName = $this->styledName($name, 1);
      echo "<p>{$name} has won.</p>";
      $this->setEndGame(True);
      return;
    }

//    $this->turnNumber = ($this->turnNumber)+1; @todo

    return;
  }


  /**
   * In this method lives the logic behind a turn.
   * @param $turn
   */
  public function turn(Player $player, Stock $stock, Printer $printer)
  {

    $line = $stock->getLine();
    $twoEnds = $stock->getTwoEnds();
    $name = $player->getName();

    $hand = $player->getHand();
//    $styledName = $printer->styledName($name); @todo

    $match = null;
    $reverse = null;
    $begin = null;

    // Gives index of match tile on first end, tile should be reversed.
    if ($match === null) {
      foreach ($hand as $key => $value) {
        if ($hand[$key][0] === $twoEnds[0]) {
          $match = $key;
          $reverse = true;
          $begin = true;
        }
      }
    }

    // Gives index of match tile on first end.
    if ($match === null) {
      foreach ($hand as $key => $value) {
        if ($hand[$key][1] === $twoEnds[0]) {
          $match = $key;
          $reverse = false;
          $begin = true;
        }
      }
    }

    // Gives index of match tile on last end.
    if ($match === null) {
      foreach ($hand as $key => $value) {
        if ($hand[$key][0] === $twoEnds[1]) {
          $match = $key;
          $reverse = false;
          $begin = false;
        }
      }
    }

    // Gives index of reverse match tile on last end, tile should be reversed.
    if ($match === null) {
      foreach ($hand as $key => $value) {
        if ($hand[$key][1] === $twoEnds[1]) {
          $match = $key;
          $reverse = true;
          $begin = false;
        }
      }
    }

    // Player plays a domino.
    if ($match !== null) {
      if ($begin === true && $reverse === false) {
        array_unshift($line, $hand[$match]);
      }

      if ($begin === true && $reverse === true) {
        array_unshift($line, array_reverse($hand[$match], false));
      }

      if ($begin === false && $reverse === false) {
        array_push($line, $hand[$match]);
      }

      if ($begin === false && $reverse === true) {
        array_push($line, array_reverse($hand[$match], false));
      }

      // Updates the game when played a domino.
      $stock->setLine($line);
      $printer->printMove($name, $hand[$match], $stock->getLine());

      unset($hand[$match]);

      $player->setHand($hand);
      $player->setPlayerPlays();

      return;
    }

    // Player draws a domino
    if ($match === null) {

      $drawnDomino = $stock->getOneOfStock();

      // If the stock is empty, the other player should play.
      if ($drawnDomino === null) {
        echo '<p> There are no tiles left to draw </p>';
        $player->setPlayerCantPlay();
        return;

      } else {

        $hand = $player->gethand();
        echo "<p> {$name} can't play and draws a tile. </p>";
        array_push($hand, $drawnDomino);
        $player->setHand($hand);
        return;
      }
    }

    return;
  }

  /**
   * @return mixed
   */
  public function getTurn()
  {
    return $this->turn;
  }

  /**
   * @param mixed $turn
   */
  public function setTurn($turn)
  {
    $this->turn = $turn;
  }



  public function setEndGame(bool $endGame)
  {
    $this->endGame = True;
  }

}
