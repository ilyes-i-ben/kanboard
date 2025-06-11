<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\BoardMemberRemoveRequest;
use App\Models\Board;
use App\Models\User;

class BoardMemberController extends Controller
{
    public function index(Board $board)
    {
        if (!$board->hasMember(auth()->id())) {
            abort(403);
        }

        return view('boards.members', compact('board'));
    }

    public function remove(BoardMemberRemoveRequest $request, Board $board, User $user)
    {
        if (!$board->hasMember($user)) {
            return
                back()
                ->with('error', 'The user is not a member of the board.');
        }

        $board->members()->detach($user);

        return back()->with('success', 'Member removed successfully.');
    }
}
