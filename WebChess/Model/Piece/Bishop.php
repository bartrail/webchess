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

  public $type = 'Bishop';  
    
  public function __construct(Player $player, Field $field)
  {
      parent::__construct($player, $field);
      if($player->getColor() == ChessGame::COLOR_WHITE) {
          $this->setImage('&#9815;');
      }else{
          $this->setImage('&#9821;');
      }
  }
  
  public function getPossibleMoves_()
  {
      $x = $this->getField()->getPosX();
      $y = $this->getField()->getPosY();
      
      $maxX = $this->getBoard()->getMaxDimension(0);
      $maxY = $this->getBoard()->getMaxDimension(1);
      
      $moves = array();
      
      // add all to upper right
      for($i = $x; $i <= $maxX; $i++) {
          for($j = $y; $y <= $maxY; $j++) {
              
          }
      }
      
      return $moves;
  }
    
}
