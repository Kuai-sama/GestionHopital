<?php

namespace App\Service;


class CodeReminder
{

    private string $logger = "";

    public function __construct(string $logger)
    {
        $this->logger = $logger;
    }

    public function getCode(): string
    {
        return $logger;
    }
    public function setCode(string $entre): void
    {
        if($entre == null || $entre == "")
        {
            $this->logger = "";
        }
        else
        {
            $this->logger = $entre;
        }
        
    }
}