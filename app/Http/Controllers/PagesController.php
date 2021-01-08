<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function resolve()
    {
        $routeParts = explode('/', request()->path(), 2);
        if (count($routeParts) == 1) {
            if ($routeParts[0] == '/') {
                return redirect('/en');
            }
            $routeParts[] = '/';
        }
        Locale::setValidatedLocale($routeParts[0]);
        $page = Page::where('url_'.$routeParts[0], '=', $routeParts[1])->first();
        if ($page == null) {
            abort(404);
        }
        $blocks = $page->getBlocks();
        return view('page', [
            'page' => $page,
            'blocks' => $blocks,
        ]);
    }
}
