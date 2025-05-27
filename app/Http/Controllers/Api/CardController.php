<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
