<?php

namespace App\Repositories\File;

use App\Models\File;
use Illuminate\Http\UploadedFile;

interface FileRepositoryInterface
{
    public function store(UploadedFile $file, int $uploadedBy, string $directory = 'public');

    public function findById(int $id);

    public function delete(File $file);

    public function create(array $data);
}
