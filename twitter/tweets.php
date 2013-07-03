<?php
/* ini_set('display_errors', 1); */
require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "22012765-ce5FvX5rg2kd8SMtUNFNjJWxU6WYIlgkHLV0vwyBu",
    'oauth_access_token_secret' => "nuSa3p7frBPC4mRqmN7UTtLKaQddhRBVtNuY5g9AO18",
    'consumer_key' => "ewjQ9o3NiwLFQohFh0iQw",
    'consumer_secret' => "PUg2Hx5bS5Lp9XoDdXohzZDTR0pyO1LhQa3pR1xs"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
$url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
$requestMethod = 'GET';


/** POST fields required by the URL above. See relevant docs as above **/
/*$postfields = array(
    'screen_name' => 'usernameToBlock', 
    'skip_status' => '1'
);*/

/** Perform a POST request and echo the response **/
/*$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();
*/

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=GoodFoodChannel&count=5';
$twitter = new TwitterAPIExchange($settings);
/*
echo $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
*/



$data = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();


$output = '<h4>Twitter Feed:</h4>';

if ($data) {
    
    // Twitter returns an array of objects, one object for each tweet
    $obj_array = json_decode($data);
    
    // Validate the object
    if (is_array($obj_array)) {
    
        // DEBUG
        //echo '<pre>';
        //print_r($obj_array);
        //echo '</pre>';
		
       
        // We can loop through the array to access each object
     
		foreach ($obj_array as $tweet) {
            $output .= '<div class="tweet">';
            $output .= '<div class="timage"><img src="'.$tweet->user->profile_image_url.'" /></div>';
            $output .= '<span class="tuname">' . $tweet->user->name . '</span>' . '<span class="tsname"></br>' . linkify_sname('@' . $tweet->user->screen_name) . '</span></br>';
            $output .= '<span class="ttext">' . linkify_tweet($tweet->text) . '</span>' . '<br />';
            $output .= '<span class="tcreated">' . ttime($tweet->created_at) . '</span>' . '<br />';
            $output .= '</div>';
			
			
			
        } 

		 
		 
    } else {
        echo 'Oops... Type failure...';
        echo '<pre>';
        var_dump($obj_array);
        //print_r($obj_array);
        echo '</pre>';
    }
    
} else {
    // Get the error codes and messages
    if(curl_errno($my_curl)) {
        echo 'Oops... Curl error: ' . curl_errno($my_curl) . ' :: ' . curl_error($my_curl);
    }
}

/*
    Function to parse a tweet and convert URLS, hashtags and all the 
    rest of the nonsense to proper URLs
*/
function linkify_tweet($v) {
    
    $v = ' ' . $v;

    $v = preg_replace('/(^|\s)@(\w+)/', '\1<a href="http://www.twitter.com/\2" target="_blank">@\2</a>', $v);
    $v = preg_replace('/(^|\s)#(\w+)/', '\1<a href="http://search.twitter.com/search?q=%23\2" target="_blank">#\2</a>', $v);
    $v = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $v);
    $v = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" >\\2</a>'", $v);
    $v = preg_replace("#(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $v);

    return trim($v);
}

function linkify_sname($v) {
    $v = preg_replace('/(^|\s)@(\w+)/', '\1<a href="http://www.twitter.com/\2" style="text-decoration: none; color:gray" target="_blank">@\2</a>', $v);
    
    return trim($v);
}

function ttime($t) {
    $t = strtotime($t);
    $present = time();
    
    $temp = $present - $t;
    $ago = $temp / 60;
    
    $round = floor($ago);
    
    return strval($round) . 'm';
}


echo $output;
?>