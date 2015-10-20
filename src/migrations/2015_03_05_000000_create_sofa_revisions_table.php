<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSofaRevisionsTable extends Migration
{
    /**
     * Revisions table.
     *
     * @var string
     */
    protected $table;

    public function __construct()
    {
        $this->table = Config::get('sofa_revisionable.table', 'revisions');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::drop($this->table);
        }

        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('action', 255);
            $table->string('table_name', 255);
            $table->integer('row_id')->unsigned();
            $table->text('old')->nullable();
            $table->text('new')->nullable();
            $table->string('user', 255)->nullable();
            $table->string('ip')->nullable();
            $table->string('ip_forwarded')->nullable();
            $table->timestamp('created_at');

            $table->index('action');
            $table->index(['table_name', 'row_id']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
