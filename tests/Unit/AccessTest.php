<?php

declare(strict_types=1);

namespace ServerGroups\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ServerGroups\Support\Access;

final class AccessTest extends TestCase
{
    public function test_merges_permissions_across_groups_and_skips_owners(): void
    {
        $desired = Access::desired([
            ['servers' => [1, 2], 'members' => [['user' => 10, 'permissions' => ['control.start', 'websocket.connect']], ['user' => 20, 'permissions' => ['file.read']]]],
            ['servers' => [2], 'members' => [['user' => 10, 'permissions' => ['file.read', 'control.start']]]],
        ], [1 => 20]);

        $this->assertSame([
            '1:10' => ['control.start', 'websocket.connect'],
            '2:10' => ['control.start', 'file.read', 'websocket.connect'],
            '2:20' => ['file.read'],
        ], $desired);
    }

    public function test_empty_groups_grant_nothing(): void
    {
        $this->assertSame([], Access::desired([['servers' => [1], 'members' => []], ['servers' => [], 'members' => [['user' => 1, 'permissions' => ['x']]]]], []));
    }
}
