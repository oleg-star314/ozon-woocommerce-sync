<?php
namespace OzonSync\Cron;

use OzonSync\Services\SyncRunner;

class Scheduler
{
    public const HOOK = 'ozon_sync_cron';

    public static function init(): void
    {
        if (function_exists('add_action')) {
            add_action(self::HOOK, [self::class, 'run']);
        }
    }

    public static function activate(): void
    {
        if (function_exists('wp_next_scheduled') && function_exists('wp_schedule_event')) {
            if (!wp_next_scheduled(self::HOOK)) {
                wp_schedule_event(time(), 'hourly', self::HOOK);
            }
        }
    }

    public static function deactivate(): void
    {
        if (function_exists('wp_next_scheduled') && function_exists('wp_unschedule_event')) {
            $timestamp = wp_next_scheduled(self::HOOK);
            if ($timestamp) {
                wp_unschedule_event($timestamp, self::HOOK);
            }
        }
    }

    public static function run(): void
    {
        $runner = new SyncRunner();
        $runner->runDelta();
    }
}
