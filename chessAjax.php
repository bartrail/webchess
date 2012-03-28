<?php
require_once('header.php');

use WebChess\Model\ChessGame;
use WebChess\Model\ChessGameHistory;
use WebChess\Exception\ChessException;

//print_r($_POST);
/*
Array
(
    [gameid] => spiel1
    [piece] => Array
        (
            [x] => 1
            [y] => 8
            [type] => Rook
            [player] => Conrad
        )

    [targetField] => Array
        (
            [x] => 1
            [y] => 6
        )

)
*/

$post = $_POST;

$game = new ChessGame($post['gameId']);

$startField = $game->getBoard()->getField($post['piece']['x'], $post['piece']['y']);
/* @var $startField WebChess\Model\Field */

$targetField = $game->getBoard()->getField($post['targetField']['x'], $post['targetField']['y']);

$piece = $startField->getPiece();

try {
    
    $piece->moveToField($targetField);
    ChessGameHistory::save($game);
    
}catch(ChessException $e) {
    
}

echo $game->getBoard()->render();


