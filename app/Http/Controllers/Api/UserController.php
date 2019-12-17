<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\UserResource;

class UserController extends Controller
{
    /**
     * 返回用户列表
     * @return mixed
     */
    public function index()
    {
        $users = User::paginate(3);
        return UserResource::collection($users);
    }

    /**
     * 返回单一用户信息
     *
     * @param User $user
     *
     * @return User
     */
    public function show(User $user){
        return $this->success(new UserResource($user));
    }

    /**
     * 用户注册.
     *
     * @return string
     */
    public function store()
    {
        User::create(request()->all());

        return $this->setStatusCode(201)->success('用户创建成功');
    }

    /**
     * 用户登录
     *
     * @param Request $request
     *
     * @return string
     */
    public function login(Request $request)
    {
        $res = Auth::guard('web')->attempt(['name'=>$request->name,'password'=>$request->password]);

        if($res){
            return $this->success('用户登录成功');
        }
        return $this->failed('用户登录失败', 401);
    }
}
