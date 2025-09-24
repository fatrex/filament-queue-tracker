<?php

namespace Fatrex\FilamentQueueTracker\Resources\QueueMonitorResource\Widgets;

use Fatrex\FilamentQueueTracker\Models\QueueMonitor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class QueueStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $aggregationColumns = [
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(finished_at - started_at) as total_time_elapsed'),
            DB::raw('AVG(finished_at - started_at) as average_time_elapsed'),
        ];

        $aggregatedInfo = QueueMonitor::query()
            ->select($aggregationColumns)
            ->first();

        $queueSize = collect(config('filament-queue-tracker.queues') ?? ['default'])
            ->map(fn (string $queue): int => Queue::size($queue))
            ->sum();

        return [
            Stat::make(__('filament-queue-tracker::translations.total_jobs'), $aggregatedInfo->count ?? 0),
            Stat::make(__('filament-queue-tracker::translations.pending_jobs'), $queueSize),
            Stat::make(__('filament-queue-tracker::translations.execution_time'), ($aggregatedInfo->total_time_elapsed ?? 0).'s'),
            Stat::make(__('filament-queue-tracker::translations.average_time'), ceil((float) $aggregatedInfo->average_time_elapsed).'s' ?? 0),
        ];
    }
}
