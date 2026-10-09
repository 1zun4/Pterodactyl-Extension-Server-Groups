<?php

declare(strict_types=1);

namespace ServerGroups;

use Illuminate\Console\Scheduling\Schedule;
use Pterodactyl\Extensions\ExtensionProvider;
use ServerGroups\Console\SyncCommand;

class ServerGroupsProvider extends ExtensionProvider
{
    public function boot(): void
    {
        $this->registerApiRoutes();
        $this->loadExtensionMigrations();

        $this->registerCommands([SyncCommand::class]);
        $this->registerSchedule(static function (Schedule $schedule): void {
            $schedule->command('server-groups:sync')->dailyAt('03:20')->withoutOverlapping()->runInBackground();
        });
    }
}
