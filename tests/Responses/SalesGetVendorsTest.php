<?php
namespace Snscripts\ITCReporter\Tests\Responses;

use Snscripts\ITCReporter\Responses\SalesGetVendors;

class SalesGetVendorsTest extends \PHPUnit\Framework\TestCase
{
    public function testProcessReturnsCorrectValueForSingleSalesVendor()
    {
        $Response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')->getMock();
        $Response->method('getBody')
            ->willReturn('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Vendors><Vendor>1234567</Vendor></Vendors>');

        $Processor = new SalesGetVendors(
            $Response
        );

        $this->assertSame(
            [
                1234567
            ],
            $Processor->process()
        );
    }

    public function testProcessReturnsCorrectValueForMultipleSalesVendor()
    {
        $Response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')->getMock();
        $Response->method('getBody')
            ->willReturn('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Vendors><Vendor>1234567</Vendor><Vendor>9876543</Vendor></Vendors>');

        $Processor = new SalesGetVendors(
            $Response
        );

        $this->assertSame(
            [
                1234567,
                9876543
            ],
            $Processor->process()
        );
    }

    public function testProcessReturnsEmptyArrayForInvalidXML()
    {
        $Response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')->getMock();
        $Response->method('getBody')
            ->willReturn('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Vendors>1234567</Vendor><dor>9876543</Vendor></Vendors>');

        $Processor = new SalesGetVendors(
            $Response
        );

        $this->assertSame(
            [],
            $Processor->process()
        );
    }

    public function testProcessReturnsEmptyArrayForEmptyContents()
    {
        $Response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')->getMock();
        $Response->method('getBody')
            ->willReturn('');

        $Processor = new SalesGetVendors(
            $Response
        );

        $this->assertSame(
            [],
            $Processor->process()
        );
    }
}
