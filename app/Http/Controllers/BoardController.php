<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardRequest;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index()
    {
        $boards = auth()->user()->boards()
            ->where('created_by', '!=', auth()->id())
            ->get();

        $createdBoards = auth()->user()->createdBoards()->get();

        return view('boards.index', compact('boards', 'createdBoards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BoardRequest $request)
    {
        auth()->user()->boards()->create($request->validated());

        return redirect(status: 201)
            ->route('boards.index')
            ->with('success', 'Board created successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        return view('board.show', compact('board'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        //
    }
}
