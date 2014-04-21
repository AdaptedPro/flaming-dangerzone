<?php
namespace User\Controller;

use \PHPMailer;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use User\Model\User;
use User\Model\TempUser;
use User\Form\UserForm;
use User\Form\TempUserForm;
use User\Model\FacebookUser;
use User\Form\FacebookUserForm;

class UserController extends AbstractActionController
{
	protected $userTable;
	protected $tempUserTable;
	protected $facebookUserTable;
	
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
    	if (isset($_POST['go'])) {
    		$data = array(
    				'email' => isset($_POST['email'])?urldecode($_POST['email']):'',
    				'password'  => isset($_POST['password'])?urldecode($_POST['password']):'',
    		);    		
			$user = $this->getUserTable()->authenticateUser($data);
			if (!empty($user)) {				
				$_SESSION['auth_user']['id'] = isset($user->id)?$user->id:'';
				$_SESSION['auth_user']['email'] = isset($user->email)?$user->email:'';
				if(isset($_SESSION['login_message'])) {
					unset($_SESSION['login_message']);
				}
			} else {
				$message = 'Invalid email or password!';
				$_SESSION['login_message'] = $message;
			}
			return $this->redirect()->toRoute('home');
    	} else {
    		return $this->redirect()->toRoute('home');
    	}
    }
    
    public function signupAction()
    {	
    	$sign_up_form = new TempUserForm();
    	$sign_up_form->get('submit')->setValue('Sign Up');
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$temp_user = new TempUser();
    		$sign_up_form->setInputFilter($temp_user->getInputFilter());
    		$sign_up_form->setData($request->getPost());
    		 
    		if ($sign_up_form->isValid()) {
    			$temp_user->exchangeArray($sign_up_form->getData());
    			$this->getTempUserTable()->saveTempUser($temp_user);
//     			if ($this->send_signup_email()) {
//     				return $this->redirect()->toRoute('user', array(
//     						'action' => 'signupcomplete'
//     				));    				
//     			} else {
//    					var_dump('FAIL'); 				
//     			}

    			
    			$mail             = new PHPMailer(); // defaults to using php "mail()"
    			$mail->IsSendmail(); // telling the class to use SendMail transport
    			 
    			$body             = 'Hello World';//file_get_contents('Hello World');
    			#$body             = preg_replace("",'',$body);
    			 
    			$mail->SetFrom('noreply@adaptedpro.net', 'First Last');
    			 
    	#$mail->AddReplyTo("name@yourdomain.com","First Last");
    			 
    			$address = "adamjames_pro@yahoo.com";
    			$mail->AddAddress($address, "John Doe");
    			 
    			$mail->Subject    = "PHPMailer Test Subject via Sendmail, basic";
    	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    	$mail->MsgHTML($body);
    			 
    			#$mail->AddAttachment("images/phpmailer.gif");      // attachment
    			#$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    			 
    			if(!$mail->Send()) {
    				echo "Mailer Error: " . $mail->ErrorInfo;
    			} else {
    				echo "Message sent!";
    			}    			
    			
    		}
    	}
    	
    	return array('form' => $sign_up_form);    	  	
    }
    
    private function send_signup_email()
    {
    	$mail             = new PHPMailer(); // defaults to using php "mail()"
    	$mail->IsSendmail(); // telling the class to use SendMail transport
    	
    	$body             = 'Hello World';//file_get_contents('Hello World');
    	#$body             = preg_replace("",'',$body);
    	
    	#$mail->AddReplyTo("name@yourdomain.com","First Last");
    	
    	$mail->SetFrom('noreply@adaptedpro.net', 'First Last');
    	
    	#$mail->AddReplyTo("name@yourdomain.com","First Last");
    	
    	$address = "adamjames_pro@yahoo.com";
    	$mail->AddAddress($address, "John Doe");
    	
    	$mail->Subject    = "PHPMailer Test Subject via Sendmail, basic";
    	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    	$mail->MsgHTML($body);
    	
    	#$mail->AddAttachment("images/phpmailer.gif");      // attachment
    	#$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    	
    	if(!$mail->Send()) {
    		//echo "Mailer Error: " . $mail->ErrorInfo;
    		return false;
    	} else {
    		//echo "Message sent!";
    		return true;
    	}   	
    }
    
    public function signupcompleteAction()
    {
    	
    }
    
    public function facebookAction()
    {
    	
    	$result = new JsonModel(array(
	    	'some_parameter' => 'some value',
            'success'=>true,
        ));

        return $result;
    }
    
    private function add_facebook_user()
    {
    	$form = new FacebookUserForm();
    	$form->get('submit')->setValue('Add');
    	 
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$facebook_user = new FacebookUser();
    		$form->setInputFilter($facebook_user->getInputFilter());
    		$form->setData($request->getPost());
    		 
    		if ($form->isValid()) {
    			$facebook_user->exchangeArray($form->getData());
    			$this->getFacebookUserTable()->saveFacebookUser($facebook_user);
    			 
    			// Redirect to list of users
    			#return $this->redirect()->toRoute('user');
    			#create session and redirect to dashboard
    		}
    	}
    	return array('form' => $form);    	
    }

    public function signoutAction()
    {
    	unset($_SESSION['auth_user']);   
  		$view = new ViewModel();
   		$view->setTerminal(true);
   		return $this->redirect()->toRoute('home');	
    }   
    
    public function getUserTable()
    {
    	if (!$this->userTable) {
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('User\Model\UserTable');
    	}
    	return $this->userTable;
    }

    public function getTempUserTable()
    {
    	if (!$this->tempUserTable) {
    		$sm = $this->getServiceLocator();
    		$this->tempUserTable = $sm->get('User\Model\TempUserTable');
    	}
    	return $this->tempUserTable;
    }    
    
    public function getFacebookUserTable()
    {
    	if (!$this->facebookUserTable) {
    		$sm = $this->getServiceLocator();
    		$this->facebookUserTable = $sm->get('User\Model\FacebookUserTable');
    	}
    	return $this->userTable;
    }    
}