<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Controllers\RoleController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Types\Relations\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as ModelsRole;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'type',
        'locale'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(RoleController::class, 'type', 'id');
    }
    public function account()
    {
        return $this->hasOne(UserAccount::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'payable_id', 'id')->orderBy('id', 'desc');
    }
    public function supplier_invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id', 'id')->orderBy('id', 'desc');
    }
}
