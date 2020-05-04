<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //request()->input('list_id');
        $list = $req->list_id ?: 1;
        //nel where posso passare un array di condizioni 
        $where = [
            'list_id' => $list
        ];
        if ($req->has('filter') && $req->filter !== 'ALL') {
            $where['completed'] = $req->filter === 'TODO' ? 0 : 1;
        }
        //qui vado a ritornare l'elenco dei todos
        $result = Todo::where($where)
            ->select(['id', 'todo', 'list_id', 'completed'])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return $this->getResult($result->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //altro metodo della request che si chiama only(), per leggere solo alcuni campi, gli passo un array
        //coi campi che voglio leggere 
        $data = $req->only(['list_id', 'todo', 'completed']);
        //ora posso gestire i valori, se campo lista non è true, passo di default la lista 1
        $data['list_id'] = $data['list_id'] ?: 1;
        //per ora gestisco manualmente lo user_id, lo assegno a utente numero 1
        $data['user_id'] = 1;
        //qui è dove creo una nuova risorsa(quello che ho dentro metodo/route post in web.php)
        //return Todo::create($req->all());
        $todo = Todo::create($data);
        return $this->getResult($todo->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //Todo $id è Type-Hinting
        //ciò che ho in todos/{id}
        //return Todo::findOrFail($id);
        //return $todo;
        return $this->getResult($todo->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Todo $todo)
    {
        //qui metto quello che ho in patch
        //$todo = Todo::findOrFail($todo);
        $todo->todo = $req->todo;
        $todo->completed = (int) $req->completed;
        $todo->list_id = (int) $req->list_id;
        $success = $todo->save();
        return $this->getResult($todo->toArray(), $success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        //qui quello che ho in delete
        //$todo = Todo::findOrFail($todo);
        $success = $todo->delete();
        return $this->getResult($todo->toArray(), $success);
    }
    private function getResult(array $data = [], $success = true)
    {
        return response()->json([
            'result' => $data,
            'success' => $success
        ]);
    }
}
