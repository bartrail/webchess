<?php

namespace WebChess\Model\Piece;

use WebChess\Model\Piece;
use WebChess\Model\Player;
use WebChess\Model\Field;
use WebChess\Model\ChessGame;

/**
 * Bishop Piece Class
 *
 * @author con
 * @copyright 23.03.2012 
 */
class Bishop extends Piece {

  public function __construct(Player $player, Field $field)
  {
      parent::__construct($player, $field);
      if($player->getColor() == ChessGame::COLOR_WHITE) {
          $this->setImage('&#9815;');
      }else{
          $this->setImage('&#9821;');
      }
  }
    
  public function verifyMove(Field $field)
  {
    throw new \Exception('todo');
  }
  
}
