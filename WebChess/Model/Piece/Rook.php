<?php

namespace WebChess\Model\Piece;

use WebChess\Model\Piece;

/**
 * Rook Piece Class
 *
 * @author con
 * @copyright 23.03.2012 
 */
class Rook extends Piece {

  public function __construct(Player $player, Field $field)
  {
      parent::__construct($player, $field);
      if($player->getColor() == ChessGame::COLOR_WHITE) {
          $this->setImage('&#9814;');
      }else{
          $this->setImage('&#9820;');
      }
  }       
    
  public function getPossibleMoves(Field $field)
  {
      return array();
  }
  
  public function verifyMove(Field $field)
  {
//    throw new \Exception('todo');
      return array();
  }
  
}
