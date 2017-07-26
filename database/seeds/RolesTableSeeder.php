<?php

use Illuminate\Database\Seeder;
use Kodeine\Acl\Traits\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		    $email_default_gerente = env('EMAIL_GERENTE', '');
        $pass_default_gerente  = env('PASS_GERENTE', '');

        $email_default_vendedor = env('EMAIL_VENDEDOR', '');
        $pass_default_vendedor  = env('PASS_VENDEDOR', '');

        $email_default_administrador = env('EMAIL_ADMINISTRADOR', '');
        $pass_default_administrador  = env('PASS_ADMINISTRADOR', '');

        $email_default_director = env('EMAIL_DIRECTOR', '');
        $pass_default_director  = env('PASS_DIRECTOR', '');

        $email_default_superadmin = env('EMAIL_SUPERADMIN', '');
        $pass_default_superadmin = env('PASS_SUPERADMIN', '');

        if( !empty($email_default_gerente) and !empty($pass_default_gerente) and !empty($email_default_vendedor) and !empty($pass_default_vendedor) and !empty($email_default_administrador) and !empty($pass_default_administrador) and !empty($email_default_director) and !empty($pass_default_director) and !empty($email_default_superadmin) and !empty($pass_default_superadmin)){


        	$records = DB::table('roles')->select(DB::raw('COUNT(*) as total'))->first();

        	if( !$records or $records->total <= 0 ) {
          		//Creating a rol
          		$role = new Kodeine\Acl\Models\Eloquent\Role();
      				$role->name = 'Gerente';
      				$role->slug = 'gerente';
      				$role->description = 'Gerente';
      				$role->save();

      				$role = new Kodeine\Acl\Models\Eloquent\Role();
      				$role->name = 'Vendedor';
      				$role->slug = 'vendedor';
      				$role->description = 'Vendedor';
      				$role->save();

      				$role = new Kodeine\Acl\Models\Eloquent\Role();
      				$role->name = 'Administrador';
      				$role->slug = 'administrador';
      				$role->description = 'Administrador';
      				$role->save();

      				$role = new Kodeine\Acl\Models\Eloquent\Role();
      				$role->name = 'Director';
      				$role->slug = 'director';
      				$role->description = 'Director';
      				$role->save();

              $role = new Kodeine\Acl\Models\Eloquent\Role();
      				$role->name = 'Superadministrador';
      				$role->slug = 'superadministrador';
      				$role->description = 'Superadministrador';
      				$role->save();
        	}

        	  $records = DB::table('users')->select(DB::raw('COUNT(*) as total'))->first();

          	if( !$records or $records->total<=0 ) {
  	    		  $user = new App\User;
      				$user->username     = 'alejadro57';
      				$user->first_name = 'Alejandro';
      				$user->last_name = 'Facio';
      				$user->email    = $email_default_gerente;
      				$user->password = bcrypt($pass_default_gerente);
      				//$user->remember_token = bcrypt(str_random(60));
      				$user->save();
      				$user->assignRole('gerente');

      				$user = new App\User;
      				$user->username     = 'mariog19';
      				$user->first_name = 'Mario';
      				$user->last_name = 'Godinez';
      				$user->email    = $email_default_vendedor;
      				$user->password = bcrypt($pass_default_vendedor);
      				//$user->remember_token = bcrypt(str_random(60));
      				$user->save();
      				$user->assignRole('vendedor');

      				$user = new App\User;
      				$user->username     = 'carloscer21';
      				$user->first_name = 'Carlos';
      				$user->last_name = 'Cerda';
      				$user->email    = $email_default_administrador;
      				$user->password = bcrypt($pass_default_administrador);
      				//$user->remember_token = bcrypt(str_random(60));
      				$user->save();
      				$user->assignRole('administrador');

      				$user = new App\User;
      				$user->username     = 'paola23';
      				$user->first_name = 'Paola';
      				$user->last_name = 'Caletti';
      				$user->email    = $email_default_director;
      				$user->password = bcrypt($pass_default_director);
      				//$user->remember_token = bcrypt(str_random(60));
      				$user->save();
      				$user->assignRole('director');

              $user = new App\User;
      				$user->username     = 'israel21';
      				$user->first_name = 'Israel Alejandro';
      				$user->last_name = 'Loera Perez';
      				$user->email    = $email_default_superadmin;
      				$user->password = bcrypt($pass_default_superadmin);
      				//$user->remember_token = bcrypt(str_random(60));
      				$user->save();
      				$user->assignRole('superadministrador');
  		    }
        }
    }
}
