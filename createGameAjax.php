<?php
require_once('header.php');

use WebChess\Model\ChessGame;
use WebChess\Model\ChessGameHistory;
use WebChess\Model\Player\Human;

/*
Array ( 
   [player1] => Test 
   [player2] => Spieler 
   [name] => 123 
)
 */

$post = $_POST;

if($post['action'] == 'create') {
    
    $p1   = new Human($post['player1'], ChessGame::COLOR_WHITE);
    $p2   = new Human($post['player2'], ChessGame::COLOR_BLACK);
    $game = new ChessGame($post['gameId'], array($p1, $p2));
    ChessGameHistory::deleteGame($game);
    ChessGameHistory::save($game);
    
}elseif($post['action'] == 'load') {
    
    $game = new ChessGame($post['gameId']);
    
}
?>
<div id="gameBorder">
    <div id="board">
        <?php echo $game->getBoard()->render(); ?>
    </div>
    <?php echo $game->getBoard()->renderAllBorders(); ?>
</div>
