<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function resolve()
    {
        $routeParts = explode('/', request()->path(), 2);
        if (count($routeParts) == 1) {
            $routeParts[] = '/';
        }

        $page = Page::where('url', '=', $routeParts[1])->first();

        return view('page', ['page' => $page]);
    }
}
