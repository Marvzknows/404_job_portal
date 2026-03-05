<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityLogController extends Controller
{

    public function list()
    {
        return 'paginated activity log list';
    }

    public function store(Request $request)
    {
        return 'create activity log';
    }

    public function show(string $id)
    {
        return 'show activity log';
    }

    public function update(Request $request, string $id)
    {
        return 'update activity log';
    }

    // public function destroy(string $id)
    // {
    //     //
    // }
}
