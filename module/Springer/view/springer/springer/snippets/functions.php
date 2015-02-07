<?php
##This file is the place to save all basic functions
function redirect_to($location = NULL) {
	if($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}

function get_data() {
	global $api_key_images;	
	global $api_key_meta;
	global $collection;
	global $country;
	global $subject;
	global $year;
	global $userKeyWord;
	global $collection_title;
	global $is_adv;
	global $start;
	global $pageSize;
    
	$_SESSION['start'] = $start;
	$_SESSION['pageSize'] = $pageSize;
	
	switch ($collection) {
		case 1:
			$collection_title = "metadata";
			$key = $api_key_meta;
			break;
		case 2:
			$collection_title = "images";
			$key = $api_key_images;
			break;			
	}
	
	if ($is_adv == true) {

		$amp;
		$AND;
		
		if ($country != NULL) { 
			$search_country = "country:" . urlencode($country);
			$AND = true;
		}
		if ($subject != NULL) {
			if ($AND != false) { $amp = "%20OR%20"; }
			$search_subject = $amp . "subject:" . urlencode($subject);
			$AND = true;
		}
		if ($year != NULL) {
			if ($AND != false) { $amp = "%20AND%20"; }
			$search_year = $amp . "year:" . urlencode($year);
			$year_set = $year;
			$AND = true;
		}
		if ($userKeyWord != NULL) {
			if ($AND != false) { $amp = "%20AND%20"; }
			$search_keyword = $amp . "keyword:" . urlencode($userKeyWord); 
		}
		
		$data_url	= 'http://api.springer.com/' . urlencode($collection_title) . '/json?q=' . $search_country . $search_subject . $search_year .  $search_keyword . '%20sort:date&s=' . $start . '&p=' . $pageSize . '&api_key=' . urlencode($key);
	
	} else {
		$search_keyword = "keyword:" . urlencode($userKeyWord); 
		$data_url	= 'http://api.springer.com/' . urlencode($collection_title) . '/json?q=' . $search_keyword . '%20sort:date&s=' . $start . '&p=' . $pageSize . '&api_key=' . urlencode($key);
	}
	
	$data		= file_get_contents($data_url);
	$_SESSION['data_url'] = $data_url;
	return load_json($data);
}

function load_json($json) {
	global $pageSize;	
    
	$result		= json_decode($json);
	$r			= array();
	$r			= $result->records;
	
	$total = $result->result[0]->total;
			
	if ($r != NULL) {
		$output = "<h3>There are " .  number_format($total) . " total results.</h3> \n";
		$output .= "<ul data-role='listview' data-theme='a' data-divider-theme='a' data-filter='true' data-filter-placeholder='Search results...' data-inset='true'> \n";
        $output .= build_list($r);
		$output .= "</ul> \n
		                <br class=\"clearfloat\"> \n
		            <div id=\"loading\"></div> \n
		            <br /><div id=\"btn-group\" data-role=\"controlgroup\"> \n
		            	<a onClick=\"goto_top();\" data-role=\"button\" data-icon=\"arrow-u\" data-theme=\"a\">Back to Top</a> \n";
        if ( ($_SESSION['start'] + $pageSize) < $total ) {              
            $output .= " <a id=\"g-btn\" onClick=\"get_more();\" data-role=\"button\" data-icon=\"Plus\" data-ajax=\"true\" data-theme=\"a\">Find More Novels</a> \n";
        }
		$output .= "</div> \n";   
	} else {
		$output .= "<h3>No results containing all your search terms were found.</h3> \n <p>Suggestions:</p> \n
					<ul> \n
						<li>Make sure all words are spelled correctly.</li> \n
						<li>Try different keywords.</li> \n
						<li>Try more general keywords.</li> \n
					</ul> \n";
	}
	
	return $output;
	
}

function build_list($r) {
	
	$y_arr = array();
	
	for ($i = 0; $i < count($r); $i++) {
		if ($r[$i]->title != NULL) {
			$n_year =  strtotime($r[$i]->publicationDate);
			array_push($y_arr, date("Y", $n_year));	
		}			
	} 
	
	$year_arr		= array_unique($y_arr);
	$header_nonxist	= $_SESSION['current_header'];
	
	foreach ($year_arr as $y) {
		
		if ($header_nonxist != $y) {
			$output .= "<li data-role=\"list-divider\">" . $y . "</li>";
		}
		$_SESSION['current_header'] = $y;

		for ($i = 0; $i < count($r); $i++) {
			
			$novel = new Novel();
			
			$novel->identifier			= htmlentities($r[$i]->identifier, ENT_IGNORE, 'utf-8');
			$novel->title				= htmlentities($r[$i]->title, ENT_IGNORE, 'utf-8');
			$novel->creators			= $r[$i]->creators;
			$novel->publicationName		= htmlentities($r[$i]->publicationName, ENT_IGNORE, 'utf-8');
			$novel->issn				= htmlentities($r[$i]->issn, ENT_IGNORE, 'utf-8');
			$novel->isbn				= htmlentities($r[$i]->isbn, ENT_IGNORE, 'utf-8');
			$novel->doi					= htmlentities($r[$i]->doi, ENT_IGNORE, 'utf-8');
			$novel->publisher			= htmlentities($r[$i]->publisher, ENT_IGNORE, 'utf-8');
			$novel->publicationDate		= htmlentities($r[$i]->publicationDate, ENT_IGNORE, 'utf-8');
			$novel->vol					= htmlentities($r[$i]->volume, ENT_IGNORE, 'utf-8');
			$novel->number				= htmlentities($r[$i]->number, ENT_IGNORE, 'utf-8');
			$novel->startingPage		= htmlentities($r[$i]->startingPage, ENT_IGNORE, 'utf-8');
			$novel->url					= htmlentities($r[$i]->url, ENT_IGNORE, 'utf-8');
			$novel->copyright			= htmlentities($r[$i]->copyright, ENT_IGNORE, 'utf-8');	
			
			$n_time = strtotime($novel->publicationDate);
			$n_timeYear = date("Y",$n_time);
			
			if ($n_timeYear == $y) {
				$output .= $novel->novel_display();
			}
			
		}				
		
	}

	return $output;
	
}

function get_trends_for_search() {
	
	$data_url 	= $_SESSION['data_url'];
	
	$st1 		= '&s=' . $_SESSION['start'] . '&';
	$st2 		= '&s=1&';
	$st3		= '&p=' . $_SESSION['pageSize'];
	$n 			= $_SESSION['start'] + $_SESSION['pageSize']; 
	$st4		= '&p=' . $n;
	
	$a = str_replace($st1,$st2,$data_url);
	$b = str_replace($st3,$st4,$a);

	$data		= file_get_contents($b);	
	
	$result		= json_decode($data);
	$r			= array();
	$r			= $result->records;
	
	$month_arr = array();
	
	for ($i = 0; $i <= count($r); $i++) {

		$timestamp = strtotime($r[$i]->publicationDate);
		$month = date("m", $timestamp);

		array_push($month_arr,$month);

	}

	$arr	= array_count_values($month_arr);
	
	ksort($arr);
	
	$key	= array_keys($arr);
	$value	= array_values($arr);
	
	for ($i = 0; $i < count($arr); $i++) {		
	
		$k = date("F", mktime(0, 0, 0, $key[$i], 1));
		
		if ($i == 0) {
			$output .= "{ month: \"" . $k . "\",";
		} else {
			$output .= ", { month: \"" . $k . "\",";
		}

		$output .= "issues: " . $value[$i] ."}";
			 
	}

	return $output;
	
}

function display_related_images() {
	global $api_key_images;	
	global $api_key_meta;
	
	$url = $_SESSION['data_url'];
	$str = str_replace($api_key_meta,$api_key_images,$url);
	$str2 = str_replace('metadata','images', $str);
	$str3 = str_replace('%20sort:date','%20type:Image', $str2);
    
    $data_url	= $str3;
	
	$st1 		= '&s=' . $_SESSION['start'] . '&';
	$st2 		= '&s=1&';
	$st3		= '&p=' . $_SESSION['pageSize'];
	$n 			= $_SESSION['start'] + $_SESSION['pageSize']; 
	$st4		= '&p=' . $n;
	
	$a = str_replace($st1,$st2,$data_url);
	$b = str_replace($st3,$st4,$a);	
	
    $data		= file_get_contents($b);	
	
	$result		= json_decode($data);
	$r			= array();
	$r			= $result->records;
    
	if ($r != NULL) {
		$output = "<h3>Related images</h3> \n";
		$output .= "<ul class=\"img-list\"data-role=\"listview\" data-inset=\"true\" data-filter=\"true\"> \n";
		
		for ($i = 0; $i <= count($r); $i++) {
		
			$image = new Image();
			
			$image->as_related			= true;
			$image->caption				= htmlentities($r[$i]->caption, ENT_IGNORE, 'utf-8');
			$image->articleTitle		= htmlentities($r[$i]->articleTitle, ENT_IGNORE, 'utf-8');
			$image->sourceTitle			= htmlentities($r[$i]->sourceTitle, ENT_IGNORE, 'utf-8');
			$image->subjectCollection	= htmlentities($r[$i]->subjectCollection, ENT_IGNORE, 'utf-8');	
			$image->authors_arr			= htmlentities($r[$i]->authors, ENT_IGNORE, 'utf-8');
			$image->institutions_arr	= htmlentities($r[$i]->institutions, ENT_IGNORE, 'utf-8');
			$image->keywords_arr		= htmlentities($r[$i]->keywords, ENT_IGNORE, 'utf-8');
			$image->subjects_arr		= htmlentities($r[$i]->subjects, ENT_IGNORE, 'utf-8');
			$image->images_arr			= $r[$i]->file;
			
			$output .= $image->image_display();
			
		} #End for loop 
		
		$output .= "<br class=\"clearfloat\" /></ul> \n";
		$output .= "<a onClick=\"goto_top();\" data-role=\"button\" data-icon=\"arrow-u\" data-theme=\"b\">Back to Top</a>";
	}
	
   return $output;
}

function get_current_search() {
	return $_SESSION['data_url'];
}
?>