<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Artisan;

class generateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generateAdmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate Admin account';

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
        $data= [];
        Artisan::call('migrate'); //migrate all tables
        Artisan::call('passport:install'); //create access token for passport

        DB::beginTransaction();
        $name = $this->ask('What is Admin name?');

        if (empty($name)) {
            return $this->error('Please provide admin name!');
        }

        $password = $this->secret('What is the password for the admin');

        if (empty($password)) {
            return $this->error('Please provide password for admin!');
        }

        $email = $this->ask('What is Admin email?');

        if (empty($email)) {
            return $this->error('Please provide admin email!');
        }

        $data = [
            0 => [
                'id' => 1,
                'slug' => 'super-admin',
                'name' => 'Super Admin',
                'description' => 'Manage all users and roles',
                'created_at' => now()
            ],
            1 => [
                'id' => 2,
                'slug' => 'sel-leader',
                'name' => 'Sel Leader',
                'description' => 'Manage specific sel group',
                'created_at' => now()
            ],
            2 => [
                'id' => 3,
                'slug' => 'sel-member',
                'name' => 'Sel Member',
                'description' => 'Manage his/her account and add,edit or delete prayers and devotions data',
                'created_at' => now()
            ]
        ];

        $roles = DB::table('roles')->insert($data);

        $admin = DB::table('users')->insert([
            'id' => 1,
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'status' => 'ACTIVE',
            'role_id'=> 1,
            'email_verified_at' => now(),
            'contact_no' => '09991231111',
        ]);

        if ($roles && $admin) {
            DB::commit();
            return $this->info('The command was successful!');
        }

        DB::rollBack();
        return $this->error('Command could not be completed!');

    }
}
