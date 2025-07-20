<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class SharedContentController extends Controller
{
    public function showCard(string $token)
    {
        $card = Card::where('public_token', $token)->firstOrFail();

        return view('card.show', compact('card'));
    }
}
