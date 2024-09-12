<?php


namespace Koders\EstimationModule\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Koders\EstimationModule\Services\EstimationResultService;

class SaveResultJob implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Koders\EstimationModule\Services\EstimationResultService
     */

    protected EstimationResultService $estimationResultService;

    public function __construct(public readonly int $estimation_id, public readonly array $data)
    {
        $this->estimationResultService = new EstimationResultService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->estimationResultService->run($this->estimation_id, $this->data);
    }
}
