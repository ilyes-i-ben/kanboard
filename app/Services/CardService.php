<?php

namespace App\Services;

use App\Models\Card;
use App\Models\ListModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Str;

class CardService
{
    public function move(Card $card, ListModel $targetList, int $targetPosition): void
    {
        $cards = $targetList->cards()->orderBy('position')->get()->values();

        if ($card->list_id === $targetList->id) {
            $cards = $cards->filter(function($item) use ($card) {
                return $item->id !== $card->id;
            })->values();
        }

        if ($cards->isEmpty()) {
            $newPosition = 1000.0;
        } elseif ($targetPosition <= 0) {
            $newPosition = $cards[0]->position / 2;
        } elseif ($targetPosition >= $cards->count()) {
            $newPosition = $cards->last()->position + 1000.0;
        } else {
            $prev = $cards[$targetPosition - 1]->position;
            $next = $cards[$targetPosition]->position;
            $newPosition = ($prev + $next) / 2;
        }

        $card->update([
            'list_id' => $targetList->id,
            'position' => $newPosition,
            'finished_at' => $targetList->is_terminal ? Carbon::now() : $card->finished_at,
        ]);
    }

    public function newNextPosition(ListModel $list): float
    {
        $max = $list->cards()->max('position') ?? 0;
        return $max + 1000.0;
    }

    public function getOrGeneratePublicToken(Card $card): string
    {
        if (!$card->public_token) {
            $card->public_token = Str::uuid();
            $card->save();
        }
        return $card->public_token;
    }

    /** @param Card[] $cards */
    public function generateICS($cards): string
    {
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//kanboard//EN',
        ];

        foreach ($cards as $card) {
            $fullSharedUrl = route('shared-content.card', ['token' => $this->getOrGeneratePublicToken($card)]);
            $lines[] = 'BEGIN:VEVENT';
            $lines[] = 'UID:card-'.$card->public_token.'@kanboard';
            $lines[] = 'SUMMARY:'.addcslashes($card->title, ',;');
            $lines[] = 'DESCRIPTION:'. "see card detail on: " . $fullSharedUrl . addcslashes(($card->description ?? ''), ',;');
            $lines[] = 'DTSTART:'.Carbon::parse($card->created_at)->format('Ymd\THis\Z');
            if ($card->deadline) {
                $lines[] = 'DTEND:'.Carbon::parse($card->deadline)->format('Ymd\THis\Z');
            }
            if ($card->finished_at) {
                $lines[] = 'COMPLETED:'.Carbon::parse($card->finished_at)->format('Ymd\THis\Z');
            }
            $lines[] = 'URL:' . $fullSharedUrl;
            $lines[] = 'END:VEVENT';
        }

        $lines[] = 'END:VCALENDAR';

        return implode("\r\n", $lines);
    }
}
