<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Call extends Model
{
    use HasFactory;

    protected $primaryKey = 'llamada_id';

    public function __construct()
    {
        $this->primaryKey = 'llamada_id';
        $this->table = env('CALL_TABLE_NAME');
        $this->fillable([
            'cliente_id',
            'user_id',
            'llamada_telefono',
            'llamada_fecha',
            'llamada_observacion',
        ]); 
    }

    protected static function createTable()
    {
        if(!Schema::hasTable(env('CALL_TABLE_NAME')))
        {
            Schema::create(env('CALL_TABLE_NAME'), function($table)
            {
                $table->id('llamada_id');
                $table->unsignedBigInteger('cliente_id');
                $table->unsignedBigInteger('user_id');
                $table->string('llamada_telefono', 250);
                $table->dateTime('llamada_fecha');
                $table->text('llamada_observacion');
                $table->timestamps();
                
                $table->foreign('cliente_id')->references('cliente_id')->on(env('CLIENT_TABLE_NAME'))->onUpdate('RESTRICT')->onDelete('RESTRICT');
                $table->foreign('user_id')->references('id')->on(env('USERS_TABLE_NAME'))->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });
        }
    }

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function clients()
    {
        return $this->hasOne(Client::class, 'cliente_id');
    }

    public function toArray()
    {
        return [
            'id' => $this->llamada_id,
            'client' => $this->clients,
            'user' => $this->users,
            'llamada_fecha' => $this->llamada_fecha,
            'llamada_telefono' => $this->llamada_telefono,
            'llamada_observacion' => $this->llamada_observacion,
        ];
    }
}
