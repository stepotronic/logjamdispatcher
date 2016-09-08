<?php

namespace LogjamDispatcher\Dispatcher;

use LogjamDispatcher\Logjam\MessageInterface;

/**
 * Interface for logjam message dispatchers.
 */
interface DispatcherInterface
{
    /**
     * Dispatches the logjam message to the implemented channel.
     * @param MessageInterface $message
     * 
     * @return boolean
     */
    public function dispatch(MessageInterface $message);

    /**
     * Check if any Exceptions happened during the dispatching
     * 
     * @return bool
     */
    public function hasExceptions();

    /**
     * Get all Exceptions that happened during the dispatching
     * 
     * @return \Exception[]
     */
    public function getExceptions();
}
