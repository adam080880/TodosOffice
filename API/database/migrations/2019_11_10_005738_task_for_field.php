<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaskForField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_fors', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreign('task_id')->references('id')->on('tasks')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            DB::statement('ALTER TABLE `TodosOffice`.`task_fors` ADD UNIQUE `same_` (`user_id`, `task_id`) USING BTREE;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_fors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['task_id']);            
        });
    }
}
