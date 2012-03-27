<?php

use WebChess\Model\ChessGame;

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();



//$game = new ChessGame();

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
            <div class="field white"></div>
            <div class="field black"></div>
            <div class="field white"></div>
            <div class="field black"></div>
            <div class="field white"></div>
            <div class="field black"></div>
            <div class="field white"></div>
            <div class="field black"></div>
        </div>
        
    </div>
    
</body>
</html>
