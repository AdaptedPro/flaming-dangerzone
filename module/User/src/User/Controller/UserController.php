<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Model\User;
use User\Form\UserForm;

class UserController extends AbstractActionController
{
	protected $userTable;
	
    public function indexAction()
    {
         return new ViewModel(array(
             'users' => $this->getUserTable()->fetchAll(),
         ));
    }

    public function addAction()
    {
    	$form = new UserForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$user = new User();
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$user->exchangeArray($form->getData());
    			$this->getUserTable()->saveUser($user);
    	
    			// Redirect to list of users
    			return $this->redirect()->toRoute('user');
    		}
    	}
    	return array('form' => $form);    	
    }

    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('user', array(
    				'action' => 'add'
    		));
    	}
    	
    	// Get the User with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
    	try {
    		$user = $this->getUserTable()->getUser($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('user', array(
    				'action' => 'index'
    		));
    	}
    	
    	$form  = new UserForm();
    	$form->bind($user);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$this->getUserTable()->saveUser($user);
    	
    			// Redirect to list of users
    			return $this->redirect()->toRoute('user');
    		}
    	}
    	
    	return array(
    			'id' => $id,
    			'form' => $form,
    	);    	
    }

    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('user');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getUserTable()->deleteUser($id);
    		}
    	
    		// Redirect to list of users
    		return $this->redirect()->toRoute('user');
    	}
    	
    	return array(
    			'id'    => $id,
    			'user' => $this->getUserTable()->getUser($id)
    	);    	
    }
    
    public function signinAction()
    {
    	$form       = new \User\Form\UserForm();
    	$request    = $this->getRequest();
    	$response   = $this->getResponse();    	
    	
    	if ($request->isPost()) {
    		$hello = 1;
    		$form->setData($request->getPost());
    		if ($form->isValid()){
    			$hello = 4020;
    			
    		} else {
			    $messages = $form->getMessages();
			}
    	}
	
    	$arr= array();
    	$arr['user_email']='adam.james@adaptedpro.net';
    	$arr['user_password']='password';
    	$user = $this->getUserTable()->getAuthUser($arr);  	
    	
var_dump($user);
    	/*
    	$messages = array();
    	if (!empty($messages)){
    		$response->setContent(\Zend\Json\Json::encode($messages));
    	} else {
    		$response->setContent(\Zend\Json\Json::encode(array('success'=>1,'hello'=>'Test')));
    	}
    	*/
    	return $response;    	
    	
    }
    
    public function signupAction()
    {
    	if (isset($_POST)) {
    		$temp_email = isset($_POST['email'])?$_POST['email']:'';
    		$temp_password1 = isset($_POST['password1'])?$_POST['password1']:'';
    		$temp_password2 = isset($_POST['password2'])?$_POST['password2']:'';
    		$temp_ip_address = $_SERVER['REMOTE_ADDR'];
    	}
    	 
    	
    	require_once('class.phpmailer.php');
    	//require_once('../class.phpmailer.php');
//include '/wamp/www/2014aj/config/application.config.php'

    	/*
    	$mail             = new PHPMailer(); // defaults to using php "mail()"
    	 
    	$mail->IsSendmail(); // telling the class to use SendMail transport
    	 
    	$body             = file_get_contents('contents.html');
    	$body             = eregi_replace("[\]",'',$body);
    	 
    	$mail->AddReplyTo("name@yourdomain.com","First Last");
    	 
    	$mail->SetFrom('name@yourdomain.com', 'First Last');
    	 
    	$mail->AddReplyTo("name@yourdomain.com","First Last");
    	 
    	$address = "whoto@otherdomain.com";
    	$mail->AddAddress($address, "John Doe");
    	 
    	$mail->Subject    = "PHPMailer Test Subject via Sendmail, basic";
    	 
    	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    	 
    	$mail->MsgHTML($body);
    	 
    	$mail->AddAttachment("images/phpmailer.gif");      // attachment
    	$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    	 
    	if(!$mail->Send()) {
    		echo "Mailer Error: " . $mail->ErrorInfo;
    	} else {
    		echo "Message sent!";
    	}

    	*/
    	
    	return new ViewModel(array(
    			'var_x' => 'test',
    	));    	
    }
    
    public function getUserTable()
    {
    	if (!$this->userTable) {
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('User\Model\UserTable');
    	}
    	return $this->userTable;
    }    
}