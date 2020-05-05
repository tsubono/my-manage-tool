<?php

use Illuminate\Database\Seeder;
use \App\Models\User;

/**
 * Class UsersTableSeeder
 *
 * ログイン用のユーザーを生成する
 */
class UsersTableSeeder extends Seeder
{

    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * UsersTableSeeder constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$now = \Carbon::now();
        if (!$this->user->query()->where('email', 'user1@user.com')->exists()) {
            $this->user->create([
                'name' => 'user1',
                'email' => 'user1@user.com',
                'password' => \Hash::make('password1'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
	}
}
