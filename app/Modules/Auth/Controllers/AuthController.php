<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use App\Models\User;
use App\Modules\Auth\Requests\AuthLoginRequest;
use App\Modules\Auth\Requests\AuthRegisterRequest;
use App\Modules\Auth\Requests\UpdatePasswordRequest;
use App\Modules\Auth\Requests\UpdateProfileRequest;
use App\Modules\Auth\Requests\UpdateSocialLinkRequest;
use Defrindr\Crudify\Exceptions\BadRequestHttpException;
use Defrindr\Crudify\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     */
    public function login(AuthLoginRequest $request)
    {
        $credentials = request()->only(['email', 'password']);
        if (! Auth::attempt($credentials)) {
            throw new BadRequestHttpException('Authentikasi tidak valid');
        }

        $user = $request->user();

        return $this->responseAuthFrom($user, 'Login sukses');
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return ResponseHelper::successWithData([
            'user' => $request->user(),
        ]);
    }

    /**
     * Updated profile authenticated User
     *
     * @return [json] user object
     */
    public function updateUser(UpdateProfileRequest $request)
    {
        $payload = $request->only('name', 'email', 'phone_number', 'country');

        $user = $request->user();
        if ($user->update($payload)) {
            return ResponseHelper::successWithData([
                'user' => $request->user(),
            ], 'Berhasil mengubah profile');
        }

        return ResponseHelper::badRequest('Gagal mengubah profile');
    }

    /**
     * Updated password for authenticated User
     *
     * @return [json] user object
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $password = $request->get('newPassword');
        $user = $request->user();

        if (! Hash::check($request->get('oldPassword'), $user->password)) {
            return ResponseHelper::badRequest('Your old password wrong');
        }

        if ($request->get('confirmPassword') !== $password) {
            return ResponseHelper::badRequest('Your new password and confirm password not matched');
        }

        $password = bcrypt($password);
        $payload = compact('password');
        if ($user->update($payload)) {
            return ResponseHelper::successWithData([
                'user' => $request->user(),
            ], 'Berhasil mengubah password');
        }

        return ResponseHelper::badRequest('Gagal mengubah password');
    }

    public function social()
    {
        $user = auth()->user();

        return ResponseHelper::successWithData($this->getSocial($user));
    }

    public function updateSocial(UpdateSocialLinkRequest $request)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();
            $socialLinks = $request->get('socials') ?? [];

            foreach ($socialLinks as $socialLink) {
                // check on empty value
                if (! $socialLink['value']) {
                    continue;
                }

                $existModel = SocialLink::userAndName($user, $socialLink['name'])->first();

                if ($existModel) {
                    $existModel->update($socialLink);
                } else {
                    $socialLink['user_id'] = $user->id;
                    SocialLink::create($socialLink);
                }
            }
            DB::commit();

            return ResponseHelper::successWithData($this->getSocial($user), 'Informasi sosial media berhasil di update');
        } catch (\Throwable $th) {
            DB::rollBack();

            return ResponseHelper::conflict($th->getMessage());
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ResponseHelper::successWithData(null, 'Successfully logged out');
    }

    public function register(AuthRegisterRequest $request)
    {
        $payload = $request->all();
        $payload['role'] = User::ROLE_REGISTER;
        try {
            $exist = User::where('email', $payload['email'])->first();
            if ($exist) {
                return ResponseHelper::badRequest('Email telah digunakan');
            }
            $user = User::create($payload);
            if ($user) {
                return $this->responseAuthFrom($user, 'Berhasil membuat akun');
            }

            return ResponseHelper::badRequest('Gagal membuat akun');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th, 'Terjadi kesalahan');
        }
    }

    public function confirmRole(Request $request)
    {
        $request->validate(['role' => 'required|in:'.User::ROLE_TALENT.','.User::ROLE_PRODUCER]);

        $user = request()->user();
        if ($user->role != User::ROLE_REGISTER) {
            return ResponseHelper::badRequest('Profile telah diatur, tidak dapat melakukan perubahan.');
        }
        $success = $user->update(['role' => $request->get('role')]);
        if ($success) {
            $redirectUrl = $this->getRedirectUrl($user);

            return ResponseHelper::successWithData(compact('redirectUrl', 'user'), 'Berhasil menyimpan data');
        }

        return ResponseHelper::badRequest('Profile gagal di simpan');
    }

    private function responseAuthFrom($user, $message = '')
    {
        $token = $this->createAccessToken($user);
        $redirectUrl = $this->getRedirectUrl($user);
        $expiredAt = time() + User::TOKEN_EXPIRED_TIME;

        return ResponseHelper::successWithData([
            'accessToken' => $token,
            'redirectUrl' => $redirectUrl,
            'expiredAt' => $expiredAt,
            'tokenType' => 'Bearer',
            'user' => $user,
        ], $message);
    }

    private function createAccessToken($user): string
    {
        $tokenResult = $user->createToken('Personal Access Token');

        return $tokenResult->plainTextToken;
    }

    private function getRedirectUrl($user): string
    {

        if ($user->role == User::ROLE_ADMIN) {
            $redirectUrl = '/admin/dashboard';
        } elseif ($user->role == User::ROLE_PRODUCER) {
            $redirectUrl = '/producer/dashboard';
        } elseif ($user->role == User::ROLE_TALENT) {
            $redirectUrl = '/talent/dashboard';
        } elseif ($user->role == User::ROLE_REGISTER) {
            $redirectUrl = '/auth/user-type';
        }

        return $redirectUrl ?? '';
    }

    private function getSocial(User $user)
    {
        $links = SocialLink::whereUserId($user->id)->get();

        $socials = [];

        foreach ($links as $link) {
            $socials[$link->name] = $link->value;
        }

        return compact('socials');
    }
}
