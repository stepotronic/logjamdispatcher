<?php

namespace LogjamDispatcher\Dispatcher;

use LogjamDispatcher\Message;

/**
 * Interface for logjam message dispatchers.
 */
interface DispatcherInterface
{
    /**
     * Dispatches the logjam message to the implemented channel.
     * @param Message $message
     */
    public function dispatch(Message $message);
}
