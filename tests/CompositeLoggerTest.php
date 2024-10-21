<?php

use Dankkomcg\Logger\Composite\Exceptions\InstanceOfLoggerException;
use Dankkomcg\Logger\Types\Console\ColourConsoleLogger;
use PHPUnit\Framework\TestCase;
use Dankkomcg\Logger\Types\MonologFileLogger;
use Dankkomcg\Logger\Composite\Types\SimpleCompositeLogger;

final class CompositeLoggerTest extends TestCase
{
    /**
     * @throws InstanceOfLoggerException
     */
    public function testCompositeLogging(): void
    {
        $consoleOutput = '';
        $filePath = dirname(__FILE__) . '/test.log';

        // Mock Console Logger
        $consoleLogger = $this->getMockBuilder(ColourConsoleLogger::class)
            ->setConstructorArgs([['info' => 'blue']])
            ->onlyMethods(['info'])
            ->getMock();

        $consoleLogger->method('info')
            ->willReturnCallback(function($message) use (&$consoleOutput) {
                $consoleOutput .= $message;
            });

        // File Logger
        $fileLogger = new MonologFileLogger($filePath, 'test');

        // Composite Logger
        $compositeLogger = new SimpleCompositeLogger([$consoleLogger, $fileLogger]);

        // Log a message
        $compositeLogger->info('Composite log message');

        // Verify console output
        $this->assertStringContainsString('Composite log message', $consoleOutput);

        // Verify file output
        $this->assertFileExists($filePath);
        $this->assertStringContainsString('Composite log message', file_get_contents($filePath));

        // Clean up
        unlink($filePath);
    }
}