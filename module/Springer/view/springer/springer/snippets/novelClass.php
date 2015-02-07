<?php
class Novel {

	var $identifier;
	var $title;
	var $creators;
	var $publicationName;
	var $issn;
	var $isbn;
	var $doi;
	var $publisher;
	var $publicationDate;
	var $vol;
	var $number;
	var $startingPage;
	var $url;
	var $copyright;
	
	public function novel_display() {
		
		$output .= "<li><a href=\"" . $this->url . "\" rel=\"external\" title=\"Find &ldquo;". $this->title . "&rdquo; on SpringerLink.\"> \n";	
		$output .= "	<h3>" . $this->title . "</h3> \n";
		$output .= "	<p><strong>" . $this->publicationName . $this->get_volume() . $this->get_number() . $this->get_startingPage() .  "</strong></p> \n";

		if ($this->get_creators()!= NULL) {				
			$output .= "	<p><strong>By,</strong> " . $this->get_creators() . "</p>";
		}
		
		$output .= "	<br class=\"clearfloat\" /> \n";
		$output .= "	<p class=\"smaller\"><u><strong>Published:</strong> " . $this->get_formatted_date() . ". by, " . $this->publisher . "</u><br /> \n";
		$output .= "	<span class=\"smaller\">" . $this->copyright . "</span></p>";	
		$output .= "</a></li> \n";
		
		return $output;
	}
	
    public function get_authors() {
        //$output .= "<li> \n";	
        $output .= $this->get_creators();
        //$output .= "</a></li> \n";
        
        return $output;
    }
    
	private function get_amazon_link() {
		if ($this->isbn != NULL) {
			$link = "				<li><a href=\"http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=" . 
			$this->isbn . "\" target=\"_blank\" title=\"Look for &ldquo;". $this->title . "&rdquo; on Amazon.com.\">
			<img src=\"images/amazon_icon.gif\" alt=\"Amazon.com\" class=\"noborder\" /></a></li> \n";
		}
		
		return $link;
	}
	
	private function get_creators() {
		$arr = array();
		$arr = $this->creators;
		
		for ($i = 0; $i< count($arr); $i++) {
			if ($i < count($arr) && $i +1 != count($arr)) {
				$output .= $arr[$i]->creator . ", ";	
			}
			if ($i +1 == count($arr)) {
				$output .= $arr[$i]->creator . ". \n";
			}
		}
		
		return $output;
	}
	
	private function get_volume() {	
		if ($this->vol != NULL) {
			$volume = " | Vol. " . $this->vol . ".";
		}
		
		return $volume;
	}

	private function get_number() {
		if ($this->number != NULL) {
			$number = " | No. " . $this->number . ".";				
		}
		
		return $number;
	}
	
	private function get_startingPage() {		
		if ($this->startingPage != NULL) {
			$startingPage = " | Pg. " . $this->startingPage . ".";	
		}
		
		return $startingPage;
	}
	
	private function get_issnLink() {		
		if ($this->issn != NULL) {
			$issnLink = "<p align=\"right\" class=\"smaller\" ><a href=\"?i=" . urlencode($this->issn) . "\">&raquo; Related novels</a></p> \n";	
		}
		
		return $issnLink;
	}	
	
	private function get_formatted_date() {
		$date = $this->publicationDate;
		$timestamp = strtotime($date);
		$date = date("F j, Y", $timestamp);
		
		return $date;
        
	}

}
?>