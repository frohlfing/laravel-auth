<?php

namespace FRohlfing\PackageSkeleton\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;

class RunPackageSkeletonCommand extends Command
{
    /**
     * Exit Codes.
     */
    const EXIT_SUCCESS = 0;
    const EXIT_FAILURE = 1;

    /**
     * Configuration
     *
     * @var array
     */
    protected $config;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'package-skeleton:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just a example command.';

    /**
     * Create a new command instance.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->config = $app['config']['package-skeleton'];

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return static::EXIT_SUCCESS;
    }
}
