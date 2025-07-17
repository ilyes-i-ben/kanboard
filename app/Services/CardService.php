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
            if (!$card->deadline) continue;
            $url = route('shared-content.card', ['token' => $this->getOrGeneratePublicToken($card)]);

            $start = Carbon::parse($card->deadline)->utc();
            $end = $start->copy()->addHour();

            $lines[] = 'BEGIN:VEVENT';
            $lines[] = 'UID:card-' . $card->public_token . '@kanboard';
            $lines = array_merge($lines, $this->foldLine('SUMMARY:' . addcslashes($card->title, ',;')));

            $descriptionText = 'see card detail on: ' . $url;
            if (!empty($card->description)) {
                $desc = preg_replace('/\s+/', ' ', $card->description);
                $descriptionText .= ' ' . addcslashes($desc, ',;');
            }
            $lines = array_merge($lines, $this->foldLine('DESCRIPTION:' . $descriptionText));

            $lines[] = 'DTSTART:' . $start->format('Ymd\THis\Z');
            $lines[] = 'DTEND:' . $end->format('Ymd\THis\Z');
            $lines[] = 'DTSTAMP:' . now()->utc()->format('Ymd\THis\Z');

            if ($card->finished_at) {
                $lines[] = 'COMPLETED:' . Carbon::parse($card->finished_at)->utc()->format('Ymd\THis\Z');
            }

            $lines = array_merge($lines, $this->foldLine('URL:' . $url));

            $lines[] = 'END:VEVENT';
        }

        $lines[] = 'END:VCALENDAR';

        return implode("\r\n", $lines) . "\r\n";
    }

    private function foldLine(string $line): array
    {
        $output = [];
        $max = 75;
        $len = strlen($line);
        for ($i = 0; $i < $len; $i += $max) {
            $chunk = substr($line, $i, $max);
            $output[] = ($i === 0) ? $chunk : ' ' . $chunk;
        }
        return $output;
    }
}
