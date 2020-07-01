<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class UserController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api');


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if( \Gate::allows('isAdmin') || \Gate::allows('isAdmin')){


        return User::latest()->paginate(999999999);
      }
    }
    public function index2(Request $request)
    {
      if( \Gate::allows('isAdmin') || \Gate::allows('isAdmin')){

        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = User::eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);

        //return User::latest()->paginate(999999999);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
        'id' => 'required',
        'name' => 'required|string|max:191',
        'email' => 'required|string|email|max:191|unique:users',
        'type' => 'required',
        'password' => 'required|string|min:6'

      ]);
      return User::create([
        'id' => $request['id'],
        'name' => $request['name'],
        'email' => $request['email'],
        'type' => $request['type'],
        'bio' => $request['bio'],
        'photo' => 'profile.png',
        'password' => Hash::make($request['password']),
        'payout'=> $request['payout'],
        'ongoing_orders' => $request['ongoing_orders'],
        'completed_orders' => $request['completed_orders'],
        'ongoing_orders_arr' => $request['ongoing_orders_arr'],
        'current_orders_arr' => $request['current_orders_arr'],
      ]);

    }
    public function getPort(Request $request){
      //get heroku ports
      $ports = DB::table('ports')->where('id', 1)->value('name');
      return $ports;
    }
    public function getUser(Request $request){


      $user = auth('api')->user();
      $userReturn = $user;

      //$userReturn->ongoing_orders_arr = unserialize($user->ongoing_orders_arr);

      //$userReturn->current_orders_arr = unserialize($user->current_orders_arr);

      return $user;

    }
    public function updateProfile(Request $request)
    {

        $user = auth('api')->user();

        $this->validate($request,[
          'name' => 'required|string|max:191',
          'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
          'password' => 'required|min:6'

        ]);

        $currentPass=$user->password;


        if(Hash::check($request->password, $currentPass)){


        $currentPhoto = $user->photo;
        if($request->photo != $user->photo){
          $name=time().'.'.explode('/',explode(':', substr($request->photo, 0, strpos
          ($request->photo, ';')))[1])[1];
        //  return ['message'=>$name];
          \Image::make($request->photo)->save(public_path('img/profile/').$name);

          $request->merge(['photo'=>$name]);

          $userPhoto = public_path('img/profile/').$currentPhoto;
          if(file_exists($userPhoto)){
            @unlink($userPhoto);
          }
        }

        if(!empty($request->password)){
          $request->merge(['password'=> Hash::make($request['password'])]);
        }
        //$user->update($request->all());
        $user->update([
          'name' => $request->name,
          'email' => $request->email,
          'type' => $request->type,
          'bio' => $request->bio,
          'photo' => $request->photo,

        ]);
      }
      //}else{
        //return ['message'=>'Incorrect Password'];
      //}

    }
    public function val(Request $request)
    {
        $user = auth('api')->user();


        $this->validate($request,[
          'name' => 'required|string|max:191',
          'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
          'password' => 'required|min:6'
        ]);

    }

    public function profile()
    {
        return auth('api')->user();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        if(auth('api')->user()->type != 'admin'){


        $this->validate($request,[
          'name' => 'required|string|max:191',
          'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
          'password' => 'required|min:6'

        ]);

        $request->merge(['password'=> Hash::make($request['password'])]);
      }
        $user->update($request->all());
    }
    public function getUserByID(Request $request, $id)
    {
      $user=User::findOrFail($id);
      return $user;
    }

    public function getName(Request $request, $id)
    {
      $user=User::findOrFail($id);
      return $user->name;
    }

    //Below is used in Payments.vue
    public function updateSelf(Request $request){
      $user = auth('api')->user();
      //$user->update($request->all());
      $user->ongoing_orders = $request->ongoing_orders;
      $user->completed_orders = $request->completed_orders;

      //$arr[] = $request->ongoing_orders_arr;
      //$arr2[] = $request->current_orders_arr;
      $user->payout = $request->payout;
      $user->ongoing_orders_arr = $request->ongoing_orders_arr;
      $user->current_orders_arr = $request->current_orders_arr;

      $user->update($request->all());

      return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);
        $user->delete();
        //delete user
        return ['message' => 'User Deleted'];
    }

}
