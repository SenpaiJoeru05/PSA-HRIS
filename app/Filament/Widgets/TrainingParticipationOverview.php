<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TrainingParticipationOverview extends ChartWidget
{
    protected static bool $isDiscovered = false;
    protected static ?string $heading = 'Training Participation Overview';

    // Define a maximum length for the title
    protected int $maxTitleLength = 30; // Adjust the length as needed

    protected function getData(): array
    {
        $limit = 10; // Set the limit for the number of titles shown

        $trainings = DB::table('trainings')
            ->select('title', DB::raw('jsonb_array_length(employees::jsonb) as participants'))
            ->limit($limit) // Limit the number of results
            ->get();

        // Truncate titles
        $truncatedTitles = $trainings->map(function ($training) {
            $training->title = $this->truncateTitle($training->title);
            return $training;
        });

        return [
            'datasets' => [
                [
                    'label' => 'Number of Participants',
                    'data' => $truncatedTitles->pluck('participants')->toArray(),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.4)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $truncatedTitles->pluck('title')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * Truncate the title to a maximum length and append an ellipsis if needed.
     *
     * @param string $title
     * @return string
     */
    protected function truncateTitle(string $title): string
    {
        $length = $this->maxTitleLength;

        // Truncate and append ellipsis if the title is too long
        return strlen($title) > $length ? substr($title, 0, $length) . '...' : $title;
    }
}
