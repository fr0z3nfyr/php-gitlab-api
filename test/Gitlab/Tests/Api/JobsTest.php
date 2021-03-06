<?php namespace Gitlab\Tests\Api;

use Gitlab\Api\Jobs;
use GuzzleHttp\Psr7\Response;

class JobsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllJobs()
    {
        $expectedArray = array(
            array('id' => 1, 'name' => 'A job'),
            array('id' => 2, 'name' => 'Another job'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('projects/1/jobs', array(
                'scope' => ['pending']
            ))
            ->will($this->returnValue($expectedArray))
        ;

        $this->assertEquals($expectedArray, $api->all(1, [Jobs::SCOPE_PENDING]));
    }

    /**
     * @test
     */
    public function shouldGetPipelineJobs()
    {
        $expectedArray = array(
            array('id' => 1, 'name' => 'A job'),
            array('id' => 2, 'name' => 'Another job'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('projects/1/pipelines/2/jobs', array(
                'scope' => ['pending']
            ))
            ->will($this->returnValue($expectedArray))
        ;

        $this->assertEquals($expectedArray, $api->pipelineJobs(1, 2, [Jobs::SCOPE_PENDING]));
    }

    /**
     * @test
     */
    public function shouldGetJob()
    {
        $expectedArray = array('id' => 3, 'name' => 'A job');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('projects/1/jobs/3')
            ->will($this->returnValue($expectedArray))
        ;

        $this->assertEquals($expectedArray, $api->show(1, 3));
    }

    /**
     * @test
     */
    public function shouldGetArtifacts()
    {
        $returnedStream = new Response(200, [], 'foobar');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('getAsResponse')
            ->with('projects/1/jobs/3/artifacts')
            ->will($this->returnValue($returnedStream))
        ;

        $this->assertEquals('foobar', $api->artifacts(1, 3)->getContents());
    }

    /**
     * @test
     */
    public function shouldGetArtifactsByRefName()
    {
        $returnedStream = new Response(200, [], 'foobar');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('getAsResponse')
            ->with('projects/1/jobs/artifacts/master/download', array(
                'job' => 'job_name'
            ))
            ->will($this->returnValue($returnedStream))
        ;

        $this->assertEquals('foobar', $api->artifactsByRefName(1, 'master', 'job_name')->getContents());
    }

    /**
     * @test
     */
    public function shouldGetTrace()
    {
        $expectedString = "some trace";

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('projects/1/jobs/3/trace')
            ->will($this->returnValue($expectedString))
        ;

        $this->assertEquals($expectedString, $api->trace(1, 3));
    }

    /**
     * @test
     */
    public function shouldCancel()
    {
        $expectedArray = array('id' => 3, 'name' => 'A job');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('projects/1/jobs/3/cancel')
            ->will($this->returnValue($expectedArray))
        ;

        $this->assertEquals($expectedArray, $api->cancel(1, 3));
    }

    /**
     * @test
     */
    public function shouldRetry()
    {
        $expectedArray = array('id' => 3, 'name' => 'A job');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('projects/1/jobs/3/retry')
            ->will($this->returnValue($expectedArray))
        ;

        $this->assertEquals($expectedArray, $api->retry(1, 3));
    }

    /**
     * @test
     */
    public function shouldErase()
    {
        $expectedArray = array('id' => 3, 'name' => 'A job');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('projects/1/jobs/3/erase')
            ->will($this->returnValue($expectedArray))
        ;

        $this->assertEquals($expectedArray, $api->erase(1, 3));
    }

    /**
     * @test
     */
    public function shouldKeepArtifacts()
    {
        $expectedArray = array('id' => 3, 'name' => 'A job');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('projects/1/jobs/3/artifacts/keep')
            ->will($this->returnValue($expectedArray))
        ;

        $this->assertEquals($expectedArray, $api->keepArtifacts(1, 3));
    }

    /**
     * @test
     */
    public function shouldPlay()
    {
        $expectedArray = array('id' => 3, 'name' => 'A job');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('projects/1/jobs/3/play')
            ->will($this->returnValue($expectedArray))
        ;

        $this->assertEquals($expectedArray, $api->play(1, 3));
    }

    protected function getApiClass()
    {
        return 'Gitlab\Api\Jobs';
    }
}
