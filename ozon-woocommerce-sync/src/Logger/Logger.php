<?php
namespace OzonSync\Logger;

class Logger
{
    private string $dir;

    public function __construct()
    {
        $basedir = function_exists('wp_upload_dir') ? wp_upload_dir()['basedir'] : sys_get_temp_dir();
        $this->dir = rtrim($basedir, '/\\') . '/ozon-sync/logs/';
        if (!is_dir($this->dir) && function_exists('wp_mkdir_p')) {
            wp_mkdir_p($this->dir);
        } elseif (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }
    }

    private function write(string $level, string $message): void
    {
        $file = $this->dir . date('Y-m-d') . '.log';
        $line = sprintf("[%s] %s: %s\n", date('H:i:s'), strtoupper($level), $message);
        file_put_contents($file, $line, FILE_APPEND);
    }

    public function info(string $msg): void { $this->write('info', $msg); }
    public function error(string $msg): void { $this->write('error', $msg); }
    public function debug(string $msg): void { $this->write('debug', $msg); }
}
