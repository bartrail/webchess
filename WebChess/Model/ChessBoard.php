<?php

namespace WebChess\Model;

use WebChess\Model\ChessGame;
use WebChess\Model\Field;

use WebChess\Exception\ChessException\InvalidPositionException;
use WebChess\Exception\ChessException\InvalidColorException;

/**
 * Represents a ChessBoard
 *
 * @author con
 * @copyright 23.03.2012 
 */
class ChessBoard {

  /**
   * 2-dimensional map of fields
   * 
   * @var array
   */
  protected $fields = array();
  
  /**
   * Dimensions of the Board (x,y)
   * 
   * @var array
   */
  protected $dimensions = array(8,8);
  
  /**
   *
   * @var ChessGame
   */
  protected $game;
  
  /**
   *
   * @var type 
   */
  protected $fieldBlack = 'black';
  protected $fieldWhite = 'white';
  
  /**
   * initializes a ChessBoard
   * 
   * @param ChessGame $game
   * @param ChessBoard $board = null 
   */
  public function __construct(ChessGame $game, array $fields = null)
  {
    $this->setGame($game);
    
    // if no board is given, suppose a clean field
    if($fields == null) {
      $this->initFields();
    }else{
      $this->buildFieldsFromSnapshot($fields);
    }
  }
  
  /**
   * set a ChessGame
   * 
   * @param ChessGame $game 
   */
  public function setGame(ChessGame $game)
  {
    $this->game = $game;
  }
  
  /**
   * get a ChessGame
   * 
   * @return ChessGame
   */
  public function getGame()
  {
    return $this->game;
  }
  
  /**
   * get Fields
   * 
   * @return array
   */
  public function getFields()
  {
    return $this->fields;
  }
  
  /**
   * get a specific field from its coordinates
   * 
   * @param int $posX
   * @param int $posY
   * @return Field
   * @throws InvalidPositionException 
   */
  public function getField($posX, $posY)
  {
    if($this->validPosition($posX, $posY)) {
      return $this->fields[$posX][$posY];
    }else{
      throw new InvalidPositionException(sprintf("Desired position %s/%s out of range: %s/%s", $posX, $posY, $this->dimensions[0], $this->dimensions[1]));
    }
  }

  /**
   * validates the input coordinates
   * 
   * @param int $posX
   * @param int $posY
   * @return boolean 
   */
  public function validPosition($posX, $posY)
  {
    return ($this->validPositionX($posX) && $this->validPositionY($posY));
  }
  
  /**
   * validates the x-position
   * 
   * @param int $posX
   * @return boolean
   */
  public function validPositionX($posX)
  {
    return ($posX >= 1 && $posX <= $this->getMaxDimension(0));
  }
  
  /**
   * validates the y-position
   * 
   * @param int $posY
   * @return boolean
   */
  public function validPositionY($posY)
  {
    return ($posY >= 1 && $posY <= $this->getMaxDimension(1));
  }
  
  /**
   * returns whether a piece from the given player is already placed
   * 
   * @param Field $field
   * @param Player $player
   * @return type 
   */
  public function hasPieceFromPlayer(Field $field, Player $player)
  {
      return $field->hasPieceFromPlayer($player);
  }
  
  /**
   * return field dimensions
   * 
   * @return array
   */
  public function getDimensions()
  {
    return $this->dimensions;
  }
  
  /**
   *
   * get the max dimension for a key (0,1,x,y)
   * 
   * @param mixed $key
   * @return int
   * @throws \LogicException 
   */
  public function getMaxDimension($key)
  {
    switch($key) {
      case 0:
      case 'x':
        return $this->dimensions[0];
      break;
      case 1:
      case 'y':
        return $this->dimensions[1];
      break;
      default:
        throw new \LogicException(sprintf("Unknown dimension key, must be '0','1', 'x' or 'y'"));
      break;
    }
  }
  
  /**
   * initializes Fields
   */
  protected function initFields()
  {
    for($x = 1; $x <= $this->dimensions[0]; $x++) {
      for($y = 1; $y <= $this->dimensions[1]; $y++) {
        
        $this->fields[$x][$y] = new Field($this, $x, $y);
        
      }
    }
  }
  
  public function render()
  {
//    for($x = 1; $x <= $this->dimensions[0] ; $x++)
//    { 
//        for($y = $this->dimensions[1]; $y >= 1; $y--) {
//            $field = $this->fields[$y][$x];
//            echo $field->render();
//        }
//    }
    for($y = $this->dimensions[1]; $y >= 1; $y--)
    { 
        for($x = 1; $x <= $this->dimensions[0] ; $x++) {
            $field = $this->fields[$x][$y];
            echo $field->render();
        }
    }
  }
  
  public function renderBorderX($position = 'bottom')
  {
      $border = '';
      for($x = 1; $x <= $this->dimensions[0]; $x++) {
          $border .= sprintf('<div class="%s border-x pos-%s" style="left: %spx; %s:0px;">%s</div>', 
                  $position,
                  $x, 
                  ($x-1)*100 + 30, 
                  $position,
                  $x
                  );
      }
      return $border;
  }
  
  public function renderBorderY($position = 'left')
  {
      $border = '';
      $row    = $this->dimensions[1];
      for($y = 1; $y <= $this->dimensions[1] ; $y++) {
          $border .= sprintf('<div class="%s border-y pos-%s" style="top: %spx; %s:0px;">%s</div>', 
                  $position,
                  $row, 
                  ($y-1)*100 + 30, 
                  $position,
                  $row
          );
          $row--;
      }
      return $border;
  }
  
  public function debugPieces()
  {
      $output = array();
      
      $player = $this->getGame()->getPlayer();
      foreach($player as $p) {
          $output['player'][] = array(
            'name' => $p->getName(),
            'color' => $p->getColor()
          );
      }
      
      foreach($this->getFields() as $col) {
          foreach($col as $row => $field) {
            /* @var $field Field */
            if($field->getPiece()) {
                $output['fields'][] = array(
                    'x' => $field->getPosX(),
                    'y' => $field->getPosY(),
                    'player' => $field->getPiece()->getPlayer()->__toString(),
                    'piece'  => $field->getPiece()->getType()
                );
            }else{
                $output['fields'][] = array(
                    'x' => $field->getPosX(),
                    'y' => $field->getPosY()
                );
            }
          }
      }
      return $output;
  }
  
  /**
   * builds the field from the history snapshot coming from the database
   * 
   * @param ChessBoard $board
   */
  public function buildFieldsFromSnapshot(array $fields)
  {
//      print_r($fields);
//    throw new \Exception("todo");
  }
  
}
