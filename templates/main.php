<?php
	$blogTotal = count($blogPost);
	if ($blogTotal == 0) {
		echo "No results!! Please try again.";
	}
	
	for ( $i = 0; $i < $blogTotal; $i++) {
		echo	'<div class="post">' . "\n" . "\t" .
					'<div class="title">' . "\n" . "\t" . "\t" .
						'<h2>' . "\n" . "\t" . "\t" .
							'<a href="index.php?query=title&value='. $blogPost[$i]['title'] . '">' . $blogPost[$i]['title'] . '</a>' . "\n" . "\t" . "\t" .
						'</h2>' . "\n" . "\t" . 
					'</div>' . "\n" . "\t" .
					'<div class="picture">'	.  "\n" . "\t" . 
						'<img src="pics/' . $blogPost[$i]['picture'] . '">' .
					'</div>' . "\n" . "\t" . 
					'<div class="content">' . "\n" .
						$blogPost[$i]['content'] . "\n" . "\t" . 
					'</div>' . "\n" . "\t" . 
					'<div class="dateAuthor">' . "\n" . "\t" . 
						'<br/>' . "\n" . "\t" .  '<p>' . "\n" . "\t" . 
						'Date: ' . date("j M Y", strtotime($blogPost[$i]['created'])) . ' ' .
						'Author: ' . '<a href="index.php?query=author&value='. $blogPost[$i]['author'] . '">' . $blogPost[$i]['author'] . '</a>' . "\n" . 
						'</p>' . '</div>' .
					'</div>';
		
		$postid = $blogPost[$i]['id'];
	}
	
	if(isset($_GET) && $blogTotal === 1) {
		echo '<div id="comments">'; 
		echo 	'<p>Comments</p>';
		include 'templates/comments.php'; 
		echo '</div>';
		//echo $postid;
	}
?>
