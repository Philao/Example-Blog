<?php

function recents() {
	$recent = "SELECT id, title, updated, author, content, picture, created
				FROM blog
				ORDER BY created DESC
				LIMIT 4";
	return $recent;
};

function modifiedQuery($query, $value) {

	$cat = $query;
	$val = $value;
	$val = str_replace( '%20',' ', $val);
				
	$blog = 	"SELECT id, title, updated, author, content, picture, created
				FROM blog
				WHERE $cat  =  '$val' 
				ORDER BY created DESC
				LIMIT 4";
	return $blog;
}

function originalQuery() {
	
	$blog = 	"SELECT id, title, updated, author, content, picture, created
				FROM blog
				ORDER BY created DESC
				LIMIT 4" ;
	return $blog;
}

function commentQuery($article) {
	
	$qcomment = "SELECT *
				FROM comments
				WHERE article = '$article'
				ORDER BY ctime";
	return $qcomment;
}

function selectAuthor() {
	
	$select = 	"SELECT author
				FROM blog
				GROUP BY author
				ORDER BY author" ;
	return $select;
}

function selectTitle() {
	
	$select = 	"SELECT title
				FROM blog
				GROUP BY title
				ORDER BY title" ;
	return $select;
}

function selectDate() {
	$select = 	"SELECT CONCAT(MONTHNAME(created),', ', YEAR(created)) as createcon, YEAR(created) as yecre, MONTH(created) as moncre
				FROM blog
				GROUP BY createcon
				ORDER BY yecre, moncre" ;
	return $select;
}

function submitQuery($title, $author, $date) {
	
   //print_r($date);
    
    $tempArr = Array();
	
	if ($title != 'NULL') {
		$tempArr['title'] = $title;
	}
	
	if ($author != 'NULL') {
		$tempArr['author'] = $author;
	}
	
	if ($date != 'NULL') {
        $date = str_replace(',','',$date);
		$tempArr['created'] = strtotime($date);
	}
	
    //print_r($tempArr['created']);
	//print_r(getdate($tempArr['created']));
    
    $tempLen = count($tempArr);
	$tempItt = 0;
	
	$wherePart = "";
	$wherePart = " WHERE ";
	
	foreach($tempArr as $key => $value) {
		
        if ($key != 'created') {
		    $wherePart .= "$key = '$value' ";
        } else {
            
            
            //print_r(getdate($value));
            $valueTemp =  getdate($value);
            $value2 = mktime(0,0,0,$valueTemp['mon'] +1, 0, $valueTemp['year']);
            
            $wherePart .= "$key BETWEEN FROM_UNIXTIME($value) AND FROM_UNIXTIME($value2)";
        }
        
		if ($tempItt < ($tempLen - 1)) {
			$wherePart .= " AND ";
		}
		
		$tempItt++;
	}
				
	$submit  = 	"SELECT id, title, updated, author, content, picture, created
				FROM blog
				$wherePart
				ORDER BY created DESC";
	return $submit;
}
?>