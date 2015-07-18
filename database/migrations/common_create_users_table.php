<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommonCreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users')) {
            Schema::create('users', function(Blueprint $table){
                $this->ifNoUsersTable($table);
            });
        }
        else {
            Schema::table('users', function(Blueprint $table){
                $this->ifUsersTableExists($table);
            });
        }
    }

    protected function ifUsersTableExists(Blueprint $table)
    {
        if(Schema::hasColumn('users', 'name')) {
            $table->dropColumn('name');
        }
        $table->string('last_name')->after('id');
        $table->string('first_name')->after('id');
        $table->string('avatar')->after('email');
        $table->string('provider')->after('email');
        $table->string('provider_id')->unique()->after('email');
        $table->longText('provider_token')->after('email');
        $table->string('link')->after('password');
        $table->string('gender')->nullable()->after('password');
        $table->boolean('verified')->default(false)->after('password');
    }

    private function ifNoUsersTable(Blueprint $table)
    {
        $table->increments('id');
        $table->string('first_name');
        $table->string('last_name');
        $table->string('email')->unique();
        $table->string('avatar');
        $table->string('provider');
        $table->string('provider_id')->unique();
        $table->longText('provider_token');
        $table->string('password', 60)->nullable();
        $table->boolean('verified')->default(false);
        $table->string('gender')->nullable();
        $table->string('link');
        $table->rememberToken();
        $table->timestamps();
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
