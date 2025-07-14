<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Card\CardCreateRequest;
use App\Http\Requests\Card\CardMoveRequest;
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

        $this->cardService->move(
            card: $card,
            targetList: $targetList,
            targetPosition: $request['position'],
        );

        return response()->json([
            'success' => true,
            'message' => 'Carte déplacée avec succès.',
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
            'position' => $this->cardService->nextPosition($list),
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd($request);
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
