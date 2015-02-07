<?php
namespace Springer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Springer\Model\Springer;

class SpringerController extends AbstractActionController
{
    protected $springerInfo;
    
    public function indexAction()
    {
        $springerInfo = $this->getSpringerInfo();
        //$klout        = $this->get_klout( $springerInfo['klout_api_key'] );
        $title        = "Novel Search";
        $is_home      = true;
        $is_trends    = false;
        $errorMsg     = "";
        
        if(isset($_SESSION['current_header'])) {
            unset($_SESSION['current_header']);
        }
        if(isset($_SESSION['start'])) {
            unset($_SESSION['start']);
        }
        if(isset($_SESSION['pageSize'])) {
            unset($_SESSION['pageSize']);
        }
        
        if ( isset($_GET['!']) && $_GET['!'] == 1) {        
            $errorMsg = "<p class=\"error\">Please provide a search term.</p>";        
        }
                
        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            'title'              => $title,
            'is_home'            => true,
            'is_trends'          => $is_trends,
            'errorMsg'           => $errorMsg,
            'api_key_images'     => $springerInfo['api_key_images'],
            'api_key_meta'       => $springerInfo['api_key_meta'],
            'api_key_openaccess' => $springerInfo['api_key_openaccess'],
                ))
        ->setTerminal(true);
        return $viewModel;        
    }
    
    public function aboutAction()
    {
        $title = "About Novel Search";
        $is_home = true;
        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
                'title'              => $title,
                'is_home'            => $is_home,
        ))
        ->setTerminal(true);
        return $viewModel;                
    }
    
    public function moreAction()
    {
        $result = new JsonModel(array( 'success'=>false, ));
    }
    
    public function ajaxAction()
    {
        $case = $this->getEvent()->getRouteMatch()->getParam('id');
        $my_path = '';
        switch($case) {
            case 1:
                #Get advanced search inputs
                $my_path = getcwd().DIRECTORY_SEPARATOR.'module'
                            .DIRECTORY_SEPARATOR.'Springer'
                            .DIRECTORY_SEPARATOR.'view'
                            .DIRECTORY_SEPARATOR.'springer'
                            .DIRECTORY_SEPARATOR.'springer'
                            .DIRECTORY_SEPARATOR.'snippets'
                            .DIRECTORY_SEPARATOR.'adv-form.php';
                ob_start();
                include $my_path;
                $output = ob_get_contents();
                ob_end_clean();

                break;
            case 2:
                #Get more items
            	$st1 		           = '&s=' . $_SESSION['start'] . '&';
            	$m			           = $_SESSION['start'] + $_SESSION['pageSize'];
            	$st2		           = '&s=' . $m . '&';
            	
            	$data_url				= $this->get_current_search();
            	$_SESSION['data_url']	= str_replace($st1,$st2, $data_url);
            	$_SESSION['start']		= $m;            	
            	$data		            = file_get_contents($_SESSION['data_url']);
            	
            	function reload_json($json) {            	
            		$result		= json_decode($json);
            		$r			= array();
            		$r			= $result->records;
            	
            		try {            	
            			$data = $this->build_list($r);            				
            		} catch (Exception $e) {
            			$data = $e;
            		}            	
            		return $data;    	
            	}
            	
            	$output = reload_json($data);                
                break;    
        }
        
        $result = new JsonModel(array( 'success' => true, 'data' => $output, ));
        return $result;
    }    
    
    public function resultsAction()
    {
        $title                = "Results";
        $is_trends          = false;        
        $springerInfo       = $this->getSpringerInfo();
        $collection            = 1;
        $country            = isset($_POST['country']) ? $_POST['country'] : '';
        $subject            = isset($_POST['subject']) ? $_POST['subject'] : '';
        $year                = isset($_POST['year']) ? $_POST['year'] : '';
        $userKeyWord        = isset($_POST['k2']) ? $_POST['k2'] : '';        
        $display_results    = true;
        $search_state        = true;
        $is_adv             = true;        
        $start                = '1';
        $pageSize            = '20';   
        $the_data           = '';
        
        $args = array (
                    'collection'       => $collection,
                    'country'          => $country,
                    'subject'          => $subject,
                    'year'             => $year,
                    'userKeyWord'      => $userKeyWord,
                    'is_adv'           => $is_adv,
                    'start'            => $start,
                    'pageSize'         => $pageSize,                
                );
        
        if (isset($_POST)) {
            if ($_POST['adv'] == 1) {
                if ( ($_POST['country'] == NULL) && ($_POST['subject'] == NULL) && ($_POST['year'] == NULL) && ($_POST['k2'] == NULL) ) {
                    #redirect
                } else {
                    $the_data = $this->get_data($args);
                }
            } else {
                if (isset($_POST['k'])) {
                    if ($_POST['k'] == NULL) {
                        #redirect
                        var_dump('simple search');
                    } else {
                        $the_data = $this->get_data($args);
                    }                   
                }
            }
        } else {
            #redirect
        }

        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
                'title'              => $title,
                'api_key_images'     => $springerInfo['api_key_images'],
                'api_key_meta'       => $springerInfo['api_key_meta'],
                'api_key_openaccess' => $springerInfo['api_key_openaccess'],
                'display_results'    => $display_results,
                'the_data'           => $the_data,
                'is_trends'          => $is_trends 
        ))
        ->setTerminal(true);
        return $viewModel;        
    }
    
    public function trendsAction()
    {
        unset($_SESSION['current_header']); 
        $title          = "Trends";
        $is_trends      = true;
        $t_data         = $this->get_trends_for_search();
        $related_images = $this->display_related_images();
        $viewModel      = new ViewModel();
        $viewModel->setVariables(array(
                'title'      => $title,
                'is_trends'  => $is_trends,
                't_data'     => $t_data,
        ))
        ->setTerminal(true);
        return $viewModel;                
    }    
    
    private function getSpringerInfo()
    {
        $serviceLocator      = $this->getServiceLocator();
        $config              = $serviceLocator->get('config');
        $this->springerInfo  = $config['springer'];        
        return $this->springerInfo;
    }
    
    ##### HELPER FUNCTIONS
    private function get_data($DATA) {
        $springerInfo         = $this->getSpringerInfo();
        $api_key_images       = $springerInfo['api_key_images'];
        $api_key_meta         = $springerInfo['api_key_meta'];
        $collection           = $DATA['collection'];
        $country              = $DATA['country'];
        $subject              = $DATA['subject'];
        $year                 = $DATA['year'];
        $userKeyWord          = $DATA['userKeyWord'];
        $is_adv               = $DATA['is_adv'];
        $start                = $DATA['start'];
        $pageSize             = $DATA['pageSize'];
        $collection_title     = '';    
        $_SESSION['start']    = $start;
        $_SESSION['pageSize'] = $pageSize;
        $search_country = $search_subject = $search_year = $search_keyword = $data_url = '';
    
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
                if ($AND != false) {
                    $amp = "%20OR%20";
                }
                $search_subject = $amp . "subject:" . urlencode($subject);
                $AND = true;
            }
            if ($year != NULL) {
                if ($AND != false) {
                    $amp = "%20AND%20";
                }
                $search_year = $amp . "year:" . urlencode($year);
                $year_set = $year;
                $AND = true;
            }
            if ($userKeyWord != NULL) {
                if ($AND != false) {
                    $amp = "%20AND%20";
                }
                $search_keyword = $amp . "keyword:" . urlencode($userKeyWord);
            }
    
            $data_url    = 'http://api.springer.com/' . urlencode($collection_title) . '/json?q=' . $search_country . $search_subject . $search_year .  $search_keyword . '%20sort:date&s=' . $start . '&p=' . $pageSize . '&api_key=' . urlencode($key);
    
        } else {
            $search_keyword = "keyword:" . urlencode($userKeyWord);
            $data_url    = 'http://api.springer.com/' . urlencode($collection_title) . '/json?q=' . $search_keyword . '%20sort:date&s=' . $start . '&p=' . $pageSize . '&api_key=' . urlencode($key);
        }
    
        $data                 = file_get_contents($data_url);
        $_SESSION['data_url'] = $data_url;
        $output               = $this->load_json($data,$pageSize);
        return $output;
    }

    private function load_json($json,$pageSize) {    
        $result     = json_decode($json);
        $r          = array();
        $r          = $result->records;
        $total      = $result->result[0]->total;
        $output     = '';
        if ($r != NULL) {
            $output = "<h3>There are " .  number_format($total) . " total results.</h3> \n";
            $output .= "<ul data-role='listview' data-theme='a' data-divider-theme='a' data-filter='true' data-filter-placeholder='Search results...' data-inset='true'> \n";
            $output .= $this->build_list($r);
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
    
    private function build_list($r) {    
        $y_arr = array();    
        for ($i = 0; $i < count($r); $i++) {
            if ($r[$i]->title != NULL) {
                $n_year =  strtotime($r[$i]->publicationDate);
                array_push($y_arr, date("Y", $n_year));
            }
        }
    
        $year_arr        = array_unique($y_arr);
        $header_nonxist    = $_SESSION['current_header'];
    
        foreach ($year_arr as $y) {
    
            if ($header_nonxist != $y) {
                $output .= "<li data-role=\"list-divider\">" . $y . "</li>";
            }
            $_SESSION['current_header'] = $y;
    
            for ($i = 0; $i < count($r); $i++) {
                    
                $novel = new Novel();                    
                $novel->identifier            = htmlentities($r[$i]->identifier, ENT_IGNORE, 'utf-8');
                $novel->title                = htmlentities($r[$i]->title, ENT_IGNORE, 'utf-8');
                $novel->creators            = $r[$i]->creators;
                $novel->publicationName        = htmlentities($r[$i]->publicationName, ENT_IGNORE, 'utf-8');
                $novel->issn                = htmlentities($r[$i]->issn, ENT_IGNORE, 'utf-8');
                $novel->isbn                = htmlentities($r[$i]->isbn, ENT_IGNORE, 'utf-8');
                $novel->doi                    = htmlentities($r[$i]->doi, ENT_IGNORE, 'utf-8');
                $novel->publisher            = htmlentities($r[$i]->publisher, ENT_IGNORE, 'utf-8');
                $novel->publicationDate        = htmlentities($r[$i]->publicationDate, ENT_IGNORE, 'utf-8');
                $novel->vol                    = htmlentities($r[$i]->volume, ENT_IGNORE, 'utf-8');
                $novel->number                = htmlentities($r[$i]->number, ENT_IGNORE, 'utf-8');
                $novel->startingPage        = htmlentities($r[$i]->startingPage, ENT_IGNORE, 'utf-8');
                $novel->url                    = htmlentities($r[$i]->url, ENT_IGNORE, 'utf-8');
                $novel->copyright            = htmlentities($r[$i]->copyright, ENT_IGNORE, 'utf-8');
                    
                $n_time = strtotime($novel->publicationDate);
                $n_timeYear = date("Y",$n_time);
                    
                if ($n_timeYear == $y) {
                    $output .= $novel->novel_display();
                }
                    
            }
    
        }
    
        return $output;    
    }    
    
    private function get_trends_for_search() {    
        $data_url  = $_SESSION['data_url'];    
        $st1       = '&s=' . $_SESSION['start'] . '&';
        $st2       = '&s=1&';
        $st3       = '&p=' . $_SESSION['pageSize'];
        $n         = $_SESSION['start'] + $_SESSION['pageSize'];
        $st4       = '&p=' . $n;
        $a         = str_replace($st1,$st2,$data_url);
        $b         = str_replace($st3,$st4,$a);
        $data      = file_get_contents($b);
        $result    = json_decode($data);
        $r         = array();
        $r         = $result->records;    
        $month_arr = array();
    
        for ($i = 0; $i <= count($r); $i++) {
            $timestamp = strtotime($r[$i]->publicationDate);
            $month = date("m", $timestamp);    
            array_push($month_arr,$month);    
        }
    
        $arr    = array_count_values($month_arr);
        ksort($arr);
        $key   = array_keys($arr);
        $value = array_values($arr);
    
        for ($i = 0; $i < count($arr); $i++) {
            $k = date("F", mktime(0, 0, 0, $key[$i], 1));    
            $output .= ($i == 0) ? "{ month: \"" . $k . "\"," : ", { month: \"" . $k . "\","; 
            $output .= "issues: " . $value[$i] ."}";
    
        }
        return $output;    
    }
    
    private function display_related_images() {
        $springerInfo         = $this->getSpringerInfo();
        $api_key_images       = $springerInfo['api_key_images'];
        $api_key_meta         = $springerInfo['api_key_meta'];
    
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

    private function get_current_search() {
        $data_url = isset($_SESSION['data_url']) ? $_SESSION['data_url'] : '';
        return $data_url;
    }    
    
    private function get_klout($klout_api_key) {
        $data_url    = "http://api.klout.com/1/klout.json?users=SpringerSBM&key=" . $klout_api_key;
        $data        = file_get_contents($data_url);    
        $result      = json_decode($data);
        $r           = array();
        $r           = $result->users;    
        $output      = ceil($r[0]->kscore);    
        return $output;
    }    
        
}