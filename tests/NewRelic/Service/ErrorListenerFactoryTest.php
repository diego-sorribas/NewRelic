<?php
namespace NewRelic\Service;

class ErrorListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ErrorListenerFactory
     */
    protected $errorListenerFactory;

    public function setUp()
    {
        $this->errorListenerFactory = new ErrorListenerFactory();
    }

    public function testCreateService()
    {
        $logger = $this->getMock('Zend\Log\Logger');

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($logger));

        $listener = $this->errorListenerFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Listener\ErrorListener', $listener);
    }
}