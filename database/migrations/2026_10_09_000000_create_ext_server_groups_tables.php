<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ext_server_groups_groups', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name', 191);
            $table->char('color', 7)->default('#3b82f6');
            $table->timestamps();
        });

        Schema::create('ext_server_groups_servers', function (Blueprint $table): void {
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('server_id');

            $table->primary(['group_id', 'server_id']);
            $table->foreign('group_id')->references('id')->on('ext_server_groups_groups')->cascadeOnDelete();
            $table->foreign('server_id')->references('id')->on('servers')->cascadeOnDelete();
        });

        Schema::create('ext_server_groups_members', function (Blueprint $table): void {
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('user_id');
            $table->json('permissions');

            $table->primary(['group_id', 'user_id']);
            $table->foreign('group_id')->references('id')->on('ext_server_groups_groups')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // Subusers this extension created, so it never touches subusers someone added by hand.
        Schema::create('ext_server_groups_grants', function (Blueprint $table): void {
            $table->unsignedInteger('server_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('subuser_id');
            $table->json('permissions');
            $table->timestamps();

            $table->primary(['server_id', 'user_id']);
            $table->foreign('server_id')->references('id')->on('servers')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ext_server_groups_grants');
        Schema::dropIfExists('ext_server_groups_members');
        Schema::dropIfExists('ext_server_groups_servers');
        Schema::dropIfExists('ext_server_groups_groups');
    }
};
