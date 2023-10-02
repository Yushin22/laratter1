<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundColor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function up()
    {
        DB::table('background_colors')->insert([
            ['name' => '赤', 'code' => '#FF0000'],
            ['name' => '青', 'code' => '#0000FF'],
            ['name' => '緑', 'code' => '#00FF00'],
            ['name' => '黄色', 'code' => '#FFFF00'],
            ['name' => 'ピンク', 'code' => '#FFC0CB']
        ]);
    }
}

