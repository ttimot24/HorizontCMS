<?php

namespace App\Model;

use \Illuminate\Database\Eloquent\Model;

class ScheduledTask extends Model {

    protected $table = 'schedules';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'command', 'arguments', 'frequency', 'ping_before', 'ping_after' , 'active',
    ];

}
