<?php

namespace LogjamDispatcher\Logjam;

interface LineInterface
{
    public function getSeverity();
    
    public function getMessage();
    
    public function getMicroTimestamp();
}
