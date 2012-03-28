<?php
require_once('header.php');

use WebChess\Model\ChessGame;
use WebChess\Model\ChessGameHistory;

/*
print_r($_POST);
Array
(
    [piece] => Array
        (
            [x] => 4
            [y] => 7
            [type] => Pawn
            [player] => Conrad
        )

    [targetField] => Array
        (
            [x] => 4
            [y] => 6
        )
)
*/

$post = $_POST;


