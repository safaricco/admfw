<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'ultimo_acesso'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function selecionarUsuarios()
    {
        return DB::table('users')
            ->join('perfil_user', 'perfil_user.id_user', '=', 'users.id')
            ->join('perfil', 'perfil_user.id_perfil', '=', 'perfil.id_perfil')
            ->select(
                'perfil.descricao as perfil',
                'users.id',
                'users.name',
                'users.email',
                'users.status'
            )
            ->where('users.id', '>', 1)
            ->groupBy('users.id')
            ->get();
    }
}
