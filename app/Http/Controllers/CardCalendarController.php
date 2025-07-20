<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Services\CardService;
use Illuminate\Http\Request;

class CardCalendarController extends Controller
{
    public function __construct(
        private readonly CardService $cardService,
    ) {
    }

    public function boardCalendar(Board $board)
    {
        $cards = $board->lists()->with('cards')->get()->pluck('cards')->flatten();

        $ics = $this->cardService->generateICS($cards);

        return response($ics, 200)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="board-calendar-export-'.$board->id.'.ics"');
    }
}
