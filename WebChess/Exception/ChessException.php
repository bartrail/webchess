<?php

namespace WebChess\Exception;

use \LogicException;

/**
 * Description of InvalidColorException
 *
 * @author con
 * @copyright 23.03.2012 
 */
class ChessException extends LogicException {
 
  public function __construct($message, $code = 0, $previous = null)
  {
    
    parent::__construct($message, $code, $previous);
    
  }
  
  public function __toString()
  {
    return sprintf("%s: [%s]: %s", __CLASS__, $this->code, $this->message);
  }
  
}