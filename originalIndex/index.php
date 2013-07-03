<?php
	$blogTitle = "The London Food Blog";
	// In real situation I would declare objects or at least arrays.
		include '/_functions/func.php';
		//mysqli_query($conx, $sqlTitle) ;
		$conx = dbconnect();
		$recentArray = [];
		$recent = recents() ;
		$resultRecent = mysqli_query($conx, $recent);
		
		while($rowRecent = mysqli_fetch_assoc($resultRecent)) 
		{
			array_push($recentArray, $rowRecent);
		};
		//var_dump($recentArray);
		
		
		
		$selectTitle = selectTitle();
		$selectAuthor = selectAuthor();
		$selectDate = selectDate();
		
		$selectTitleArray = [];
		$selectAuthorArray = [];
		$selectDateArray = [];
		
		$selectTitleResult = mysqli_query($conx, $selectTitle);
		$selectAuthorResult = mysqli_query($conx, $selectAuthor);
		$selectDateResult = mysqli_query($conx, $selectDate);
		
		while($selectTitleRow = mysqli_fetch_assoc($selectTitleResult)) 
		{
			array_push($selectTitleArray, $selectTitleRow);
		};
		
		while($selectAuthorRow = mysqli_fetch_assoc($selectAuthorResult)) 
		{
			array_push($selectAuthorArray, $selectAuthorRow);
		};
		
		while($selectDateRow = mysqli_fetch_assoc($selectDateResult)) 
		{
			array_push($selectDateArray, $selectDateRow);
		};
		//print_r($selectTitleArray);
		
		
		$blogPost = [];
		if (isset($_GET['query']))
		{
			$blog = modifiedQuery($_GET['query'],$_GET['value']);
		}
		
		elseif (isset($_GET['title']) || isset($_GET['author']) || isset($_GET['created']))
		{
			$blog = submitQuery($_GET['title'],$_GET['author'],$_GET['created']);
		}
		else 
		{	
				$blog = originalQuery();
		}
		print_r($blog);
		
		$result = mysqli_query($conx, $blog);
		
		while($row = mysqli_fetch_assoc($result)) 
		{
			array_push($blogPost, $row);
		};
		
		$social = "Social Network Apis here.";
		$comment = "User Comments";
		
?>

<!DOCTYPE html>
<html>
	<head>
		<title>London Food Blog</title>
		 <link href="style.css" rel="stylesheet" type="text/css">
		 <script type="text/javascript" src="http://w.sharethis.com/gallery/shareegg/shareegg.js"></script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ee713217-bbb5-4c6e-a0bc-b71cd2c4114b", onhover:false});</script>
<link media="screen" type="text/css" rel="stylesheet" href="http://w.sharethis.com/gallery/shareegg/shareegg.css"></link>
	</head>
	
	<body>
	<div id="container">
		<div id="titleBar">
			<!-- <div id="search">
				<input type="text" id="searchBox" value="Search" />
				<input type="submit" id="searchSubmit" />
			</div> -->
			<a href="index.php"> <img src="pics/banner.jpg" /> </a>
		</div>
		
		<div id='nav'>
			<form id="select"  action="index.php" method="get">
			<select id='title' name="title">
				<option value="NULL" selected>Title</option>
				<?php
					
					$titleLen = count($selectTitleArray);
					
					for ($i = 0; $i < $titleLen; $i++)
					{
						echo '<option name="'. $selectTitleArray[$i]['title'] . '">' . $selectTitleArray[$i]['title'] . '</option>';
					}
					
				?>
			</select>
			<select id='author' name="author">
				<option value="NULL" selected>Author</option>
				<?php
					
					$authorLen = count($selectAuthorArray);
					
					for ($i = 0; $i < $authorLen; $i++)
					{
						echo '<option name="'. $selectAuthorArray[$i]['author'] . '">' . $selectAuthorArray[$i]['author'] . '</option>';
					}
					
				?>
			</select>
			<select id='date' name="created">
				<option value="NULL" selected>Date</option>
				<?php
					
					$dateLen = count($selectDateArray);
					
					for ($i = 0; $i < $dateLen; $i++)
					{
						echo '<option name="'. $selectDateArray[$i]['created'] . '">' . $selectDateArray[$i]['created'] . '</option>';
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
		</div>
		
		<div id="main">
		
		<?php
		
		$blogTotal = count($blogPost);
		if ($blogTotal == 0) 
		{
			echo "No results!! Please try again.";
		}
		for ( $i = 0; $i < $blogTotal; $i++)
		{
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
		
		if(isset($_GET) && $blogTotal === 1) 
		{
			echo '<div id="comments">'; 
				echo '<p>Comments</p>';
				include 'comments.php'; 
				
			echo '</div>';
			//echo $postid;
		}
		
	
	
		?>
			
		</div>
		
		<div id="sideBar">
			<div id="social">
				<div id='shareThisShareEgg' class='shareEgg'></div>
				<!--<P> Facebook </P>
				<P> Twitter </P>
				<P> Google+ </P> -->
				<script type='text/javascript'>stlib.shareEgg.createEgg('shareThisShareEgg', ['sharethis','facebook','googleplus','twitter','linkedin','pinterest','email'], {title:'ShareThis Rocks!!!',url:'http://www.sharethis.com',theme:'shareegg'});</script>
			</div>
			
			<div id="recent"><h4>Recent Blogs:</h4>
			<?php
			$recentTotal = count($recentArray);
			for ( $i = 0; $i < $recentTotal; $i++)
			{
				echo '<a href="index.php?query=title&value='. $recentArray[$i]['title'] .'">'. '<h5>' . date("j M Y", strtotime($recentArray[$i]['created'])) . '<br>'
				. $recentArray[$i]['title'] . '<br> ' . 
				$recentArray[$i]['author'] . '</h5>' . '</a>';
			}
			?>
			</div>
			<div id="archive">
				<dl>
					<dt>2012</dt>
						<dd>October</dd>
						<dd>September</dd>
						<dd>August</dd>
						<dd>July</dd>
						<dd>June</dd>
						<dd>May</dd>
						<dd>April</dd>
						<dd>March</dd>
						<dd>February</dd>
						<dd>January</dd>
					<dt>2011</dt>
						<dd>December</dd>
						<dd>November</dd>
						<dd>October</dd>
						<dd>September</dd>
						<dd>August</dd>
						<dd>July</dd>
						<dd>June</dd>
						<dd>May</dd>
						<dd>April</dd>
						<dd>March</dd>
						<dd>February</dd>
						<dd>January</dd>
				</dl>
			</div>
		</div>
	</div>	
	</body>
</html>