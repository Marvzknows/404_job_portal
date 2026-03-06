<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavedJobController extends Controller
{

    public function list()
    {
        return 'list';
    }

    public function store(Request $request)
    {
        return 'store';
    }

    // public function show(string $id)
    // {
    //     return 'show';
    // }

    public function destroy(string $id)
    {
        return 'destroy';
    }
}
