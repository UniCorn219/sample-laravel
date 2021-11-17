<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->primary('id');
            $table->unsignedInteger('id');
            $table->string('uniqid');
            $table->string('id_flex')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->smallInteger('role_admin');
            $table->string('name');
            $table->string('phone');
            $table->string('avatar')->nullable();
            $table->integer('introduced_by')->nullable();
            $table->integer('number_referral')->nullable();
            $table->integer('battery_point');
            $table->integer('battery_level');
            $table->integer('total_point');
            $table->boolean('has_left')->default(false);
            $table->text('reason_has_left')->nullable();
            $table->string('referral_link');
            $table->softDeletes();
            $table->date('birth')->nullable();
            $table->string('gender', 2)->nullable();
            $table->string('point_reason', 255)->nullable();
            $table->string('wm', 255)->nullable();
            $table->string('refer', 10)->nullable();
            $table->string('refer_user', 10)->nullable();
            $table->string('code', 10);
            $table->tinyInteger('cnt_refer')->default(0);
            $table->tinyInteger('cnt_open')->default(0);
            $table->tinyInteger('is_allow')->default(1);
            $table->tinyInteger('allow_push')->default(1);
            $table->tinyInteger('is_block')->default(0);
            $table->dateTime('allow_dt')->nullable();
            $table->dateTime('insert_dt')->nullable();
            $table->dateTime('update_dt')->nullable();
            $table->dateTime('quited_at')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('firebase_uid')->nullable();
            $table->string('token_fcm')->nullable();
            $table->string('nickname')->nullable()->unique();
            $table->integer('region_id')->nullable();
            $table->string('region_name')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('branch_name')->nullable();
            $table->dateTime('last_visited_at')->nullable();
            $table->integer('number_of_time_block_chatting')->default(0);
            $table->date('block_chatting_expired')->nullable();
            $table->integer('total_follow')->default(0);
            $table->string('reason_quit')->nullable();
            $table->string('link_share')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
