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
  public function __construct(ChessGame $game, ChessBoard $board = null)
  {
    $this->setGame($game);
    
    // if no board is given, suppose a clean field
    if($board == null) {
      $this->initFields();
    }else{
      $this->buildFieldsFromSnapshot($board);
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
      
    for($x = $this->dimensions[0]; $x >= 1 ; $x--)
    { 
        foreach($this->fields[$x] as $y => $field) 
        {
            /* @var $field Field */
            echo $field->render();
        }
    }
  }
  
  /**
   * builds the field from the history snapshot coming from the database
   * 
   * @param ChessBoard $board
   */
  public function buildFieldsFromSnapshot(ChessBoard $board)
  {
//    throw new \Exception("todo");
  }
  
}
