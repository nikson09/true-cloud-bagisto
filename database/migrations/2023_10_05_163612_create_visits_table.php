<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('visitor.table_name'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method')->nullable();
            $table->mediumText('request')->nullable();
            $table->mediumText('url')->nullable();
            $table->mediumText('referer')->nullable();
            $table->text('languages')->nullable();
            $table->text('useragent')->nullable();
            $table->text('headers')->nullable();
            $table->text('device')->nullable();
            $table->text('platform')->nullable();
            $table->text('browser')->nullable();
            $table->ipAddress('ip')->nullable();

            // вместо nullableMorphs('visitable')
            $table->string('visitable_type', 100)->nullable();
            $table->unsignedBigInteger('visitable_id')->nullable();
            $table->index(['visitable_type', 'visitable_id']);

            // вместо nullableMorphs('visitor')
            $table->string('visitor_type', 100)->nullable();
            $table->unsignedBigInteger('visitor_id')->nullable();
            $table->index(['visitor_type', 'visitor_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('visitor.table_name'));
    }
}
