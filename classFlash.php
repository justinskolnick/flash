<?php

#   Flash
#   Simple flash messaging for developers who have to work in PHP.
# 
# 
#   (c) 2011 Mike Everhart | MikeEverhart.net
#   (c) 2013 Justin Skolnick | justinskolnick.com
#
#
#   LICENSE
# 
#   Licensed under the Apache License, Version 2.0 (the "License");
#   you may not use this file except in compliance with the License.
#   You may obtain a copy of the License at
#   
#     http://www.apache.org/licenses/LICENSE-2.0
#   
#   Unless required by applicable law or agreed to in writing, software
#   distributed under the License is distributed on an "AS IS" BASIS,
#   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#   See the License for the specific language governing permissions and
#   limitations under the License.
#
#
#   CHANGELOG
# 
#   2011-05-15 - v1.0   - Initial Version
#   2012-01-29 - v1.1   - Minor adaptations
#   2012-04-10 - v1.2   - Major revisions
#   2012-04-13 - v1.2.1 - Reworked documentation
#   2012-04-17 - v1.3   - Output moved to instance variable

class Flash {
  
  # start with these types of messages
  # we can always add others
  
  public $defaultMessageTypes = array( 'info', 'warning', 'success', 'error' );
  
  # receives any flash messages assigned $_SESSION
  
  public $messages = array();

  
  ########################################################
  # __set
  
  public function __set( $name, $value ) {
    $this->$name = $value;
  }
  
  
  ########################################################
  # __construct()
  
  public function __construct() {
    
    # start the session
    
    if ( !session_id() ) @session_start();
    
    # create the $_SESSION array if it doesnt already exist
    
    if ( !array_key_exists( 'flash_messages', $_SESSION ) ) {
      $_SESSION['flash_messages'] = array();
    }
      
  }
  
  
  ########################################################
  # add()
  #
  # adds a new message to the queue
  
  public function add( $type, $message ) {
    
    # don't proceed unless the $_SESSION exists
    
    if ( !isset( $_SESSION['flash_messages'] ) ) return false;
    
    # no blank $type, no empty $message
    
    if ( !isset( $type ) ) return false;
    if ( !isset( $message[0] ) ) return false;
    
    # trim any leading or trailing whitespace
    
    $message = trim( $message );  

    # if the session array for this type doesn't exist, create it
    
    if ( !array_key_exists( $type, $_SESSION['flash_messages'] ) ) {
      $_SESSION['flash_messages'][$type] = array();
    }
    
    # or, if it's not a default message type, add the type to the array
    
    if ( !in_array( $type, $this->defaultMessageTypes ) ) {
      $_SESSION['flash_messages'][$type] = array();
    }
    
    # if the message doesn't already exist in the array, add it
    # no duplicates, please
    
    if ( !in_array( $message, $_SESSION['flash_messages'][$type] ) ) {
      $_SESSION['flash_messages'][$type][] = $message;
    }
    
    return true;
    
  }
  
  
  ########################################################
  # moveMessages()
  #
  # assigns queued messages to the $messages instance variable
  # clears the $_SESSION
  
  private function moveMessages() {
  
    # $this->messages is empty until it's received the $_SESSION array
    # if we've already called this function, $this->messages won't be empty
    
    if ( !empty( $this->messages ) ) return true;
    
    # don't proceed unless the $_SESSION has something for us
    # if we've already called this function, $_SESSION['flash_messages'] will be null
    
    if ( !isset( $_SESSION['flash_messages'] ) ) return false;
    
    if ( is_null( $_SESSION['flash_messages'] ) ) return false;
    
    # assign $_SESSION array to $this->messages
    
    $this->messages = $_SESSION['flash_messages'];
    
    $this->clear();
    
    return true;
  
  }
  
  
  ########################################################
  # hasErrors()
  #
  # checks for queued error messages
  
  public function hasErrors() {
    return $this->hasMessages( 'error' );
  }
  
  
  ########################################################
  # hasMessages()
  #
  # checks for queued messages
  
  public function hasMessages( $type = null ) {
    
    # please see guard clauses in moveMessages()
    
    if ( !$this->moveMessages() ) return false;
  
    # a null $type indicates all messages
    
    if ( is_null( $type ) ) {
    
      if ( !empty( $this->messages ) ) return true;
      
    # a non-null $type indicates messages for that $type
    
    } else {
    
      if ( !empty( $this->messages[$type] ) ) return true;
        
    }
    
    return false;
    
  }
  
  
  ########################################################
  # clear()
  #
  # deletes all the queued messages in the session data
  
  private function clear( $type = null ) {
  
    if ( is_null( $type ) ) {
      unset( $_SESSION['flash_messages'] );
    } else {
      unset( $_SESSION['flash_messages'][$type] );
    }
    
    return true;
  }
  
  
}

?>