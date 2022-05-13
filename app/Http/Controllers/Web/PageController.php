<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        return Inertia::render('UnderConstruction');
    }

    public function dashboard()
    {
        $informations = Information::query()->orderBy('created_at', 'DESC')->paginate(3);
        $informations_count = Information::query()->count();
        return Inertia::render('Dashboard', ['informations' => $informations, 'informations_count' => $informations_count]);
    }
}
