<?php

namespace ProjectTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ProjectControllerTest extends AbstractHttpControllerTestCase
{
	protected $traceError = true;
	
    public function setUp()
    {
        $this->setApplicationConfig(
            include '/wamp/www/2014aj/config/application.config.php'
        );
        parent::setUp();
    }
    
    public function testIndexActionCanBeAccessed()
    {
    	$projectTableMock = $this->getMockBuilder('Project\Model\ProjectTable')
					    	->disableOriginalConstructor()
					    	->getMock();
    	
    	$projectTableMock->expects($this->once())
					    	->method('fetchAll')
					    	->will($this->returnValue(array()));
    	
    	$serviceManager = $this->getApplicationServiceLocator();
    	$serviceManager->setAllowOverride(true);
    	$serviceManager->setService('Project\Model\ProjectTable', $projectTableMock);    	
    	
    	$this->dispatch('/project');
    	$this->assertResponseStatusCode(200);
    
    	$this->assertModuleName('Project');
    	$this->assertControllerName('Project\Controller\Project');
    	$this->assertControllerClass('ProjectController');
    	$this->assertMatchedRouteName('project');
    }

    public function testAddActionRedirectsAfterValidPost()
    {
    	$projectTableMock = $this->getMockBuilder('Project\Model\ProjectTable')
					    	->disableOriginalConstructor()
					    	->getMock();
    
    	$projectTableMock->expects($this->once())
					    	->method('saveProject')
					    	->will($this->returnValue(null));
    
    	$serviceManager = $this->getApplicationServiceLocator();
    	$serviceManager->setAllowOverride(true);
    	$serviceManager->setService('Project\Model\ProjectTable', $projectTableMock);
    
    	$postData = array(
    			'id' => '',
    			'project_type'  => 'Installation',
    			'project_name' => 'The Painting',
    	);
    	$this->dispatch('/project/add', 'POST', $postData);
    	$this->assertResponseStatusCode(302);
    
    	$this->assertRedirectTo('/project');
    }    
}