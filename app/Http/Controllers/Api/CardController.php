<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Card\CardCreateRequest;
use App\Http\Requests\Card\CardMoveRequest;
use App\Http\Requests\Card\CardUpdateRequest;
use App\Models\Card;
use App\Models\ListModel;
use App\Services\CardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function __construct(
        private readonly CardService $cardService,
    ) {
    }

    /*
     * move a card.
     */
    public function move(CardMoveRequest $moveRequest): JsonResponse
    {
        $request = $moveRequest->validated();
        $card = Card::findOrFail($request['card_id']);
        $targetList = ListModel::findOrFail($request['list_id']);

        $original = $card->list;

        $this->cardService->move(
            card: $card,
            targetList: $targetList,
            targetPosition: $request['position'],
        );

        return response()->json([
            'success' => true,
            'message' => 'Card moved successfully.',
            'completed' => $targetList->is_terminal,
            'original' => [
                'id' => $original->id,
                'emptied' => $original->cards()->count() === 0,
            ],
            'target' => [
                'id' => $targetList->id,
                'wasEmpty' => $targetList->cards()->count() === 1,
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CardCreateRequest $createRequest)
    {
        $request = $createRequest->validated();

        $list = ListModel::find($request['list_id']);
        $card = Card::create([
            'list_id' => $request['list_id'],
            'title' => $request['title'],
            'description' => $request['description'],
            'priority' => $request['priority'],
            'position' => $this->cardService->newNextPosition($list),
            'deadline' => $request['deadline'],
            'created_by' => auth()->id(),
        ]);

        $card->members()->sync($request['assignees']);

        return response()->json([
            'success' => true,
            'message' => 'Card created successfully!',
            'card' => $card,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function markIncomplete(Card $card)
    {
        if (!auth()->user()->can('update', $card)) {
            return response()->json([
                'success' => false,
                'message' => 'You don\'t have the right to update.',
            ], 403);
        }

        if ($card->finished_at === null) {
            return response()->json([
                'success' => false,
                'message' => 'Card is incomplete already !',
            ]);
        }

        $card->update(['finished_at' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Card marked incomplete !',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CardUpdateRequest $request, Card $card)
    {
        if (!auth()->user()->can('update', $card)) {
            return response()->json([
                'success' => false,
                'message' => 'You don\'t have the right to update.',
            ], 403);
        }

        $validated = $request->validated();

        $card->fill($validated);
        $card->save();

        if (isset($validated['assignees'])) {
            $card->members()->sync($validated['assignees']);
        }

        return response()->json([
            'success' => true,
            'card' => $card->load('members', 'user', 'list'),
        ]);
    }

    public function destroy(Card $card)
    {
        if (!auth()->user()->can('delete', $card)) {
            return response()->json([
                'success' => false,
                'message' => 'You don\'t have the right to delete.',
            ], 403);
        }

        $card->delete();

        return response()->json([
            'success' => true,
            'message' => 'Card deleted successfully.',
        ]);
    }

    public function render(Card $card)
    {
        $html = view('components.card', ['card' => $card])->render();
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
