<?php

namespace WebChess\Model\Piece;

use WebChess\Model\Piece;
use WebChess\Model\Player;
use WebChess\Model\Field;
use WebChess\Model\ChessGame;

use WebChess\Exception\ChessException\InvalidMoveException;
use WebChess\Exception\ChessException\InvalidPositionException;

/**
 * King Piece Class
 *
 * @author con
 * @copyright 23.03.2012 
 */
class King extends Piece {

  public function __construct(Player $player, Field $field)
  {
      parent::__construct($player, $field);
      if($player->getColor() == ChessGame::COLOR_WHITE) {
          $this->setImage('&#9812;');
      }else{
          $this->setImage('&#9818;');
      }
  }    
    
  protected function getPossibleMoves(Field $field)
  {
      $x = $field->getPosX();
      $y = $field->getPosY();
      
      $moves = array(
        array($x-1, $y-1),  // bottom left
        array($x  , $y-1),  // bottom center
        array($x+1, $y-1),  // bottom right
        array($x-1, $y+1),  // top left
        array($x  , $y+1),  // top center
        array($x+1, $y+1),  // top right
        array($x-1, $y  ),  // center left
        array($x+1, $y  )   // center right
      );
      
      return $moves;
  }
  
}
