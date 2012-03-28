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
    
  /**
   *
   * @return array
   */
  public function getPossibleMoves()
  {
      $x = $this->getField()->getPosX();
      $y = $this->getField()->getPosY();
      
      $maxX = $this->getBoard()->getMaxDimension(0);
      $maxY = $this->getBoard()->getMaxDimension(1);
      
      $moves = array();
      
      for($i = 1; $i <= $maxX; $i++) {
        for($j = 1; $j <= $maxY; $j++) {
          // only those in the same row or column
          if(($i == $x || $j == $y) && $this->getBoard()->getField($i, $j)->hasPieceFromPlayer($this->getPlayer()) == false) {
            $moves[] = array($i, $j);
          }
        }
      }
      
      return $moves;
  }
  
}
