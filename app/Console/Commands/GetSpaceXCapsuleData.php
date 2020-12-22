<?php

namespace App\Console\Commands;

use App\Models\Capsule;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetSpaceXCapsuleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'space-x:get-capsule-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get SpaceX Capsule Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $this->line('Getting capsule data.');

            $client = new \GuzzleHttp\Client();
            $request = $client->get('https://api.spacexdata.com/v3/capsule');
            $response = $request->getBody();
            $contents = json_decode($response->getContents());

            $this->line('Syncing capsule data.');

            $bar = $this->output->createProgressBar(count($contents));
            $bar->start();

            foreach ($contents as $content) {
                $capsule = Capsule::updateOrCreate(
                    [
                        'capsule_serial' => $content->capsule_serial,
                    ],
                    [
                        'capsule_id' => $content->capsule_id,
                        'status' => $content->status,
                        'original_launch' => Carbon::parse($content->original_launch),
                        'original_launch_unix' => $content->original_launch_unix,
                        'landings' => $content->landings,
                        'landings' => $content->type,
                        'details' => $content->details,
                        'reuse_count' => $content->reuse_count,
                    ],
                );

                foreach ($content->missions as $mission) {
                    $capsule->missions()->updateOrCreate(
                        [
                            'flight' => $mission->flight,
                        ],
                        [
                            'name' => $mission->name,
                        ],
                    );
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
        } catch (Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());

            return -1;
        }

        DB::commit();
        $this->info('The command was successful!');

        return 0;
    }
}
