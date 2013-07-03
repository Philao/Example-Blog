<form id="select"  action="index.php" method="get">
	<select id='title' name="title">
		<option value="NULL" selected>Title</option>
			<?php
				$titleLen = count($selectTitleArray);
			
				for ($i = 0; $i < $titleLen; $i++) {
					echo '<option name="'. $selectTitleArray[$i]['title'] . '">' . $selectTitleArray[$i]['title'] . '</option>';
				}		
			?>
	</select>
		
	<select id='author' name="author">
		<option value="NULL" selected>Author</option>
			<?php
				$authorLen = count($selectAuthorArray);
				
				for ($i = 0; $i < $authorLen; $i++){
					echo '<option name="'. $selectAuthorArray[$i]['author'] . '">' . $selectAuthorArray[$i]['author'] . '</option>';
				}	
			?>
	</select>
	
	<select id='date' name="created">
		<option value="NULL" selected>Date</option>
		<?php
			$dateLen = count($selectDateArray);
				
			for ($i = 0; $i < $dateLen; $i++){
				echo '<option name="'. $selectDateArray[$i]['createcon'] . '">' . $selectDateArray[$i]['createcon'] . '</option>';
			}
		?>
			
		<?php
			$titleVal = ""; 
			$authorVal = "";
			$dateVal = "";
		?>
	</select>
	
	<input type="submit" id="submit" value="Submit" />
	
</form>
