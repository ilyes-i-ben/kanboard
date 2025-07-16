<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Card;
use App\Models\ListModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userBoards = auth()->user()->boards()->with('lists', 'members')->get();


        $userStats = $this->getUserStats($userBoards);

        $cardStats = $this->getCardCompletionStats($userBoards);

        $selectedBoardId = $request->get('board_id');
        if ($selectedBoardId) {
            $cardStats = $cardStats->where('board_id', $selectedBoardId);
        }

        return view('dashboard', compact('cardStats', 'userStats', 'userBoards', 'selectedBoardId'));
    }

    private function getCardCompletionStats($userBoards)
    {
        return DB::table('cards')
            ->join('card_members', 'cards.id', '=', 'card_members.card_id')
            ->join('users', 'card_members.user_id', '=', 'users.id')
            ->join('lists', 'cards.list_id', '=', 'lists.id')
            ->join('boards', 'lists.board_id', '=', 'boards.id')
            ->whereIn('boards.id', $userBoards->pluck('id'))
            ->whereNotNull('cards.finished_at')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'boards.id as board_id',
                'boards.title as board_title',
                'boards.background_color as board_background_color',
                DB::raw('COUNT(cards.id) as completed_cards_count'),
                DB::raw('MAX(cards.finished_at) as last_completion_date')
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'boards.id', 'boards.title', 'boards.background_color')
            ->orderBy('completed_cards_count', 'desc')
            ->get();
    }

    private function getUserStats($userBoards)
    {
        return DB::table('cards')
            ->join('card_members', 'cards.id', '=', 'card_members.card_id')
            ->join('users', 'card_members.user_id', '=', 'users.id')
            ->join('lists', 'cards.list_id', '=', 'lists.id')
            ->join('boards', 'lists.board_id', '=', 'boards.id')
            ->whereIn('boards.id', $userBoards->pluck('id'))
            ->whereNotNull('cards.finished_at')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                DB::raw('COUNT(cards.id) as total_completed_cards'),
                DB::raw('COUNT(DISTINCT boards.id) as boards_participated'),
                DB::raw('MAX(cards.finished_at) as last_completion_date')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_completed_cards', 'desc')
            ->get();
    }
}

