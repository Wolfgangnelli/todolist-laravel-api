<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //timestamps()--> crea timestamp con update e create
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('todo');
            $table->boolean('completed');
            $table->unsignedBigInteger('list_id');
            $table->softDeletes();
            $table->foreign('list_id')
            ->on('todo_lists')
            ->references('id')
            ->onDelete('cascade');
        });
    }
  //N.B. $table->unsignedBigInteger('list_id');-> deve essere dello 'stesso' tipo di dato di id nella todolist(tabella precedente con cui è in relazione)
    //se l'utente elimina una lista o todo venga eliminato solo logicamente e non fisicamente, con possibilita di ripristinare la lista o todo
    // posso usare una colonna che mi dica se quel record è stato eliminato o no-->uso metodo softDeletes(), mi crea una colonna 
    //col nome deleted at, di tipo timestamp..perciò quando farò la destroy del record, non me lo elimina fisicamente ma mi mette questa colonna come se fosse stato cancellato 
    //poi ci sarebbe un metodo per distruggerlo del tutto..
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
