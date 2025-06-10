<?php

namespace App\Message;

class AbstractSupportRequestMessage
{
    public function __construct(public string $requestId)
    {
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
