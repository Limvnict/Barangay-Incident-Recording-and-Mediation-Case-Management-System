<?php
namespace App\Http\Controllers\Resident;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NoticeController extends Controller {
    public function index(Request $r) {
        return view('resident.notices', ['notices' => $r->user()->notices()->latest()->paginate(15)]);
    }

    // mark everything as read (used by the pop-up and the notices page)
    public function read(Request $r) {
        $r->user()->notices()->whereNull('read_at')->update(['read_at' => now()]);
        return back();
    }
}
