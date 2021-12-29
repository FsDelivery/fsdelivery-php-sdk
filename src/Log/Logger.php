<?php

namespace FsDeliverySdk\Log;

class Logger implements LoggerInterface
{
    private $filePath = '/tmp/debug.txt';

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Write log string to file
     *
     * @param string $level
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     */
    private function writeLog($level, $message, $context = []) {
        $log = "\n[".date('c').'] name.'.$level.': '.$message.' '.json_encode($context);
        file_put_contents($this->filePath, $log, FILE_APPEND);
    }

    /**
     * System is unusable.
     *
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function emergency($message, $context = []) {
        $this->writeLog('EMERGENCY', $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function alert($message, $context = []) {
        $this->writeLog('ALERT', $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function critical($message, $context = []) {
        $this->writeLog('CRITICAL', $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function error($message, $context = []) {
        $this->writeLog('ERROR', $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function warning($message, $context = []) {
        $this->writeLog('WARNING', $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function notice($message, $context = []) {
        $this->writeLog('NOTICE', $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function info($message, $context = []) {
        $this->writeLog('INFO', $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function debug($message, $context = []) {
        $this->writeLog('DEBUG', $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed   $level
     * @param string|\Stringable $message
     * @param mixed[] $context
     *
     * @return void
     * @throws \Exception
     */
    public function log($level, $message, $context = []) {
        throw new \Exception('Method not supported!');
    }
}