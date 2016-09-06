<?php

namespace LogjamDispatcher\Logjam;

class RequestId implements RequestIdInterface
{
    protected $id;

    /**
     * @param string $id
     */
    public function setId($id) 
    {
        $this->id = $id;
    }

    /**
     * Proxy getter to enable generated ids
     * @return string
     */
    public function getId() 
    {
        if($this->id === null) {
            $this->id = md5(uniqid(gethostname(), true));
        }
        
        return $this->id;
    }
}
