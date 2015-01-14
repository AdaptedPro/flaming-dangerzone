<?php
namespace Rover\Controller;

use \PHPMailer;
use \Ssh2_crontab_manager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Rover\Model\Rover;

class RoverController extends AbstractActionController
{
	
    public function indexAction()
    {
       return new ViewModel(array(
             'python_network_data' => $this->get_python_network_data(),
       		'python_scrape_data' => $this->get_scrape_data()
         ));
    }
    
    public function ajaxAction()
    {
    		$result = new JsonModel(array(
    				'some_parameter' => 'some value',
    				'success'=>true,
    		));
    		return $result;   
    }    
    
    private function get_python_network_data()
    {
    	#Remember to use chmod +x myscript.py
    	$output = "";
    	//ob_start();
    	//$command = escapeshellcmd("/Applications/MAMP/htdocs/flaming-dangerzone/module/Rover/view/rover/rover/network_info.py");
    	//$output = shell_exec($command);
    	//ob_end_clean();
    	return $output;    	
    }
    
    private function get_scrape_data()
    {
    	#ob_start();
    	#$command = escapeshellcmd("/wamp/flaming-dangerzone/module/Rover/view/rover/rover/scraper.py");
    	#$output = shell_exec($command); 
    	#ob_end_clean();
    	#return $output;    	   	
    }
    
    
    private function cronTest()
    {
    	//$crontab = new Ssh2_crontab_manager(address, port, username, password );
    	#$crontab = new Ssh2_crontab_manager('localhost','','','');
    	#$crontab->append_cronjob('30 15 * * 1 home/path/to/command/the_command.sh >/dev/null 2>&1');
    }
    
    /*
     * MAKE AJAX FUNCTIONS RETURN AS JSON OR XML!
     */
    public function aliveAction()
    {	
    	if (isset($_SESSION['auth_user'])) {
    		
    		#Get all Updates
    		//Check relational database
    		//SELECT MAX(UTATIS.ACTIVITY_LOG.UPDATED_ON) 
    		//FROM UTATIS.ACTIVITY_LOG
    		//WHERE PUBLIC = TRUE;
    		
    		//https://adaptedpro.iriscouch.com/loby/_design/catalog/_view/items
    		
//     		$ch = curl_init("https://adaptedpro.iriscouch.com/loby/_design/catalog/_view/items");
//     		$fp = fopen("example_homepage.txt", "w");
    		
//     		curl_setopt($ch, CURLOPT_FILE, $fp);
//     		curl_setopt($ch, CURLOPT_HEADER, 0);
    		
//     		curl_exec($ch);
//     		curl_close($ch);
//     		fclose($fp);   


    		$result = new JsonModel(array(
    				'some_parameter' => 'some value',
    				'success'=>true,
    		));
    		return $result;    		
    	}
    }
    
    public function reportAction() {
    	$result = new JsonModel(array(
    			'success' => $this->sendMail(),
    	)); 
    	return $result;   	
    }
    
    private function sendMail()
    {
    	$mail = new PHPMailer();
    	$mail->IsSendmail();
    	$mail->IsSMTP();
    	$mail->SMTPDebug = 2;
    	$mail->Debugoutput = 'html';
    	$mail->Host = 'mail.adaptedpro.net';
    	$mail->Port = 587;
    	$mail->SMTPAuth = true;
    	$mail->Username = "noreply@adaptedpro.net";
    	$mail->Password = "H5qdd*dD68";
    	
    	$body = "
    	<html>
    	<body>
    	<h1>Hello World!</h1>
    	<p>The cron job is working</p>
    	</body>
    	</html>";
    	
    	$mail->SetFrom('noreply@adaptedpro.net', '');
    	$address = 'adamjames_pro@yahoo.com';
    			 
    	$mail->AddAddress($address, " Hey You");
    	$mail->Subject    = "Cron Job";
    	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    	$mail->MsgHTML($body);
    	
    	if(!$mail->Send()) {
    	    //echo "Mailer Error: " . $mail->ErrorInfo;
    	    return false;
    	} else {
    		//echo "Message sent!";
    		return true;
    	}    	
    }

    private function regex_filter($string)
    {
    	$output="";    
    	#mixed preg_replace ( mixed $pattern , mixed $replacement , mixed $subject [, int $limit = -1 [, int &$count ]] )
    	$pattern = '/(\w+) (\d+), (\d+)/i';
    	$replacement = '${1}1,$3';
    	$output = preg_replace($pattern, $replacement, $string);
    	//echo regex_filter('April 15, 2003');
    	//echo regex_filter("#request_data['catalog_description']");    
    	return $output;
    }
 
}