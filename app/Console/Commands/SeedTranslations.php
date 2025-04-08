<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;

class SeedTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:seed {count=100000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed translations table with test data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count');
        
        $this->info('Seeding translations...');
       
        for($i=1;  $i<=$count; $i++)
        {
            Translation::factory()
            ->create();
        }
            
        $this->info("Successfully seeded {$i} translations");
    }
}
