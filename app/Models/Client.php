<?php

namespace App\Models;

use Database\Seeders\ClientSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Client extends Model
{
    use HasFactory;

    public function __construct()
    {
        $this->primaryKey = 'cliente_id';
        $this->table = env('CLIENT_TABLE_NAME');
        $this->fillable([
            'cliente_id',
            'cliente_nombre',
            'cliente_correo',
        ]);
    }

    protected static function createTable()
    {
        if(!Schema::hasTable(env('CLIENT_TABLE_NAME')))
        {
            Schema::create(env('CLIENT_TABLE_NAME'), function($table)
            {
                $table->id('cliente_id');
                $table->string('cliente_nombre', 250);
                $table->string('cliente_correo', 250)->nullable();
                $table->timestamps();
            });
            $seed = new ClientSeeder();
            $seed->run();
        }
    }

    public function toArray()
    {
        return [
            'cliente_id' => $this->cliente_id,
            'cliente_nombre' => $this->cliente_nombre,
            'cliente_correo' => $this->cliente_correo,
        ];
    }
}
