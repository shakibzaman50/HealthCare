<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mail_settings';

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
                  'email_from_name',
                  'email_from_address',
                  'mailing_driver',
                  'mail_user_name',
                  'mail_password',
                  'smpt_host',
                  'smpt_port',
                  'smtp_secure'
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
    protected $casts = [];
    



}
