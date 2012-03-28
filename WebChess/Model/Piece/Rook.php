<?php

namespace WebChess\Model\Piece;

use WebChess\Model\Piece;
use WebChess\Model\Player;
use WebChess\Model\Field;
use WebChess\Model\ChessGame;

/**
 * Rook Piece Class
 *
 * @author con
 * @copyright 23.03.2012 
 */
class Rook extends Piece {

  public $type = 'Rook';
    
  public function __construct(Player $player, Field $field)
  {
      parent::__construct($player, $field);
      if($player->getColor() == ChessGame::COLOR_WHITE) {
          $this->setImage('&#9814;');
      }else{
          $this->setImage('&#9820;');
      }
  }       
    
  protected function getPossibleMoves()
  {
      return array();
  }
  
}
