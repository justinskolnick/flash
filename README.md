# Flash

Simple flash messaging for PHP applications.

Flash is a PHP class built around the `$_SESSION` superglobal array. Messages are added to the array by means of a function; messages are printed by looping through an array.

## Credits

The `$_SESSION` array is easy to manipulate and easy to make a mess of. This class would not exist without the good order of Mike Everhart's solid [PHP Session-Based Flash Messages](https://github.com/plasticbrain/PHP-Flash-Messages). 

The code in this repository represents a significant departure from Everhart's work. The original class was modified within the codebase of a client application, in isolation from his project, and towards a different end than he appears to be pursuing. I encourage developers to compare the projects and use the class most appropriate to their needs.

## Installation

Drop `classFlash.php` into the directory of your choice. Require the file and instantiate the class.

``` php
require_once( 'classFlash.php' );

$flash = new Flash();
```

## Usage

Add messages by passing a message type and a message to `add()`. By default, four message types are supported: `'info'`, `'warning'`, `'success'`, and `'error'`. 

``` php
$flash->add( "error", "This field can't be empty" );
$flash->add( "warning", "It's fine but don't do it again" );
```

Other types may be added by means of the first argument.

``` php
$flash->add( "reminder", "Take out the trash" );
```

Print messages by looping through the class's `$messages` array. Note that `hasMessages()` (or `hasErrors()`) must be called at least once per instance.

``` php
<?php
if ( $flash->hasMessages() ) {
?> 
    <div class="flash">
<?php
    foreach( $flash->messages as $type => $messages ) { 
      foreach( $messages as $message ) {
?> 
      <p class="flash-<?php echo $type; ?>"><?php echo $message; ?></p>
<?php
      }
    }
?> 
    </div>
<?php
}
?> 
```

Refer to the [examples](https://github.com/justinskolnick/flash/tree/master/examples) for additional usage.

## TODO

Maybe a few more examples.

## LICENSE

Copyright © 2011 Mike Everhart

Copyright © 2013-2014 Justin Skolnick

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at

```
http://www.apache.org/licenses/LICENSE-2.0
```

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
