<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy app';

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
        $this->comment('Deploying App Start ...');
        $this->testPHP();
        $this->testRedis();
        $this->testComposer();
        $this->call('optimize:clear');
        $this->alert('Everything is ok!');
    }

    protected function testPHP()
    {
        $this->comment('PHP testing started ...');
        $this->progressBar(2);
        system('php -v');
        $this->alert('PHP testing finished!');
    }

    protected function testRedis()
    {
        $redis = Redis::connection();
        $this->comment('Redis testing started ...');
        $this->progressBar(5);
        try {
            if($redis->ping()) {
                $this->alert('Redis is ready!');
            }
        } catch (\Exception $e) {
            $this->error('You have problems with Redis!');
        }
    }

    protected function testComposer()
    {
        $this->comment('Composer testing started ...');
        $this->progressBar(4);
        try {
            system('composer --version');
            system('composer dump-autoload');
            $this->alert('Composer is ready!');
        } catch (\Exception $e) {
            $this->error('You have problems with Composer!');
        }
    }

    /**
     * @param $count
     */
    protected function progressBar($count)
    {
        $this->output->progressStart($count);

        for ($i = 0; $i < $count; $i++) {
            sleep(1);
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }
}
