<?php

include 'functions/connect.php';
include 'functions/queries.php';
$conx = dbconnect();
$recentArray = Array();
$recent = recents() ;
$resultRecent = mysqli_query($conx, $recent);
$blogPost = Array();
while($rowRecent = mysqli_fetch_assoc($resultRecent)) {
	array_push($recentArray, $rowRecent);
};

//var_dump($recentArray);



$selectTitle = selectTitle();
//print_r($selectTitle);

$selectAuthor = selectAuthor();
$selectDate = selectDate();

$selectTitleArray = Array();
$selectAuthorArray = Array();
$selectDateArray = Array();

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

//print_r($blog);

$result = mysqli_query($conx, $blog);

//print_r($result);

while($row = mysqli_fetch_assoc($result)) 
{
	array_push($blogPost, $row);
};



include 'templates/template.php';


?>