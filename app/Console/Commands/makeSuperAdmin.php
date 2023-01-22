<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class makeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:superadmin {userEmail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat role admin superadmin';

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
            'role' => 'SUPERADMIN'
        ]);
        echo "Berhasil, role telah menjadi SUPERADMIN";
    }
}
