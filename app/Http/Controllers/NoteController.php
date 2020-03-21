<?php

namespace App\Http\Controllers;

use App\GroupUser;
use App\Note;
use App\User;
use Illuminate\Http\Request;

class NoteController extends ApiController
{

    public function createNoteInGroup(Request $request){
        $rules=[
            'title'=>'required|string|min:4|max:100',
            'details'=>'required|string|min:4|max:256',
            'group_id'=>'required|integer|numeric|exists:groups,id',
            'user_id'=>'required|integer|numeric|exists:users,id',
            'date'=>'date',
        ];
        $request->validate($rules);

        if($request->has('date')){
            return $this->messageResponse('Se esta agregando automáticamente la fecha actual del servidor.',406);
        }

        if(User::userActiveInGroup($request->user_id, $request->group_id) && User::userExistInGroup($request->user_id, $request->group_id)){
            $inputs=$request->all();
            $inputs['date']=now();

            GroupUser::where('group_id',$request->group_id)->where('user_id',$request->user_id)->first()->notes()->create($inputs);
            
            return $this->messageResponse('Nota agregada éxitosamente.',201);
        }else
            return $this->messageResponse('El usuario no esta activo o no existe en el grupo',406);

        //return $this->messageResponse('Ocurrio un error inesperado al agregar la nota',500);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
