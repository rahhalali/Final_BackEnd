<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormValication;
use App\Http\Requests\StoreUserValidation;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(StoreFormValication $request)
    {
        if(!hasRole('Manager')){
                if(!hasRole('Supervisor')){
                    return response()->json([
                        "message"=>'Sorry workers have not have access for this feature'
                    ]);
                }else{
                    if(auth('user')->user()->employee_positions_id <= $request->employee_positions_id){
                        $user = User::create([
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'password' => $request->password,
                            'email'=>$request->email,
                            'phone_number'=>$request->phone_number,
                            'employee_positions_id'=>$request->employee_positions_id
                        ]);
                        $token = auth('user')->login($user);
                        return $this->respondWithToken($token);
                    }else{
                        return response()->json([
                            "some hacking happened"
                        ]);
                    }
                }
        }else{
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => $request->password,
                'email'=>$request->email,
                'phone_number'=>$request->phone_number,
                'employee_positions_id'=>$request->employee_positions_id
            ]);

            $token = auth('user')->login($user);
            return $this->respondWithToken($token);
        }

    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth('user')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function logout()
    {
        auth('user')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('user')->factory()->getTTL() * 60,
            'role_id'      => auth('user')->user()->employee_positions_id
        ]);
    }
    public function index(){
        if(!hasRole('Manager')) {
            if (!hasRole('SuperVisor')) {
                return response()->json([
                    'message' => 'You are Not SuperVisor or Manager'
                ]);
            }else{
                return User::with('role')->where('employee_positions_id','>=',2)->get();
            }
        }else{
            return User::with('role')->get();
        }
    }
    public function delete($id)
    {
        $suppose = User::with('role')->where("id", $id)->pluck('employee_positions_id')->first();
        if(!hasRole('Manager')){
            if(!hasRole('Supervisor')){
                return response()->json([
                    'message'=>'You are not allowed to delete'
                ]);
            }else{
                if(auth('user')->user()->employee_positions_id <  $suppose) {
                    $user = User::where("id", $id)->delete();
                    if ($user)
                        return response()->json([
                            'message'=>'the Employee has been deleted',
                            'status' => 200
                        ]);
                }
            }
        }else{
            if(auth('user')->user()->employee_positions_id <  $suppose) {
                $user = User::where("id", $id)->delete();
                if ($user)
                    return response()->json([
                        'message'=>'the Employee has been deleted',
                        'status' => 200
                    ]);
            }else{
                return response()->json([
                    'message'=>'You Cannot delete someone who has same position as you ',
                     'status' => 403
                ]);
            }
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreUserValidation $request,$id){
        $inputs = $request->all();
        $user = User::where('id', $id)->first();
            $suppose = User::with('role')->where("id", $id)->pluck('employee_positions_id')->first();
            if(!hasRole('Manager')){
                if(!hasRole('Supervisor')){
                    return response()->json([
                        'message'=>'You are not allowed to update'
                    ]);
                }else{
                    if(auth('user')->user()->employee_positions_id <  $suppose) {
                        $user->update($inputs);
                        return response()->json([
                            'message'=>'the Employee has been updated',
                            'status' => 200
                        ]);
                    }else{
                        return response()->json([
                            'message'=>'You are not allowed to update'
                        ]);
                    }
                }
            }else{
                if(auth('user')->user()->employee_positions_id <  $suppose) {
                    $user->update($inputs);
                    return response()->json([
                        'message'=>'the Employee has been updated',
                        'status' => 200
                    ]);
                }else{
                    return response()->json([
                        'message'=>'You Cannot update someone who has same position as you ',
                        'status' => 403
                    ]);
                }

            }
        }


}
