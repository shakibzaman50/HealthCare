<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionSetting extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permission_settings';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'email_verification',
                  'kyc_verification',
                  'two_fa_verification',
                  'account_creation',
                  'user_deposit',
                  'user_withdraw',
                  'user_send_money',
                  'user_referral',
                  'signup_bonus',
                  'investment_referral_bounty',
                  'deposit_referral_bounty',
                  'site_animation',
                  'site_back_to_top',
                  'development_mode'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
               'email_verification' => 'boolean',
               'kyc_verification' => 'boolean',
               'two_fa_verification' => 'boolean',
               'account_creation' => 'boolean',
               'user_deposit' => 'boolean',
               'user_withdraw' => 'boolean',
               'user_send_money' => 'boolean',
               'user_referral' => 'boolean',
               'signup_bonus' => 'boolean',
               'investment_referral_bounty' => 'boolean',
               'deposit_referral_bounty' => 'boolean',
               'site_animation' => 'boolean',
               'site_back_to_top' => 'boolean',
               'development_mode' => 'boolean'
           ];
    



}
