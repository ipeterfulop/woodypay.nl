<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\BlockPage;
use Illuminate\Http\Request;

class BlockCopyController extends Controller
{
    public function copy()
    {
        $block = Block::find(request()->get('block'));
        if (BlockPage::where('page_id', '=', request()->get('page'))->where('block_id', '=', request()->get('block'))->count() > 0) {
            return response(__('The block is already assigned to that page'), 419);
        }
        $block->copyToPage(request()->get('page'));

        return response('OK');
    }
}
