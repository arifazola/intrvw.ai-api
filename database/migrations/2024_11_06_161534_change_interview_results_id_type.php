<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('interview_results', function (Blueprint $table) {
            // $table->integer('votes')->unsigned()->default(1)->comment('my comment')->change();
            // $table->dropPrimary('interview_results_id_primary');
            // $table->dropColumn('id');
            $table->string('id', 50)->primary();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
