<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    //    protected $guard_name = 'customer';
    //
    protected $guard = 'customer';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'phone',
        'password',
        'status',
        'reference_user',
        'lifetime_package',
        'monthly_package',
        'remember_token',
        'balance',
        'address',
        'country_id',
        'zip',
        'city',
        'email_verified_at',
        'document_verified',
        'monthly_package_enrolled_at',
        'monthly_package_status',
        'two_factor_code',
        'auth_2fa',
        'two_factor_code_expire_at'
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

    public function leader()
    {
        return $this->belongsTo(Customer::class, 'reference_user');
    }
    public function kyc()
    {
        return $this->belongsTo(Kyc::class, 'id', 'customer_id');
    }

    public function lifetimePackage()
    {
        return $this->belongsTo(LifetimePackage::class, 'lifetime_package');
    }

    public function monthlyPackage()
    {
        return $this->belongsTo(MonthlyPackage::class, 'monthly_package');
    }

    public function subscribers()
    {
        return $this->hasMany(Customer::class, 'reference_user');
    }
}
