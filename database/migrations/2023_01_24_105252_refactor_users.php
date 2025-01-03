<?php

use App\Definitions\Users\User\StateDefinition;
use App\Definitions\Users\User\SubscriptionTypeDefinition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('users', 'users_users');

        Schema::table('users_users', function (Blueprint $table) {
            $table->string('email_new')->nullable();
            $table->string('picture')->nullable();
            $table->string('phone')->nullable();
            $table->enum('state_id', StateDefinition::getValues())->default(StateDefinition::PENDING);
            $table->enum('subscription_type_id', SubscriptionTypeDefinition::getValues())->default(SubscriptionTypeDefinition::NONE);
            $table->date('subscription_till')->nullable();
            $table->text('description')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_index')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_email')->nullable();
            $table->unsignedBigInteger('company_country_id')->nullable();
            $table->timestamp('last_activity_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
