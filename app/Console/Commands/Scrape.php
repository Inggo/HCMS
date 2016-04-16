<?php

namespace HCMS\Console\Commands;

use Illuminate\Console\Command;
use HCMS\Jobs\ScrapeFromKMITS;

class Scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hcms:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape all Health Facilities from KMITS';

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
     * @return mixed
     */
    public function handle()
    {
        (new ScrapeFromKMITS)->handle();
    }
}
