<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Workers;
use App\Models\Example_work;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fio',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static $columnsInputs = [
        'fio' => 'ФИО', 
        'email' => 'Почта',
        'role' => 'Роль',
        'password' => 'Пароль',
    ];

    const ROLES = [
        'admin', 'moderator', 'user', 
    ];

    public function workers()
    {
        return $this->hasOne(Workers::class);
    }
    
    public function exampleWorks()
    {
        return $this->hasMany(Example_work::class);
    }

    public function getColumns(){

        $tableName = $this->getTable();

        $columns = Schema::getColumnListing($tableName);

        foreach($columns as $col){
            
            if (isset(self::$columnsInputs[$col])){
                $translate = trans('crud.Users.fields.'.$col);
                if ($translate){
                    $res[$col]['name_ru'] = $translate;
                    $res[$col]['type'] = Schema::getColumnType($tableName, $col);
                }
            }
        }

        return $res;
    }

    // sendEmailVerificationNotification
}
