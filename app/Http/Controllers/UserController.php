<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupUser;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::orderBy('id')->get();
        return $this->showAll($users);
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
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:12|confirmed',
        ];

        $request->validate($rules);

        $inputs=$request->all();
        $inputs['password']=bcrypt($request->password);
        User::create($inputs);
        return $this->messageResponse('Usuario agregado éxitosamente.',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::findOrFail($id);
        return $this->showOne($user);
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
        $user=User::findOrFail($id);

        $rules=[
            'name'=>'string|min:4|max:50',
            'email'=>($request->email) ? 'email|unique:users,email,'.$id.',id': '',
            'password'=>($request->password) ? 'min:6|max:12|confirmed': '',
        ];

        $request->validate($rules);

        if($request->has('name'))
            $user->name=$request->name;
        if($request->has('email'))
            $user->email=$request->email;
        if($request->has('password'))
            $user->password=bcrypt($request->password);
        if($user->isClean())
            return $this->messageResponse('Se deben especificar al menos un valor diferente para actualizar',422);
        $user->save();

        return $this->messageResponse('Usuario actualizado éxitosamente.',201);
    }

    public function login(Request $request){
        $credentials=$request->only('email','password');
        if(Auth::attempt($credentials)){
           return response()->json(['token'=>$this->updateToken($request)],200);
        }else{
           return $this->messageResponse('Error de autenticación',401);
        }
    }

    private function updateToken(Request $request)
    {
        $token = Str::random(80);
        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();
        return $token;
    }

    public function logout(Request $request){
        try {
            $request->user()->forceFill([
                'api_token' => null,
            ])->save();
            return $this->messageResponse('Usuario desconectado éxitosamente.',200);
        } catch (\Exception $e){
            return $this->messageResponse('Error de servidor: ' . $e->getMessage(), 500);
        }
    }

    public function userAssociatedGroup($user_id){
        $groups=User::findOrFail($user_id)->groups;
        if(count($groups))
            return $this->showAll($groups,200);
        return $this->messageResponse('El usuario no esta asociado a ningun grupo.',406);
    }

    public function getUsersCreatedByParentUser($parent_id){

        $users=DB::table('users as u')
                ->join('group_user as gu','u.id','=','gu.user_id')
                ->join('groups as g','g.id','=','gu.group_id')
                ->select('u.id','u.name as username','u.email','g.id as group_id','g.name as group_name')
                ->where('gu.parent_user',$parent_id)
                //->distinct('u.id')
                ->get();

        return $this->showAllQueryBuilder($users);
    }

    public function parentUserCreateUsersInGroup(Request $request){
        $rules=[
            'group_id'=>'required|integer|numeric|exists:groups,id',
            'user_id'=>'required|integer|numeric|exists:users,id',
            'parent_user'=>'required|integer|numeric|exists:users,id',
            'start_date'=>'date',
            'status'=>'in:0,1',
        ];

        $request->validate($rules);

        if($request->has('start_date')){
            return $this->messageResponse('Se esta agregando automáticamente la fecha actual del servidor.',406);
        }

        if($request->has('status')){
            return $this->messageResponse('El usuario agregado escogera si desea estar activo o no en este grupo.',406);
        }

        if(!User::userExistInGroup($request->user_id, $request->group_id)){
            $inputs=$request->all();
            $inputs['start_date']=now();
            $inputs['status']=0;
            User::findOrFail($request->parent_user)->addUserGroups()->create($inputs);
            //GroupUser::create($inputs);
            return $this->messageResponse('Usuario registrado en el grupo éxitosamente',201);
        }
        return $this->messageResponse('El usuario ya esta registrado en el grupo',406);
    }

    public function userSignInGroup(Request $request){

        $rules=[
            'group_id'=>'required|integer|numeric|exists:groups,id',
            'user_id'=>'required|integer|numeric|exists:users,id',
        ];

        $request->validate($rules);

        if(!User::userActiveInGroup($request->user_id, $request->group_id) && User::userExistInGroup($request->user_id, $request->group_id)){
            
            User::findOrFail($request->user_id)->groups()->where('status',1)->update(['status'=>0]);
            User::findOrFail($request->user_id)->groups()->where('group_id',$request->group_id)->update(['status'=>1]);
            return $this->messageResponse('El usuario ha sido activado en el grupo éxitosamente',200);
        }
        
        return $this->messageResponse('El usuario ya se encuentra activo en el grupo',406);
    }
    
}
