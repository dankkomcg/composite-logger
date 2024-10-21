# PHP Composite Logger

Composite Logger is an extension of the PHP Logger library that allows you to create compositions of loggers. This enables you to write logs to a file while simultaneously printing them to the console.

## Features

- **Composite Logging**: Combine multiple loggers to handle logging in different outputs.
- **Flexible Configuration**: Easily configure and extend logger combinations.

## Installation

Install the library via Composer:

```bash
composer require dankkomcg/composite-logger
```

Ensure you also have the base PHP Logger library installed:

```bash
composer require dankkomcg/php-logger
```

Include the autoloader in your PHP script:

```php
<?php
require_once dirname(__FILE__) . '/vendor/autoload.php';
```

## Usage

### Basic Example

Here's how you can set up a composite logger to log both to a file and the console:

```php
<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use Dankkomcg\Logger\Types\Console\LightColourConsoleLogger;
use Dankkomcg\Logger\Types\File\MonologFileLogger;
use Dankkomcg\CompositeLogger\CompositeLogger;

$consoleLogger = new LightColourConsoleLogger(['info' => 'blue']);
$fileLogger = new MonologFileLogger(dirname(__FILE__) . '/app.log', 'app');

$compositeLogger = new CompositeLogger([$consoleLogger, $fileLogger]);

$compositeLogger->info('This message will be logged to both the console and the file.');
```

### Configuration

- **Loggers Array**: Pass an array of loggers to `CompositeLogger` to enable multi-output logging.
- **Customization**: Each logger can be configured individually before being added to the composite.

## Logger Types

Composite Logger provides specific types of composite loggers, each designed for different logging strategies. These loggers extend `CompositeLogger` and require that all included loggers implement the `Logger` interface.

### Available Composite Loggers

- **SimpleCompositeLogger**: This logger allows you to combine multiple loggers in a straightforward manner. It logs messages to all included loggers, making it easy to manage logging across various outputs.

- **InverseCompositeLogger**: This logger provides an inverse logging mechanism, where it can be configured to exclude certain loggers based on specific conditions or configurations. It's useful for scenarios where you want to prevent logging in certain outputs under specific circumstances.

### Implementation Details

- **Extend `CompositeLogger`**: Both `SimpleCompositeLogger` and `InverseCompositeLogger` extend from `CompositeLogger`, ensuring they have the necessary functionality to handle multiple loggers.

- **Implement the `Logger` Interface**: All loggers used within these composites must implement the `Logger` interface, ensuring consistency and standard methods for logging operations.

These composite loggers offer flexible and powerful solutions for managing complex logging requirements in your applications.

## Testing

To run tests, use PHPUnit:

```bash
./vendor/bin/phpunit --testdox tests
```

## Requirements

- PHP 7.4 or later.
- PHP Logger library.

## License

This project is licensed under the MIT License. See the LICENSE file for details.