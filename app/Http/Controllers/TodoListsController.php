<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //qui ritorno l'elenco delle liste
        //return TodoList::paginate(20);
        $lists = TodoList::paginate(20);
        return $this->getResult($lists->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = 1;
        //prendo req.input e leggo solo param name
        $name = $request->input('name');
        //creo nuova risorsa
        $todoList = new TodoList();
        $todoList->name = $name;
        $todoList->user_id = $user_id;
        $todoList->deleted_at = now();
        //altro modo senza aggiungere fillable in Models/TodoList, perchè con save posso salvare il model e commento altro return 
        $success = $todoList->save();
        //return $todoList;
        return $this->getResult($todoList->toArray(), $success);

        // con compact passo un array
        // return TodoList::create(compact('name', 'user_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function show(TodoList $todolist)
    {

        return $this->getResult($todolist->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoList $todolist)
    {
        $todolist->name = $request->name;
        $success = $todolist->save();
        return $this->getResult($todolist->toArray(), $success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoList $todolist)
    {
        $success = $todolist->delete();
        return $this->getResult($todolist->toArray(), $success);
    }
    private function getResult(array $data = [], $success = true)
    {
        return response()->json([
            'result' => $data,
            'success' => $success
        ]);
    }
}
