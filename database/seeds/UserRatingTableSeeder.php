<?php

use Illuminate\Database\Seeder;
use App\Models\Site\User;
use App\Models\Site\UserRating;

class UserRatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 22

        $user = User::find(22);

        $data = [
            'author' => $user->name,
            'rating' => 3,
            'establishment_id' => 1
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 5,
            'establishment_id' => 13
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 4,
            'establishment_id' => 6
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 2,
            'establishment_id' => 4
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 4,
            'establishment_id' => 10
        ];
        $user->user_rating()->create($data);

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 23

        $user = User::find(23);

        $data = [
            'author' => $user->name,
            'rating' => 2,
            'establishment_id' => 1
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 4,
            'establishment_id' => 13
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 3,
            'establishment_id' => 5
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 5,
            'establishment_id' => 4
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 5,
            'establishment_id' => 12
        ];
        $user->user_rating()->create($data);

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 26

        $user = User::find(26);

        $data = [
            'author' => $user->name,
            'rating' => 5,
            'establishment_id' => 3
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 4,
            'establishment_id' => 11
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 3,
            'establishment_id' => 7
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 5,
            'establishment_id' => 9
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 5,
            'establishment_id' => 2
        ];
        $user->user_rating()->create($data);

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 27

        $user = User::find(27);

        $data = [
            'author' => $user->name,
            'rating' => 5,
            'establishment_id' => 3
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 4,
            'establishment_id' => 11
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 3,
            'establishment_id' => 7
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 2,
            'establishment_id' => 9
        ];
        $user->user_rating()->create($data);

        $data = [
            'author' => $user->name,
            'rating' => 5,
            'establishment_id' => 2
        ];
        $user->user_rating()->create($data);


    }
}
