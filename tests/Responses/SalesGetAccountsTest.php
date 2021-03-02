<?php
namespace Snscripts\ITCReporter\Tests\Responses;

use Snscripts\ITCReporter\Responses\SalesGetAccounts;

class SalesGetAccountsTest extends \PHPUnit\Framework\TestCase
{
    public function testProcessReturnsCorrectValueForSingleSalesAccount()
    {
        $Response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')->getMock();
        $Response->method('getBody')
            ->willReturn('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Accounts><Account><Name>John Smith</Name><Number>1234567</Number></Account></Accounts>');

        $Processor = new SalesGetAccounts(
            $Response
        );


        $this->assertSame(
            [
                1234567 => [
                    'Name' => 'John Smith',
                    'Number' => 1234567
                ]
            ],
            $Processor->process()
        );
    }

    public function testProcessReturnsCorrectValueForMultipleSalesAccount()
    {
        $Response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')->getMock();
        $Response->method('getBody')
            ->willReturn('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Accounts><Account><Name>John Smith</Name><Number>1234567</Number></Account><Account><Name>Jane Doe</Name><Number>9876543</Number></Account></Accounts>');

        $Processor = new SalesGetAccounts(
            $Response
        );

        $this->assertSame(
            [
                1234567 => [
                    'Name' => 'John Smith',
                    'Number' => 1234567
                ],
                9876543 => [
                    'Name' => 'Jane Doe',
                    'Number' => 9876543
                ]
            ],
            $Processor->process()
        );
    }

    public function testProcessReturnsEmptyArrayForInvalidXML()
    {
        $Response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')->getMock();
        $Response->method('getBody')
            ->willReturn('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Accounts><Account><Name>John Smith 1234567</Number></Account><Account><Name>Jane Doe</Name><Number>9876543</Number></Accounts>');

        $Processor = new SalesGetAccounts(
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

        $Processor = new SalesGetAccounts(
            $Response
        );

        $this->assertSame(
            [],
            $Processor->process()
        );
    }
}
