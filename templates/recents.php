<h4>Recent Blogs:</h4>
	
	<?php
		$recentTotal = count($recentArray);
		for ( $i = 0; $i < $recentTotal; $i++){
			echo 	 '<div class="recentLoop">' .
                        '<a href="index.php?query=title&value='. $recentArray[$i]['title'] .'" class="recentText">'. 
                        '<img src="pics/'. $recentArray[$i]['picture'] . '" class="recentImage"></img>' .
    					    date("j M Y", strtotime($recentArray[$i]['created'])) . '<br>'
    						. $recentArray[$i]['title'] . '<br> ' . 
    						$recentArray[$i]['author'] . 
    						 
    					'</a>' .
                    '</div>';
		}
	?>