<?php
namespace Snscripts\ITCReporter\Responses;

use Psr\Http\Message\ResponseInterface;
use Snscripts\ITCReporter\Interfaces\ResponseProcessor;

class Error implements ResponseProcessor
{
    /**
     * @var Psr\Http\Message\ResponseInterface
     */
    private $Response;

    public function __construct(ResponseInterface $Response)
    {
        $this->Response = $Response;
    }

    public function process()
    {
        try {
            $XML = new \SimpleXMLElement(
                $this->Response->getBody()
            );


        } catch (\Exception $e) {
            return [];
        }

        return [
            'Code' => (int)$XML->Code,
            'Message' => (string)$XML->Message,
        ];
    }
}
