<?php

namespace Dankkomcg\Logger\Composite;

use Dankkomcg\Logger\Composite\Exceptions\InstanceOfLoggerException;
use Dankkomcg\Logger\Logger;

abstract class CompositeLogger implements Logger {

    /**
     * @var array
     */
    protected array $loggers;

    /**
     * @throws InstanceOfLoggerException
     */
    public function __construct(array $loggers) {
        $this->checkIfIsInstanceOfLogger($loggers);
    }

    /**
     * @param array $loggers
     * @return void
     * @throws InstanceOfLoggerException
     */
    private function checkIfIsInstanceOfLogger(array $loggers): void
    {
        foreach ($loggers as $logger) {

            if (!($logger instanceof Logger)) {
                throw new InstanceOfLoggerException(
                    sprintf(
                        'Logger object must implement %s interface', get_class($logger)
                    )
                );
            }

            $this->loggers[] = $logger;
        }
    }

    /**
     * @param Logger $logger
     * @return void
     */
    public abstract function addLogger(Logger $logger): void;

    public function write(string $message, string $level): void
    {
        $this->emitMessageToLoggers($message, $level);
    }

    /**
     * @param string $message
     * @param string $level
     * @return void
     */
    private function emitMessageToLoggers(string $message, string $level): void
    {
        /** @var Logger $logger */
        foreach ($this->loggers as $logger) {
            $logger->$level($message, $level);
        }
    }

}