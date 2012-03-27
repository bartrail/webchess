<?php

namespace WebChess\Model\Piece;

use WebChess\Model\Piece;
use WebChess\Model\Player;
use WebChess\Model\Field;
use WebChess\Model\ChessGame;
/**
 * Pawn Piece Class
 *
 * @author con
 * @copyright 23.03.2012 
 */
class Pawn extends Piece {
    
  public function __construct(Player $player, Field $field)
  {
      parent::__construct($player, $field);
      if($player->getColor() == ChessGame::COLOR_WHITE) {
          $this->setImage('&#9817;');
      }else{
          $this->setImage('&#9823;');
      }
  }   
  
  public function getPossibleMoves(Field $field)
  {
      return array();
  }
  
  public function verifyMove(Field $field)
  {
    throw new \Exception('todo');
  }
  
}
