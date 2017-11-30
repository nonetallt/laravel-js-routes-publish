<?php

namespace Nonetallt\Jsroute;

use Illuminate\Console\Command;

class PublishRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jsroute:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish web/routes.php to JavaScript';

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
        $path = config('jsroute.path');
        $this->info("Generating routes to '$path'");

        $jsr = new Jsroutes();
        $routes = $jsr->routes();

        $routes = $jsr->filterRoutes($routes);
        $routes = $jsr->sort($routes);
        $output = $jsr->generate($routes);

        $this->line($output);
        $handle = fopen($path, 'w');
        fwrite($handle, $output);
        fclose($handle);
        $this->info("Routes generated successfully.");
    }
}
