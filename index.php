<?php

use WebChess\Model\ChessGame;
use WebChess\Model\Field;
use WebChess\Model\Player\Human;

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();

$p1   = new Human('Sebastian', ChessGame::COLOR_WHITE);
$p2   = new Human('Conrad', ChessGame::COLOR_BLACK);

$game = new ChessGame(array($p1, $p2));

$game->initNewGame();

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
            <?php
           $game->getBoard()->render();
            ?>
        </div>
        
    </div>
    
</body>
</html>
