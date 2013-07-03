<?php
	
	$pagetitle = $blogPost[0]['title'];
	$article =$blogPost[0]['id'];
	
    if (!mysqli_set_charset($conx, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($link));
    }

	
	if(isset( $_POST['submit'])){
		
		
		$expected = array('name','email','comment');
		$missing = array();
		$invalid = array();
		
		
		foreach ($_POST as $key => $value){
			
			
			if(in_array( $key, $expected )){
			 
				$trimmed = trim($value);
				if ( $trimmed != '' ){
					
					switch ($key){
				
					
					case 'name':
					  $validName = '/^[A-Za-z][A-Za-z\-\' ]+$/';	
					  if (!preg_match($validName, $value)) {
							$invalid[] = $key;
						}
					break;
					
					case 'email':
					$validEmail = '/^[^@]+@[^\s\r\n\'";,@%]+$/';
					if (!preg_match($validEmail, $value)) {
						$invalid[] = $key;
					 }
					break;
				}
					
					
					${$key} = $trimmed;	
				}
				else {
					
					$missing[] = $key;
					
				}
			}	
		} 

		if (! empty($missing)){
			$errormsg = '<p class="error">Please fill in all the fields!</p>';
		}
		if (! empty($invalid)){
			$errormsg .= '<p class="error">The following fields are invalid :<br/>';
			foreach ($invalid as $v){
				$errormsg .= '-' . ucfirst(str_replace('_',' ',$v)) . '<br/>';
			}
			$errormsg .='</p>';
		}
		
		else {
			
			//$okmsg = '<p class="ok">Success</p>';
				
			// Now you would go ahead and do the db connection,
			//  prep vars for db, do query and give feedback.
		
			if( $conx = dbConnect() ){
			
			// sprintf() formats a string with placeholders for our (-in this case-) string values, with '%s'
				$sqlAdd = sprintf(
		
					"INSERT INTO comments
					(uname, email, ucomment, ctime, article)
					VALUES
					('%s', '%s', '%s', NOW(), $article)
					",
					mysqli_real_escape_string( $conx, $name ),
					mysqli_real_escape_string( $conx, $email),
					mysqli_real_escape_string( $conx, $comment )
				);
		
			// for INSERT query, result is boolean true if it inserted ok, false if not
				if( $resultAdd = mysqli_query($conx, $sqlAdd)){
			
					$okmsg = '<p class="ok">Comment  added !</p>';
				
				// unset our form vars so they don't persist once query is done
					foreach($_POST as $k => $v){
						unset( $_POST[$k] );
					}
				}
				else {
					$errormsg = '<p class="error">Sorry, unable to add comment...</p>' . mysql_error();
				}
		
			}
			    else {
				$errormsg = '<p class="error">Sorry, server sleeping, come back later...</p>' . mysql_error();
			}
		
		
		}
		
		
	} // if submitted
?>

<?php

	// Creates list of comments
	
	$commentArray = Array();
	$sqlComment = commentQuery($postid);
	//var_dump($sqlComment);
	$resultComment = mysqli_query($conx, $sqlComment);
	
	while($crow = mysqli_fetch_assoc($resultComment)) 
		{
			array_push($commentArray, $crow);
		};

?>
<div id="pastComments">
	<?php
	$commentTotal = count($commentArray);
	for ( $i = 0; $i < $commentTotal; $i++)
		{
		$no = ($i +1);
	echo '<div class="commentbox">' . 
		'<div class="commentName">' . 
		$no  . '. ' . 	$commentArray[$i]['uname'] . '</div><br/>' . 
		'<div class="comment">' . stripslashes($commentArray[$i]['ucomment']) . '</div><br/>' . 
		'<div class="time">' . $commentArray[$i]['ctime'] . '</div>' . '<br/><br/>' .
		'</div>';
		}
	?>
</div>

<div id="commentForm">
	
  
	<form method="post" action="index.php?query=title&value=<?php echo $pagetitle;?>">
	<p>Add Comment<p>
	
	
    <label for="name">Display Name:</label></br>
	<input id="nameBox" type="text" name="name" value="<?php if(isset($_POST['name'])) echo htmlentities($_POST['name'])?>" />
	</br>
	<label for="email">Email:</label>  </br>
	<input id="emailBox" type="text" name="email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email'])?>" />
	<br/>
	
	<label for="comment">Comment:</label> <br/>
	<textarea id="commentBox" name="comment" value="<?php if(isset($_POST['comment'])) echo htmlentities($_POST['comment'])?>">
	</textarea>
	
	<br/>
	<input type="submit" name="submit" value="Send" />
	
	</form>
	
	<?php 
		// if we have feedback vars set, they'll be echoed here:
	 if(isset( $errormsg )){
		 echo $errormsg;
	 }
	if(isset( $okmsg )){
		 echo $okmsg;
	 }	
	?>

</div>
