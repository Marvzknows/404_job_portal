<?php

namespace App\Repositories\Employer;

use App\Models\Employer;
use App\Repositories\Base\BaseRepository;

class EmployerRepository extends BaseRepository implements EmployerRepositoryInterface
{

    public function __construct(Employer $model)
    {
        parent::__construct($model);
    }
    public function findById(int $employerId): Employer
    {
        return Employer::with('logo.uploadedBy', 'user', 'jobListings')->findOrFail($employerId);
    }

    public function userHasProfile(int $userId)
    {
        return Employer::where('user_id', $userId)->exists();
    }

    public function create(array $data)
    {
        return Employer::create($data);
    }

    public function updateEmployerProfile(int $employerId, array $data): Employer
    {
        $employer = Employer::findOrFail($employerId);
        $employer->update($data);
        return $employer->fresh();
    }

    public function deleteEmployer(int $employerId)
    {
        return $this->delete($employerId);
    }
}
