<?php

namespace App\Jobs;

use App\Models\DatasetResource;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Log;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;

class UpdateAndRevalidateResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var DatasetResource */
    protected DatasetResource $resource;

    /**
     * Create a new job instance.
     *
     * @param DatasetResource $resource
     */
    public function __construct(DatasetResource $resource)
    {
        $this->resource = $resource->withoutRelations();
        $this->resource->load('media');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Hey');
        $error = null;

        $body = Http::get($this->resource->source_url)->body();

        switch ($this->resource->format) {
            case "json":
                $error = $this->validateJsonString($body);
        }

        $this->resource->error = is_null($error) ? null : $error->getMessage();
        $this->resource->save();
        $this->resource->touch();


        $file_name = Str::of($this->resource->name)
            ->slug('-')
            ->append('-')
            ->append(Carbon::now()->format('mdyHis'))
            ->__toString();

        $this->resource->clearMediaCollection('data');

        $this->resource
            ->addMediaFromBase64(base64_encode($body))
            ->usingFileName($file_name . '.' . $this->resource->format)
            ->usingName($file_name)
            ->toMediaCollection('data');

    }

    /**
     * Validates the given input. Returns the validation error or null if the input is valid.
     *
     * @param $input
     * @return Exception|ParsingException|null
     */
    public function validateJsonString($input)
    {
        $parser = new JsonParser();
        return $parser->lint($input);
    }

}
