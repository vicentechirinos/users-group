<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Http\Request;

class GroupController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups=Group::orderBy('id')->get();
        return $this->showAll($groups);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required|string|min:4|max:50',
            'user_id'=>'required|integer|numeric|exists:users,id',
        ];

        $request->validate($rules);
        
        Group::create($request->all());
        return $this->messageResponse('Grupo creado éxitosamente.',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group=Group::findOrFail($id);
        return $this->showOne($group);
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
        $group=Group::findOrFail($id);

        $rules=[
            'name'=>'string|min:4|max:50',
        ];

        $request->validate($rules);

        if($request->has('name'))
            $group->name=$request->name;

        if($group->isClean())
            return $this->messageResponse('Se deben especificar al menos un valor diferente para actualizar',422);
        $group->save();

        return $this->messageResponse('Usuario actualizado éxitosamente.',201);
    }

    public function groupsCreatedByUser($user_id){
        $groups=User::findOrFail($user_id)->createGroups;
        if(count($groups))
            return $this->showAll($groups,200); 
        return $this->messageResponse('El usuario no creo ningun grupo.',406);
    }

}
