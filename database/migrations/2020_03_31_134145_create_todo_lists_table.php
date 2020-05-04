<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoListsTable extends Migration
{
    /** estendendo la classe Migration ho accesso:
     *  alla Facades (sopra), è una classe statica che mappa tanti metodo dinamici es.Schema che a sua molta ha dei metodi es.create,
     * alla classe Blueprint che mi permette di creare una tabella attraverso dei metodi
     * 
     */
    /**
     * Run the migrations.
     *
     * @return void
     */
    /**
     * Il metodo up() viene eseguito quando chiamo php artisan migrate per ogni migrazione che creo
     * (timestamp() mette due colonne per segnalare quando il record è stato creato e quando è modificato)
     */
    public function up()
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            //metodi per creare colonne(guardo documentazione laravel migration):
            $table->id();
            $table->timestamps();
            $table->string('name');
            //lo user_id deve essere dello stesso tipo della colonna id della tabella user(il primo file della cartella migrations)
            //ricorda non voglio che lo user_id della lista sia un auto-increment, ma solo dello stesso tipo
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->foreign('user_id')
            ->on('users')
            ->references('id')
            ->onDelete('cascade');
            
        });
    }
    /**devo indicare a laravel che user_id è una FK della tabella User, 
            *concateno metodo on() per dire su quale tabella è foreingKey
            *poi indico quale è la colonna che fa riferimento 
            *poi se cancello un utente cosa deve succedere con qusta lista
            cascade, se elimini un utente, elimina anche i todolist relativi*/

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    /**
     * Quando farò una roolback viene eseguito down()
     * (in questo caso fa il drop della tabella)
     */
    public function down()
    {
        Schema::dropIfExists('todo_lists');
    }
}
