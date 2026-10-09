<?php

declare(strict_types=1);

namespace ServerGroups\Console;

use Illuminate\Console\Command;
use ServerGroups\Synchronizer;

final class SyncCommand extends Command
{
    protected $signature = 'server-groups:sync';

    protected $description = 'Bring group members\' subuser access in line with their groups.';

    public function handle(Synchronizer $synchronizer): int
    {
        $this->info(json_encode($synchronizer->sync()));

        return self::SUCCESS;
    }
}
