<?php

namespace App\Models;

use Illuminate\Support\ServiceProvider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registraseferia extends Model
{
    protected static function boot()
    {
        parent::boot();

        // Desactiva los timestamps
        static::saving(function ($model) {
            $model->timestamps = false;
        });
    
        // Establece la fecha automáticamente
        static::creating(function ($model) {
            $model->fecha = now();
        });
        
    
    }
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registraseferia';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'clave_registro';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clave_feria',
        'curp',
        'fecha',
        'medio',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha',
    ];

}
