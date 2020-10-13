<?php

namespace Bpm\VersionDifferenceViewer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index()
    {
        $draftVersion = Version::where('status','draft')->first();
        return response()->json([
            'draft' => $draftVersion->load('parent'),
            'changes' => $draftVersion->changes->load('user')
        ]);
    }
}
