<?php


namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class TagException extends HttpException
{
    public function __construct(int $statusCode, string $message = null, \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    public function getStatusCode()
    {
        return parent::getStatusCode(); // TODO: Change the autogenerated stub
    }

    public function getHeaders()
    {
        return parent::getHeaders(); // TODO: Change the autogenerated stub
    }

    public function setHeaders(array $headers)
    {
        parent::setHeaders($headers); // TODO: Change the autogenerated stub
    }


}