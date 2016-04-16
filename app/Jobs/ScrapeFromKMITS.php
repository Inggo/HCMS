<?php

namespace HCMS\Jobs;

use HCMS\Facility;
use HCMS\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScrapeFromKMITS implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $url = "http://thinkopen2016.com/api/kmits/list/";
    protected $index = 0;
    protected $inc = 20;
    protected $items = [];

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            do {
                $response = json_decode(file_get_contents($this->url . $this->index), true);

                echo "Scraping info for facilities " .
                    $this->index . " to " .
                    ($this->index + count($response['items'])) . ".\n";

                $this->items = array_merge($this->items, $response['items']);
                $this->index += $this->inc;
            } while ($response &&
                array_key_exists('items', $response) &&
                count($response['items']) > 0);
        } catch (\Exception $e) {
            echo "Problem with scraping. Aborting.\n";
        }

        echo "DONE!\n";
        echo "Scraped info for " . count($this->items) . " facilities.\n";
        echo "Creating/Updating facilities as needed...\n";

        foreach ($this->items as $item) {
            $facility = Facility::firstOrNew(['name' => $item["Health Facility Name"]]);
            $facility->province = $item["Province Name"];
            $facility->type = $item["Health Facility Type"];
            $facility->latitude = $item["Latitude"];
            $facility->longitude = $item["Longitude"];
            $facility->save();
            echo "Saving " . $facility->name . " (#" . $facility->id . ")...\n";
        }
    }
}
