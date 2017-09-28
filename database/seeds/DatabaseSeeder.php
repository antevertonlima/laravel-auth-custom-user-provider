<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('pessoas')->truncate();
    	DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    	
        //ATENCAO CPF ALEATORIO!!
        factory(\App\User::class,1)->create([
            'user_name' => 'caue.prado',
            'password' => bcrypt('secret'),
            'pessoa_id' => (factory(App\Pessoa::class, 1)->create([
                'nome' => 'Caue',
                'sobrenome' => 'Prado',
                'cpf' => '61112330097',
                'email' => 'caue.prado0@gmail.com',
            ]))[0]->id,
        ]);

        for ($i = 0; $i < 20; $i++) {
        	$pessoa = factory(App\Pessoa::class, 1)->create();

        	factory(App\User::class, 1)->create([
        	    'pessoa_id' => $pessoa[0]->id,
        	]);	
        }
    }
}
