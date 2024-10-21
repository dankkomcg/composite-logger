<?php

namespace Dankkomcg\Logger\Composite\Types;

use Dankkomcg\Logger\Composite\CompositeLogger;
use Dankkomcg\Logger\Logger;
use Dankkomcg\Logger\Traits\Writable;

class SimpleCompositeLogger extends CompositeLogger {

    use Writable;

    /**
     * @param Logger $logger
     * @return void
     */
    public function addLogger(Logger $logger): void {
        $this->loggers[] = $logger;
    }

    protected function write(string $message, string $level): void {
        foreach ($this->loggers as $logger) {
            $logger->$level($message);
        }
    }

}