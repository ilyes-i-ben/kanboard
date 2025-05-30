<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;

class BoardMemberController extends Controller
{
    public function index(Board $board)
    {
        if (!$board->members->contains(auth()->id())) {
            abort(403);
        }

        return view('boards.members', compact('board'));
    }
}
