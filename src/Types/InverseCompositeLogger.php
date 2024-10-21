<?php

namespace Dankkomcg\Logger\Composite\Types;

use Dankkomcg\Logger\Composite\CompositeLogger;
use Dankkomcg\Logger\Logger;
use Dankkomcg\Logger\Traits\Writable;

class InverseCompositeLogger extends CompositeLogger {

    use Writable;

    /**
     * @param Logger $logger
     * @return void
     */
    public function addLogger(Logger $logger): void {
        $this->insertAtBeginning($logger);
    }

    /**
     * Add the logger on top to composition default order
     *
     * @param Logger $logger
     * @return void
     */
    private function insertAtBeginning(Logger $logger): void {

        $this->loggers = array_splice(
            $this->loggers, 0, 0, $logger
        );

    }

    protected function write(string $message, string $level): void
    {
        foreach ($this->loggers as $logger) {
            $logger->write($message, $level);
        }
    }

}