<?php
namespace ProjectTest\Model;

use Project\Model\Project;
use PHPUnit_Framework_TestCase;

class ProjectTest extends PHPUnit_Framework_TestCase
{
    public function testProjectInitialState()
    {
        $project = new Project();

        $this->assertNull(
            $project->project_type,
            '"project_type" should initially be null'
        );
        $this->assertNull(
            $project->id,
            '"id" should initially be null'
        );
        $this->assertNull(
            $project->project_name,
            '"project_name" should initially be null'
        );
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $project = new Project();
        $data  = array('project_type' => 'some project_type',
                       'id'     => 123,
                       'project_name'  => 'some project_name');

        $project->exchangeArray($data);

        $this->assertSame(
            $data['project_type'],
            $project->project_type,
            '"project_type" was not set correctly'
        );
        $this->assertSame(
            $data['id'],
            $project->id,
            '"id" was not set correctly'
        );
        $this->assertSame(
            $data['project_name'],
            $project->project_name,
            '"project_name" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $project = new Project();

        $project->exchangeArray(array('project_type' => 'some project_type',
                                    'id'     => 123,
                                    'project_name'  => 'some project_name'));
        $project->exchangeArray(array());

        $this->assertNull(
            $project->project_type, '"project_type" should have defaulted to null'
        );
        $this->assertNull(
            $project->id, '"id" should have defaulted to null'
        );
        $this->assertNull(
            $project->project_name, '"project_name" should have defaulted to null'
        );
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $project = new Project();
        $data  = array('project_type' => 'some project_type',
                       'id'     => 123,
                       'project_name'  => 'some project_name');

        $project->exchangeArray($data);
        $copyArray = $project->getArrayCopy();

        $this->assertSame(
            $data['project_type'],
            $copyArray['project_type'],
            '"project_type" was not set correctly'
        );
        $this->assertSame(
            $data['id'],
            $copyArray['id'],
            '"id" was not set correctly'
        );
        $this->assertSame(
            $data['project_name'],
            $copyArray['project_name'],
            '"project_name" was not set correctly'
        );
    }

    public function testInputFiltersAreSetCorrectly()
    {
        $project = new Project();

        $inputFilter = $project->getInputFilter();

        $this->assertSame(3, $inputFilter->count());
        $this->assertTrue($inputFilter->has('project_type'));
        $this->assertTrue($inputFilter->has('id'));
        $this->assertTrue($inputFilter->has('project_name'));
    }
}