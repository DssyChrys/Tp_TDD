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
    $table->foreignId('etudiant_id')->constrained()->onDelete('cascade');
    $table->unsignedBigInteger('ec_id')->constrained()->onDelete('cascade');
    $table->decimal('note', 5, 2);
    $table->enum('session', ['normale', 'rattrapage']);
    $table->date('date_evaluation')->default(now());
    
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
        Schema::dropIfExists('notes');
    }
}
