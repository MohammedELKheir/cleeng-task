<?php

namespace App\Domain\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Statistic
 * @package App\Domain\Model
 */
class Statistic extends Model
{
    /**
     * @var string
     */
    protected $table = 'Statistics';
    /**
     * @var array
     */
    protected $fillable = ['name','value','statistic','type','service'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'created_at',
    ];}