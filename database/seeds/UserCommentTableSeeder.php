<?php

use Illuminate\Database\Seeder;

use App\Models\Site\User;

class UserCommentTableSeeder extends Seeder
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
            'comment' => 'otimo atendimento',
            'establishment_id' => 1
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'muito bom estabelecimento',
            'establishment_id' => 13
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'me diverti muito',
            'establishment_id' => 6
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'boas musicas',
            'establishment_id' => 4
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'ambiente legal',
            'establishment_id' => 10
        ];
        $user->user_comment()->create($data);

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 23

        $user = User::find(23);

        $data = [
            'author' => $user->name,
            'comment' => 'muito divertido',
            'establishment_id' => 1
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'muito bom o lugar',
            'establishment_id' => 13
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'voltaria muitas vezes',
            'establishment_id' => 5
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'boas musicas',
            'establishment_id' => 4
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'bons artistas',
            'establishment_id' => 12
        ];
        $user->user_comment()->create($data);

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 26

        $user = User::find(26);

        $data = [
            'author' => $user->name,
            'comment' => 'ja to com saudade',
            'establishment_id' => 3
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'bora de novo',
            'establishment_id' => 11
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'lugar foda',
            'establishment_id' => 7
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'curti demais',
            'establishment_id' => 9
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'voltarei em breve',
            'establishment_id' => 2
        ];
        $user->user_comment()->create($data);

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 27

        $user = User::find(27);

        $data = [
            'author' => $user->name,
            'comment' => 'barato e bom',
            'establishment_id' => 3
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'valeu cada centavo',
            'establishment_id' => 11
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'lugar top',
            'establishment_id' => 7
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'recomendo',
            'establishment_id' => 9
        ];
        $user->user_comment()->create($data);

        $data = [
            'author' => $user->name,
            'comment' => 'recomendo muito',
            'establishment_id' => 2
        ];
        $user->user_comment()->create($data);
    }
}
