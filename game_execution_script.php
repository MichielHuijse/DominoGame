<?php

use DominoGame\Player;
use DominoGame\Stock;
use DominoGame\Printer;
use DominoGame\Game;

require_once('Player.php');
require_once('Stock.php');
require_once('Game.php');
require_once('Printer.php');


$player1 = new Player('Alice');
$player2 = new Player('Bob');

$stock = new Stock();
$printer = new Printer();

$players = [$player1, $player2];

$domino = new Game();
$domino->prepareGame($players, $stock);
$domino->playGame($players, $stock, $printer);

echo '<p>This is the end of the game.</p>';

