<?php


public function turnPlayer($turn) {

  $line = $this->getLine();
  $twoEnds = $this->getTwoEnds();
  $player = $this->getplayer($turn);


  $match = NULL;
  $reverse = NULL;
  $begin = NULL;

  // Gives index of match tile on first end, tile should be reversed.

  if ($match === NULL) {
    foreach ($player as $key => $value) {
      if ($player[$key][0] === $twoEnds[0]) {
        $match = $key;
        $reverse = TRUE;
        $begin = TRUE;
      }
    }
  }

  if ($match === NULL) {

    // Gives index of match tile on first end.
    foreach ($player as $key => $value) {
      if ($player[$key][1] === $twoEnds[0]) {
        $match = $key;
        $reverse = FALSE;
        $begin = TRUE;
      }
    }

  }

  if ($match === NULL) {

    // Gives index of match tile on last end.
    foreach ($player as $key => $value) {
      if ($player[$key][0] === $twoEnds[1]) {
        $match = $key;
        $reverse = FALSE;
        $begin = FALSE;
      }
    }

  }

  if ($match === NULL) {

    // Gives index of reverse match tile on last end, tile should be reversed.
    foreach ($player as $key => $value) {
      if ($player[$key][1] === $twoEnds[1]) {
        $match = $key;
        $reverse = TRUE;
        $begin = FALSE;
      }
    }

  }

  // Player plays a domino.
  if ($match !== NULL) {

    if ($begin === TRUE && $reverse === FALSE) {
      array_unshift($line, $player[$match]);
    }

    if ($begin === TRUE && $reverse === TRUE) {
      array_unshift($line, array_reverse($player[$match], FALSE));
    }

    if ($begin === FALSE && $reverse === FALSE) {
      array_push($line, $player[$match]);
    }

    if ($begin === FALSE && $reverse === TRUE) {
      array_push($line, array_reverse($player[$match], FALSE));
    }

    $this->setLine($line);

    $this->printMove("<em style=\"color:green\">Player {$turn}</em>", $player[$match], $this->line);

    unset($player[$match]);
    $this->setPlayer($player, $turn);
    $this->setPlayerPlays($player, $turn);

    $this->setTurn(1);
    $this->playTurn();
  }

  // Player draws a domino

  if ($match === NULL) {

    $player = $this->getPlayer($turn);

    $drawnDomino = $this->getOneOfStock();

    // If the stock is empty, the other player should play.
    if ($drawnDomino === NULL) {

      echo '<p> There are no tiles left to draw </p>';
      $this->setTurn(1);
      $this->setPlayerCantPlay();
      $this->playTurn();

    }

    else {

      echo "<p> Player {$turn} can\'t play and draws a tile. </p>";
      array_push($player, $drawnDomino);
      $this->setPlayer($player, $turn);
      $this->playTurn();
    }
  }

  return;

}