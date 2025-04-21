<?php

declare(strict_types=1);

namespace App\Error;

use Cake\Core\Configure;
use Cake\Core\Exception\CakeException;
use Cake\Error\Debugger;
use Cake\Error\ErrorLogger;
use Throwable;

class AppErrorLogger extends ErrorLogger
{
    /**
     * Generate the message for the exception
     *
     * @param \Throwable $exception The exception to log a message for.
     * @param bool $isPrevious False for original exception, true for previous
     * @param bool $includeTrace Whether or not to include a stack trace.
     * @return string Error message
     */
    protected function getMessage(Throwable $exception, bool $isPrevious = false, bool $includeTrace = false): string
    {
        $message = sprintf(
            '%s[%s] %s in %s on line %s',
            $isPrevious ? "\nCaused by: " : '',
            $exception::class,
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
        );
        $debug = Configure::read('debug');

        if ($debug && $exception instanceof CakeException) {
            $attributes = $exception->getAttributes();
            if ($attributes) {
                $message .= "\nException Attributes: " . var_export($exception->getAttributes(), true);
            }
        }

        if ($includeTrace) {
            $trace = Debugger::formatTrace($exception, ['format' => Configure::read('Error.traceFormat', 'array')]);
            assert(is_array($trace));
            $message .= "\nStack Trace:\n";
            foreach ($trace as $line) {
                if (is_string($line)) {
                    $message .= '- ' . $line;
                } else {
                    $message .= "- {$line['file']}:{$line['line']}\n";
                }
            }
        }

        $previous = $exception->getPrevious();
        if ($previous) {
            $message .= $this->getMessage($previous, true, $includeTrace);
        }

        return $message;
    }
}
