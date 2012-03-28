<?php
session_start();

use WebChess\Model\ChessGame;
use WebChess\Model\ChessGameHistory;
use WebChess\Model\Player\Human;

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();

$p1   = new Human('Sebastian', ChessGame::COLOR_WHITE);
$p2   = new Human('Conrad', ChessGame::COLOR_BLACK);

$game = new ChessGame('spiel1', array($p1, $p2));

//$game->initNewGame();

$history = new ChessGameHistory();
//$history->deleteGame($game->getId());
$history->save($game);

//$gameFromSession = $history->getGame($game->getId());
//print_r($game->getBoard()->debugPieces());

?>
<!DOCTYPE html>
<html>
<head>
    <title>WebChess</title>
    <link rel="stylesheet" href="styles/boardStyles.css" type="text/css">
    
</head>
<body>
    
    <div id="globalWrapper">
        
        <div id="header">
            <h1>WebChess</h1>
        </div>
        
        <div id="gameWrapper">
            <div id="gameBorder">
                <div id="board">
                    <?php
                    $game->getBoard()->render();
                    ?>
                </div>
                <?php echo $game->getBoard()->renderBorderX('bottom') ?>
                <?php echo $game->getBoard()->renderBorderX('top') ?>
                <?php echo $game->getBoard()->renderBorderY('left') ?>
                <?php echo $game->getBoard()->renderBorderY('right') ?>
            </div>            
        </div>
            
            
        
    </div>
    
</body>
</html>
