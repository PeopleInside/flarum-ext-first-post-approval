<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->create('user_first_post_approval', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->primary();
            $table->unsignedInteger('first_post_approval_count')->default(0);
            $table->unsignedInteger('first_discussion_approval_count')->default(0);
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        $connection = $schema->getConnection();
        
        if ($connection->getSchemaBuilder()->hasColumn('users', 'first_post_approval_count')) {
            $connection->statement('
                INSERT INTO user_first_post_approval (user_id, first_post_approval_count, first_discussion_approval_count)
                SELECT id, first_post_approval_count, first_discussion_approval_count
                FROM users
                WHERE first_post_approval_count > 0 OR first_discussion_approval_count > 0
            ');
            
            $schema->table('users', function (Blueprint $table) {
                $table->dropColumn([
                    'first_post_approval_count',
                    'first_discussion_approval_count'
                ]);
            });
        }
    },
    'down' => function (Builder $schema) {
        $schema->table('users', function (Blueprint $table) {
            $table->unsignedInteger('first_post_approval_count')->default(0);
            $table->unsignedInteger('first_discussion_approval_count')->default(0);
        });

        $connection = $schema->getConnection();
        $approvals = $connection->table('user_first_post_approval')->get();
        
        foreach ($approvals as $approval) {
            $connection->table('users')
                ->where('id', $approval->user_id)
                ->update([
                    'first_post_approval_count' => $approval->first_post_approval_count,
                    'first_discussion_approval_count' => $approval->first_discussion_approval_count,
                ]);
        }

        $schema->dropIfExists('user_first_post_approval');
    }
];
