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
        Schema::table("members", function (Blueprint $table) {
            $table->string('phone')->after('date_admission_church');
            $table->string('UF')->after('date_admission_church');;
            $table->string('address')->after('date_admission_church');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table("members", function(Blueprint $table){
            $table->dropColumn("phone");
            $table->dropColumn("UF");
            $table->dropColumn("address");
        });
    }
};
