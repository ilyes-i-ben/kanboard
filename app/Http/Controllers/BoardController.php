<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\BoardCreateRequest;
use App\Http\Requests\Board\BoardUpdateRequest;
use App\Models\Board;
use App\Models\Invitation;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {
        $boards = auth()->user()->boards()
            ->where('created_by', '!=', auth()->id())
            ->get();

        $createdBoards = auth()->user()->createdBoards()->get();

        $invitations = Invitation::query()
            ->where('email', auth()->user()->email)
            ->valid()
            ->with(['board', 'inviter'])
            ->get();

        return view('boards.index', compact('boards', 'createdBoards', 'invitations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(BoardCreateRequest $request)
    {
        $board = auth()->user()->boards()->create($request->validated());

        $categories = $request->input('categories', []);
        foreach ($categories as $catName) {
            if ($catName && trim($catName) !== '') {
                $board->categories()->create(['name' => trim($catName)]);
            }
        }

        return redirect(status: 201)
            ->route('boards.index')
            ->with('success', 'Board created successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        $board = Board::with([
            'members',
            'lists.cards.members',
            'lists.cards.user',
            'lists.cards.list.board',
            'lists.user',
            'lists.board',
        ])->find($board->id);

        return view('board.show', compact('board'));
    }

    public function update(BoardUpdateRequest $request, Board $board)
    {
        $board->update([
            'title' => $request->validated()['title'],
            'description' => $request->validated()['description'],
            'background_color' => $request->validated()['background_color'],
        ]);

        return back()->with('success', 'Board updated successfully.');
    }

    public function rename(BoardUpdateRequest $request, Board $board)
    {
        $board->update([
            'title' => $request->validated()['title'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Board renamed !',
            'board' => $board,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        return view('boards.edit', compact('board'));
    }
}
