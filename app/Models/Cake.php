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

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

     /**
     * Get the email list for the cake.
     */
    public function emails()
    {
        return $this->hasMany(EmailInterestedCake::class, 'cake_id_fk', 'cake_id');
    }
}
