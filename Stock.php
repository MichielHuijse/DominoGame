<?php

namespace DominoGame;


class Stock {

  private $stock;
  private $line;
  private $twoEnds;

  public function __construct() {
    $this->newstock();
    $this->shuffleStock();
    $this->newLine();
    $this->setTwoEnds();
  }

  /**
   * Makes new domino pieces.
   * @param mixed $stock
   */
  public function newstock()
  {
    for ($i=0; $i<=6; $i++) {
      for ($j=0; $j<=$i; $j++) {
        $stock[] = [$i,$j];
      }
    }
    $this->stock = $stock;
  }

  /**
   * Shuffles the Stock;
   */
  public function shuffleStock()
  {
    shuffle($this->stock);
  }


  /**
   * Creates first line on the table / Puts first random domino on the table.
   */
  public function newLine()
  {

    $stock = $this->getStock();
    $randomIndexStock = mt_rand(0, (count($stock)-1));
    $this->line = array_values(array_slice($stock, $randomIndexStock, 1, true));
    unset($stock[$randomIndexStock]);
    $this->stock = array_values($stock);
  }

  /**
   * @return mixed
   */
  public function getStock()
  {
    return $this->stock;
  }

  public function setStock($stock) {

    $this->stock = $stock;
  }


  /**
   * Player draws a Domino from the stock.
   *
   * @return null
   */
  public function getOneOfStock()
  {
    if ($this->stock[0]) {
      $dominoTile = $this->stock[0];
      unset($this->stock[0]);
      $newStock = array_values($this->stock);
      $this->stock = $newStock;

      return $dominoTile;
    } else {
      return null;
    }
  }

  /**
   * @return mixed
   */
  public function getLine()
  {
    return $this->line;
  }

  /**
   * @param mixed $line
   */
  public function setLine($line)
  {
    $this->line = $line;
  }

  /**
   * Sets the two ends of the line.
   */
  public function setTwoEnds()
  {
    $line = $this->getLine();
    $twoEnds[0] = $line[0][0];
    $twoEnds[1] = $line[count($line)-1][1];
    $this->twoEnds = $twoEnds;
  }

  /**
   * Gets the two ends of the line on the table.
   * @return mixed
   */
  public function getTwoEnds()
  {
    return $this->twoEnds;
  }


}