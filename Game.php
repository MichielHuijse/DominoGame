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
          $this->turn($player, $stock, $printer);
          $this->checkGameStatus($players);
          $stock->setTwoEnds();
        }
        else {
          $waitingPlayer = $player;
        }
      }

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
    if ($players[0]->getPlayerCantPlay() === true && $players[1]->getPlayerCantPlay() === true) {
      echo "<p>Both players can\'t play.</p>";
      $this->setEndGame(True);
      return;
    }

    foreach ($players as $player) {
      // Check if there is a winner.
      if (empty($player->getHand())) {
        $name = $player->getName();
        //      $styledName = $this->styledName($name, 1);
        echo "<p>{$name} has won.</p>";
        $this->setEndGame(True);
        return;
      }
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
    $match = null;

    $hand = $player->getHand();
//    $styledName = $printer->styledName($name); @todo

        foreach ($hand as $key => $value) {
          if ($hand[$key][0] === $twoEnds[0]) {
            array_unshift($line, array_reverse($hand[$key], false));
            $match = true;
            break;

          }

      // Gives index of match tile on first end.
          if ($hand[$key][1] === $twoEnds[0]) {
            array_unshift($line, $hand[$key]);
            $match = true;
            break;

          }

      // Gives index of match tile on last end.
          if ($hand[$key][0] === $twoEnds[1]) {
            array_push($line, $hand[$key]);
            $match = true;
            break;

      }

      // Gives index of reverse match tile on last end, tile should be reversed.
          if ($hand[$key][1] === $twoEnds[1]) {
            array_push($line, array_reverse($hand[$key], false));
            $match = true;
            break;
      }
    }

    if ($match === true) {

      // Updates the game when played a domino.
      $stock->setLine($line);
      $printer->printMove($name, $hand[$key], $stock->getLine());

      unset($hand[$key]);

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
