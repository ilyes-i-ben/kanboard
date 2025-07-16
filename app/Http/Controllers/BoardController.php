<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\BoardCreateRequest;
use App\Http\Requests\Board\BoardUpdateRequest;
use App\Models\Board;
use App\Models\Invitation;
use App\Services\BoardService;

class BoardController extends Controller
{
    public function __construct(
        private readonly BoardService $boardService,
    ) {
    }
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

        $this->boardService->createCategories(
            board: $board,
            categories: $request->input('categories', []),
        );

        return redirect(status: 201)
            ->route('boards.index')
            ->with('success', 'Board created successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        $view = request()->query('view', 'kanban');

        $board = Board::with([
            'members',
            'lists.cards.members',
            'lists.cards.user',
            'lists.cards.list.board',
            'lists.user',
            'lists.board',
        ])->find($board->id);

        return view('board.show', compact('board', 'view'));
    }

    public function update(BoardUpdateRequest $request, Board $board)
    {
        $board->update([
            'title' => $request->validated()['title'],
            'description' => $request->validated()['description'],
            'background_color' => $request->validated()['background_color'],
        ]);

        $keepIds = $this->boardService->keepIds(
            board: $board,
            categoryIds: $request->input('category_ids', []),
            categoryNames: $request->input('categories', []),
        );

        $board->categories()->whereNotIn('id', $keepIds)->delete();

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
        if (auth()->id() !== $board->created_by) {
            return response()->json([
                'success' => false,
                'message' => 'Youre not allowed to delete the baord',
            ], 403);
        }

        $board->delete();

        return response()->json([
            'success' => true,
            'message' => 'Board deleted',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        return view('boards.edit', compact('board'));
    }
}
