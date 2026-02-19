<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\UserRepositoryInterface;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $userRepositoryInterface;
    private FileRepositoryInterface $fileRepositoryInterface;
    public function __construct(
        UserRepositoryInterface $userRepositoryInterface,
        FileRepositoryInterface $fileRepositoryInterface
    ) {
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->fileRepositoryInterface = $fileRepositoryInterface;
    }


    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepositoryInterface->register($data);
    }

    public function login(array $data)
    {
        $user = $this->userRepositoryInterface->findByEmail($data['email']);
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.']
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout($user)
    {
        try {
            $user->tokens()->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function me($user)
    {
        $user = $this->userRepositoryInterface->getAuthenticatedUserWithProfile($user->id);
        return $user;
    }

    public function updateAvatar(UploadedFile $file, User $user)
    {
        return DB::transaction(function () use ($file, $user) {

            $newAvatar = $this->fileRepositoryInterface->store($file, $user->id, 'userAvatar');
            return $this->userRepositoryInterface->updateUser(['avatar_id' => $newAvatar->id], $user->id);
        });
    }
}
