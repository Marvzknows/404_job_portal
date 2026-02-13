<?php

namespace App\Repositories\File;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Repositories\File\FileRepositoryInterface;

class FileRepository implements FileRepositoryInterface
{
    public function store(UploadedFile $file, int $uploadedBy, string $directory = 'public')
    {
        // Store in public disc
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $fileName, 'public');
        //store in db
        return $this->create([
            'uploaded_by' => $uploadedBy,
            'file_name' => $fileName,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'url' => asset("storage/{$path}")
        ]);
    }

    public function findById(int $id)
    {
        return File::find($id);
    }

    public function delete(File $file): bool
    {
        // Delete physical file
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Delete record
        return $file->delete();
    }

    public function create(array $data)
    {
        return File::create($data);
    }
}
