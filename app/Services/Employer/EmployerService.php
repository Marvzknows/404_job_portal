<?php

namespace App\Services\Employer;

use App\Models\User;
use App\Repositories\Employer\EmployerRepositoryInterface;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmployerService implements EmployerServiceInterface
{

    private EmployerRepositoryInterface $employerRepositoryInterface;
    private FileRepositoryInterface $fileRepositoryInterface;

    public function __construct(EmployerRepositoryInterface $employerRepositoryInterface, FileRepositoryInterface $fileRepositoryInterface)
    {
        $this->employerRepositoryInterface = $employerRepositoryInterface;
        $this->fileRepositoryInterface = $fileRepositoryInterface;
    }

    public function createEmployerProfile(array $data, User $user, $logo = null)
    {
        return DB::transaction(function () use ($data, $user, $logo) {

            if ($user->role !== 'employer') {
                throw ValidationException::withMessages([
                    'role' => ['User must be an employer.']
                ]);
            }

            if ($this->employerRepositoryInterface->userHasProfile($user->id)) {
                throw ValidationException::withMessages([
                    'employer' => ['User already has an employer profile.']
                ]);
            }

            $logoFile = null;

            if ($logo) {
                $logoFile = $this->fileRepositoryInterface->store($logo, $user->id);
            }

            $employerData = [
                'user_id' => $user->id,
                'company_name' => $data['company_name'],
                'company_description' => $data['company_description'],
                'website' => $data['website'] ?? null,
                'logo_id' => $logoFile?->id,
                'contact_email' => $data['contact_email'] ?? null,
                'contact_phone' => $data['contact_phone'] ?? null,
                'location' => $data['location']
            ];

            return $this->employerRepositoryInterface->create($employerData);
        });
    }
}
