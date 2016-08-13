<?php

########################################################
# SETUP

# require Flash.php
require_once realpath( './../Flash.php' );

# create the Flash object
$flash = new \justinskolnick\Flash\Flash();

########################################################
# CUSTOM THINGS

# set required fields
$required_fields = [ 'field1', 'field2' ];

# set default field values
$field1_value = "This field is complete";
$field2_value = "This field is complete";
$field3_value = "";

# process POST
if ( $_POST ) {
  
  # trim any leading or trailing whitespace from POST values
  $post_values = array_map( 'trim', $_POST );

  # override default field values with POST values
  $field1_value = $post_values['field1'];
  $field2_value = $post_values['field2'];
  $field3_value = $post_values['field3'];

  # loop through required fields
  foreach( $required_fields as $field ) {
  
    # if a field in POST values is empty ...
    if ( empty( $post_values[ $field ] ) ) {
    
      # ... log an error
      $flash->add( 'error', "{$field} can't be empty" );
    
    # otherwise ...
    } else {
  
      # ... make note of the success, just to be nice
      $flash->add( 'success', "{$field} looks good" );
    
    }

  }
  
}

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>PHP Flash Messages</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width" />

  <link rel="stylesheet" href="styles/default.css" />
  <link rel="stylesheet" href="styles/github.css" />
</head>
<body>
  
<div class="examples">
  
  <div class="example">
  
    <header>
      
      <h1>PHP Flash Messages</h1>
      
    </header>
    
    <article>
    
      <h2>Example 1: Everything checks out</h2>
    
      <p>Our two required fields are complete; on POST we reward the user for meeting the requirements. Should the user clear a required field of its value, an error message appears.</p>
      
      <p>Messages are displayed in the order in which they were set.</p>
      
    </article>
    
<?php

########################################################
# FLASH MESSAGING

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
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
      <fieldset>
      
        <div class="field">
          <label for="field1" class="required">This field is required</label>
          <input type="text" name="field1" id="field1" value="<?php echo $field1_value; ?>" />
        </div>
      
        <div class="field">
          <label for="field2" class="required">This field is required</label>
          <input type="text" name="field2" id="field2" value="<?php echo $field2_value; ?>" />
        </div>
      
        <div class="field">
          <label for="field3">This field is not required</label>
          <input type="text" name="field3" id="field3" value="<?php echo $field3_value; ?>" />
        </div>
        
      </fieldset>
      
      <button type="submit">Test</button>
      
    </form>
    
    <article>
      
      <h3>Code used in this example</h3>
      
<pre><code data-language="php">&lt;?php
if ( $flash-&gt;hasMessages() ) {
?&gt; 
    &lt;div class="flash"&gt;
&lt;?php
    foreach( $flash->messages as $type =&gt; $messages ) { 
      foreach( $messages as $message ) {
?&gt; 
      &lt;p class="flash-&lt;?php echo $type; ?&gt;"&gt;&lt;?php echo $message; ?&gt;&lt;/p&gt;
&lt;?php
      }
    }
?&gt; 
        
    &lt;/div&gt;
&lt;?php
}
?&gt;</code></pre>

      
      <p>The above PHP produces the following HTML:</h3>
      
<pre><code data-language="html">&lt;div class="flash"&gt;
   &lt;p class="flash-error"&gt;There was a problem&lt;/p&gt;
   &lt;p class="flash-success"&gt;There was no problem&lt;/p&gt;
&lt;/div&gt;</code></pre>
    
    </article>
  
  </div>
  
  <nav>
    
    <h2>Examples</h2>
    
    <dl>
    
      <dt><a href="example-1.php">Example 1</a></dt>
      <dd>Everything checks out</dd>
      
      <dt><a href="example-2.php">Example 2</a></dt>
      <dd>Grouping flash messages by type</dd>
      
      <dt><a href="example-3.php">Example 3</a></dt>
      <dd>Showing errors only</dd>
      
    </dl>
    
  </nav>
  
  <footer>
  
  <p>Syntax highlighting via Craig Campbell&rsquo;s <a href="https://github.com/ccampbell/rainbow">Rainbow</a> using the GitHub theme.</p>
  
  </footer>

</div>

<script src="scripts/rainbow-custom.min.js"></script>

</body>
</html>
