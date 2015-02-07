<?php
class Image {
	
	var $as_related;
	var $caption;
	var $articleTitle;
	var $sourceTitle;
	var $subjectCollection;
	var $authors_arr;
	var $institutions_arr;
	var $keywords_arr;
	var $subjects_arr;
	var $images_arr = array();	
	
	public function image_display() {
		if ($this->articleTitle!=NULL) {
     		
			$output = "\n	<li> \n";	
			
			if ($this->images_arr != NULL) {
				
				if ($this->images_arr[0]->type == "thumb") {
					
					$output .= "<img src=\"" . $this->images_arr[0]->path . "\" alt=\"" .$this->caption . "\" style=\"padding:5px;\" /> \n";
					
				}
				
			}

			$output .= "		<h3>" . $this->articleTitle . "</h3> \n";		
			$output .= "		<p>". $this->sourceTitle . "<br /> \n";
			$output .= "		<em>" . $this->subjectCollection . "</em></p> \n";
			$output .= "		<p class=\"smaller\">". $this->caption . "</p> \n";
			$output .= "		<br class=\"clearfloat\" /> \n";

			if ($this->authors_arr != NULL) {
				$output .= "<div class=\"inner-list-a\"><strong><span class=\"hilight\">Authors:</span></strong> <span class=\"white\"> \n";
				for ($j = 0; $j <= count($this->authors_arr); $j++) {
					if ($j < count($this->authors_arr) && $j +1 != count($this->authors_arr)) {
						$output .= "<u>" . $this->authors_arr[$j]->author . "</u>, ";
					} 
					
					if ($j + 1 == count($this->authors_arr)) {
						$output .= "<u>" . $this->authors_arr[$j]->author . "</u>. \n";
					}
					
				}		
				$output .= "</span></div>";
			}		

			if ($this->institutions_arr != NULL) {
				$output .= "<div class=\"inner-list-b\"><strong><span class=\"hilight\">Institutions:</span></strong> <span class=\"white\"> \n";
				for ($j = 0; $j <= count($this->institutions_arr); $j++) {
					if ($j < count($this->institutions_arr) && $j +1 != count($this->institutions_arr)) {
						$output .= $this->institutions_arr[$j]->institution . ", ";
					} 
					
					if ($j + 1 == count($this->institutions_arr)) {
						$output .= $this->institutions_arr[$j]->institution . ". ";
					}
				}		
				$output .= "</span></div>";
			}     
	
			if ($this->keywords_arr != NULL) {
				$output .= "<div class=\"inner-list-c\"><strong><span class=\"hilight\">Keywords:</span></strong> <span class=\"white\"> \n";
				for ($j = 0; $j <= count($this->keywords_arr); $j++) {
					if ($j < count($this->keywords_arr) && $j +1 != count($this->keywords_arr)) {
						$output .= "<a href=\"?q=" . urlencode($this->keywords_arr[$j]->keyword) . "&amp;s=2\">" . $this->keywords_arr[$j]->keyword . "</a>, ";
					} 
					if ($j +1 == count($keywords_arr)) {
						$output .= "<a href=\"?q=" . urlencode($this->keywords_arr[$j]->keyword) . "&amp;s=2\">" . $this->keywords_arr[$j]->keyword . "</a>. ";
					} 						
				}		
				$output .= "</span></div>";
			}	
			
			if ($this->subjects_arr != NULL) {
				$output .= "<div class=\"inner-list-d\"><strong><span class=\"hilight\">Subjects:</span></strong> <span class=\"white\"> \n";
				for ($j = 0; $j <= count($this->subjects_arr); $j++) {
					if ($j < count($this->subjects_arr) && $j +1 != count($this->subjects_arr)) {
						$output .= $this->subjects_arr[$j]->subject . ", ";
					} 
					
					if ($j < count($this->subjects_arr)) {
						$output .= $this->subjects_arr[$j]->subject . ". ";
					}
				}		
				$output .= "</span></div>";
			}				

			$output .= "	</li> \n";	
	
			return $output;
		
		}
      		
	}
	
}
?>