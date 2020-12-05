<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Stores the email title');
            $table->string('recipients')->comment('Stores all the public recipients - to field');
            $table->text('body')->comment('Stores the message body');
            $table->string('content_type')->comment('Stores the dialect used to write body message: html,markdown,plaintext');
            $table->enum('status', ['queued', 'bounced','delivered'])->default('queued')->comment('Stores status processing: queued, bounced,
delivered...');
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
        Schema::dropIfExists('mails');
    }
}
