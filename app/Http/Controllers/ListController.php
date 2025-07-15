<?php

namespace App\Http\Controllers;

use App\Http\Requests\List\ListMoveRequest;
use App\Models\Board;
use App\Models\ListModel;
use App\Services\ListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ListController extends Controller
{
    public function __construct(
        private readonly ListService $listService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function move(ListMoveRequest $moveRequest)
    {
        $request = $moveRequest->validated();

        $board = Board::findOrFail($request['board_id']);
        $list = ListModel::findOrFail($request['list_id']);

        $this->listService->move(
            board: $board,
            list: $list,
            newPosition: $request['position'],
        );

        return response()->json([
            'success' => true,
            'message' => 'List moved successfully.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // todo: move to ListCreateRequest...
        $validated = $request->validate([
            'list_name' => 'required|string|max:255',
            'is_terminal' => 'nullable|boolean',
            'board_id' => 'required|int',
        ]);

        $board = Board::find($validated['board_id']);
        $isTerminal = $request->has('is_terminal');
        $list = ListModel::create([
            'title' => $validated['list_name'],
            'is_terminal' => $isTerminal,
            'board_id' => $validated['board_id'],
            'position' => $board->lists()->max('position') + 1,
            'created_by' => auth()->id(),
        ]);

        if ($isTerminal) {
            $board->lists()
                ->where('id', '!=', $list->id)
                ->update(['is_terminal' => false]);
        }

        return response()->json([
            'success' => true,
            'message' => 'List created successfully!',
            'list' => $list,
            'terminal' => $isTerminal,
        ]);
    }

    /**
     * Render the specified list as HTML (for AJAX UI update).
     */
    public function render(ListModel $list)
    {
        $list = ListModel::with([
            'board.members',
        ])->find($list->id);

        $html = view('components.list', compact('list'))->render();
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ListModel $listModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListModel $listModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListModel $list)
    {
        $validated = $request->validate([
            'list_name' => 'required|string|max:255',
            'board_id' => 'required|int',
            'is_terminal' => 'nullable|boolean',
        ]);

        $isTerminal = $request->has('is_terminal');

        $list->update([
            'title' => $validated['list_name'],
            'is_terminal' => $isTerminal,
        ]);

        if ($isTerminal) {
            $this->listService->newTerminal($list);
        }

        return response()->json([
            'success' => true,
            'message' => 'List updated successfully!',
            'listId' => $list->id,
            'terminal' => $isTerminal,
            'title' => $list->title,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListModel $list)
    {
        Gate::authorize('delete', $list);

        $wasTerminal = $list->is_terminal;
        if ($wasTerminal) {
            $doneList = $list->board->lists()->whereRaw('LOWER(title) = ?', ['done'])->first();
            $doneList?->update(['is_terminal' => true]);
        }

        $list->delete();
        return response()->json([
            'success' => true,
            'message' => 'List deleted successfully!',
            'listId' => $list->id,
            'wasTerminal' => $wasTerminal,
            'newTerminalId' => $wasTerminal ? $doneList->id : null,
        ]);
    }
}
