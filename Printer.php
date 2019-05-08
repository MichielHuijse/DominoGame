<?php

namespace DominoGame;


class Printer {


  public function printFirstTile()
  {

    $firstTile = $this->getLine();
    $dominoString = $this->printDomino($firstTile);

    echo "<em>The game starts with first tile: {$dominoString}</em>";
  }

  public function printMove($styledName, $hand, $line)
  {

    $handString = $this->printHand($hand);
    $lineString = $this->printDomino($line);

    echo "<p>{$styledName} plays: {$handString} the board is now: {$lineString} </p>";
  }



  public function printDomino(array $domino)
  {

    $dominoString = '';

    for ($i = 0; $i < count($domino); $i++) {
      $dominoString = $dominoString . '<' . $domino[$i][0] . ':' . $domino[$i][1] . '> ';
    }

    return $dominoString;
  }

  public function printHand(array $hand)
  {
    return $dominoString ='<' . $hand[0] . ':' . $hand[1] . '> ';
  }


}