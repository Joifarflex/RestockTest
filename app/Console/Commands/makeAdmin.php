<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class makeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {userEmail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'membuat role admin operasional';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = $this->argument('userEmail');
        User::where('email', $emails)
        ->update([
            'role' => 'OPERASIONAL'
        ]);
        echo "Berhasil! Role telah menjadi OPERASIONAL!";
    }
}
