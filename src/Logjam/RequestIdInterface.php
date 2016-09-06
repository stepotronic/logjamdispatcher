<?php
namespace LogjamDispatcher\Logjam;

interface RequestIdInterface
{
    /**
     * logjam expects a 32 character string
     * @return string
     */
    public function getId();
}
