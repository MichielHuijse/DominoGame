<?php

public function turnPlayer2() {

  $line = $this->getLine();
  $twoEnds = $this->getTwoEnds();
  $player2 = $this->getplayer2();


  $match = NULL;
  $reverse = NULL;
  $begin = NULL;

  // Gives index of match tile on first end.

  if ($match === NULL) {
    foreach ($player2 as $key => $value) {
      if ($player2[$key][0] === $twoEnds[0]) {
        $match = $key;
        $reverse = TRUE;
        $begin = TRUE;
      }
    }
  }

  if ($match === NULL) {

    // Gives index of reverse match tile on first end.
    foreach ($player2 as $key => $value) {
      if ($player2[$key][1] === $twoEnds[0]) {
        $match = $key;
        $reverse = FALSE;
        $begin = TRUE;
      }
    }

  }

  if ($match === NULL) {

    // Gives index of match tile on last end.
    foreach ($player2 as $key => $value) {
      if ($player2[$key][0] === $twoEnds[1]) {
        $match = $key;
        $reverse = TRUE;
        $begin = FALSE;
      }
    }

  }

  if ($match === NULL) {

    // Gives index of reverse match tile on last end.
    foreach ($player2 as $key => $value) {
      if ($player2[$key][1] === $twoEnds[1]) {
        $match = $key;
        $reverse = FALSE;
        $begin = TRUE;
      }
    }

  }

  // Player plays a domino.
  if ($match !== NULL) {

    if ($begin === TRUE && $reverse === FALSE) {
      array_unshift($line, $player2[$match]);
    }

    if ($begin === TRUE && $reverse === TRUE) {
      array_unshift($line, array_reverse($player2[$match], FALSE));
    }

    if ($begin === FALSE && $reverse === FALSE) {
      array_push($line, $player2[$match]);
    }

    if ($begin === FALSE && $reverse === TRUE) {
      array_push($line, array_reverse($player2[$match], FALSE));
    }

    $this->setLine($line);

    $this->printMove('Player2', $player2[$match], $this->line);

    unset($player2[$match]);
    $this->setPlayer2($player2);
    $this->setPlayer2Plays();

    $this->setTurn(2);
    $this->playTurn();
  }

  // Player draws a domino

  if ($match === NULL) {

    $player2 = $this->getPlayer2();

    $drawnDomino = $this->getOneOfStock();

    // If the stock is empty, the other player should play.
    if ($drawnDomino === NULL) {

      echo '<p> There are no tiles left to draw </p>';
      $this->setTurn(1);
      $this->playTurn();
      $this->setPlayer2CantPlay();
    }

    else {
      array_push($player2, $drawnDomino);
      $this->setPlayer2($player2);
      $this->playTurn();
    }
  }

  echo '<p> Should not come here 203 </p>';
  die();
}


