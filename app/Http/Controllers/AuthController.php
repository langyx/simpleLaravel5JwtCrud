<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Config;


use Validator;


class AuthController extends Controller
{

    public function __construct()
    {
        /**
         * Only logged can enter
         */
        $this->middleware('auth:api')->except(['register' , 'login']);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|email|max:255',
            'name'      => 'required',
            'password'  => 'required',
            'level'     => 'required',
            'promo_id'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $updatedFields = ['email', 'name', 'password'];

        $request->merge(['password' => bcrypt($request->password)]);

        $loggedUser     =   UserHelper::getJwtUser();

        switch ($loggedUser->level)
        {
            case Config::get('constants.level.admin'):
                array_push($updatedFields, 'promo_id', 'level');
                break;

            case Config::get('constants.level.mod'):
                if (empty($user->promo) || $user->promo->modo_id != $loggedUser->id)
                {
                    return response()->json(['msg' => Config::get('constants.message.notRight')], 403);
                }
                array_push($updatedFields, 'promo_id');
                break;

            default:
                if ($user->id != $loggedUser->id)
                {
                    return response()->json(['msg' => Config::get('constants.message.notRight')], 403);
                }
                break;
        }

        $user->update($request->only($updatedFields));
        return new UserResource($user);

    }

    public function register(Request $request)
    {
        /**
         * Check if user is logged
         */
        if (!empty(JWTAuth::getToken()))
        {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
      $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only(['email', 'password']);

        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Method get
     * Logout user by his jwt token
     * @return mixed
     */
    public function logout()
    {
        return (JWTAuth::invalidate(JWTAuth::getToken()));

    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}
