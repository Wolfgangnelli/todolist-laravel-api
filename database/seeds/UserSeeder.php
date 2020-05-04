<?php

use Illuminate\Database\Seeder;
/*use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
*/
use App\Models\User;
use App\Models\TodoList;
use App\Models\Todo;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //potrei creare un ciclo for per creare un certo num di utenti, ma lo provo a fare con le factory

        // Writing Seeders
        /*
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'created_at' => now()
        ]);
        */
        /**
         * Using Model Factories (Per inserire meliminare aggiornare i dati nel DB uso le factory)
         * 
         *  factory(Nome della factory che voglio usare(in UserFactory è User), quantità di record che voglio creare)-> chiamo motodo 
         *  create() qui potrei sovrascrivere i campi che vengono creati automaticamente dallo userFactory
         * posso modificare uno dei dati di default, passo un array per modificare qualche colonna
         * create() ritorna una collection quindi per ogni elemento posso chiamare each e eseguire una funz
         */

        factory(User::class, 50)
        ->create()->each(function($user) {
            //posso chiamare qui una factory per creare una lista per ogni user
            factory(TodoList::class, 10)->create([
                //chiamando poi il metodo create della lista
                //sovrascrivo o imposto il campo user_id della lista con l'id dell'utente corrente(che ho passato alla funz all'inizio)
                //viene fatto il merge di questo array con quello generato dalla factory TodoList
                'user_id'=> $user->id 
            ])->each(function($list) {
                factory(Todo::class, 10)->create([
                    'list_id' => $list->id
                ]);
            });
        });
    }
}




