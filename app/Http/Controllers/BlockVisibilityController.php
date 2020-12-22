<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\BlockPage;
use Illuminate\Http\Request;

class BlockVisibilityController extends Controller
{
    public function update()
    {
        $subject = BlockPage::where('block_id', '=', request()->get('subject')['id'])->first();
        $subject->update(['visibility' => request()->get('state')]);

        return response('OK');
    }
}
