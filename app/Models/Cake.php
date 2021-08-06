<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cake extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cake';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cake_id';

    protected $guarded = [];

}
