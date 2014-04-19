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

    	*/
    	
    	return new ViewModel(array(
    			'var_x' => 'test',
    	));    	
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
}