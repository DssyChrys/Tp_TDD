<?php
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('ec_id');
            $table->decimal('controle_continu', 5, 2)->default(0);
            $table->decimal('controle_terminal', 5, 2)->default(0);
            $table->string('session')->default('normale'); // Session (normale ou rattrapage)
            $table->timestamp('date_evaluation')->default(DB::raw('CURRENT_TIMESTAMP')); // Date de l'évaluation

            // Définition des clés étrangères
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade');
            $table->foreign('ec_id')->references('id')->on('elements_constitutifs')->onDelete('cascade');
            
            $table->timestamps(); // Timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
