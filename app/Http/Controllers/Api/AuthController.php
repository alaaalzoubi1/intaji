<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\ProductivityTree;
use App\Models\User;
use App\Models\UserPoints;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    // POST /api/auth/register  (FR-01)
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        UserPoints::create(['user_id' => $user->id]);
        ProductivityTree::create(['user_id' => $user->id]);

        $token = $user->createToken('api')->plainTextToken;

        return $this->created([
            'user'  => new UserResource($user),
            'token' => $token,
        ], 'تم إنشاء الحساب بنجاح');
    }

    // POST /api/auth/login  (FR-02)
    public function login(LoginRequest $request): JsonResponse
    {
        $field = filter_var($request->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user  = User::where($field, $request->identifier)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('بيانات الدخول غير صحيحة', 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('api')->plainTextToken;

        return $this->success([
            'user'  => new UserResource($user),
            'token' => $token,
        ], 'تم تسجيل الدخول بنجاح');
    }

    // POST /api/auth/logout  (FR-02)
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success(message: 'تم تسجيل الخروج بنجاح');
    }

    // GET /api/auth/me
    public function me(Request $request): JsonResponse
    {
        return $this->success(new UserResource($request->user()->load('points', 'productivityTree')));
    }

    // PUT /api/auth/profile  (FR-04)
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        return $this->success(new UserResource($user), 'تم تحديث الملف الشخصي');
    }

    // POST /api/auth/personality  (FR-05)
    public function savePersonality(Request $request): JsonResponse
    {
        $request->validate([
            'chronotype'          => 'required|in:morning,evening,neutral',
            'activity_preference' => 'required|in:short,long,mixed',
            'main_goals'          => 'required|array|min:1',
            'main_goals.*'        => 'integer|exists:sections,id',
        ]);

        $request->user()->update($request->only('chronotype', 'activity_preference', 'main_goals'));
        return $this->success(message: 'تم حفظ إعدادات الشخصية');
    }
}
