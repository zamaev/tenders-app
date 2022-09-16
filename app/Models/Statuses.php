<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    private static $namesByIds;

    public static function getNamesByIds()
    {
        if (self::$namesByIds) {
            return self::$namesByIds;
        }
        $statuses = self::all()->toArray();
        $format_statuses = [];
        foreach ($statuses as $status) {
            $format_statuses[$status['id']] = $status['name'];
        }
        return $format_statuses;
    }
}
