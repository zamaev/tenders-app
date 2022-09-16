<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Statuses;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use App\Exceptions\NotTenderFieldException;

class Tenders extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'number', 'status', 'status_id', 'name'];

    protected $updatable_fields = ['status_id'];

    public static function getTenders($params)
    {
        self::convertParams($params);

        if (isset($params['updated_at']) && !(int) date("His", strtotime($params['updated_at']))) {
            $date = date("Y-m-d", strtotime($params['updated_at']));
            unset($params['updated_at']);
            $tenders = self::query()->whereDate('updated_at', '=', $date)->where($params)->get()->toArray();
        } else {
            $tenders = self::where($params)->get()->toArray();
        }

        $statuses_names_by_ids = Statuses::getNamesByIds();
        foreach ($tenders as &$tender) {
            $tender['status'] = $statuses_names_by_ids[$tender['status_id']];
            unset($tender['status_id']);
        }
        return $tenders;
    }

    public static function createTender($params)
    {
        self::clearParams($params);
        return self::create($params)->changeStatusFormat();
    }

    public function updateTender($params, $tender)
    {
        self::convertParams($params);
        foreach ($params as $column => $v) {
            if (!in_array($column, $this->updatable_fields)) {
                return response()->json([
                    'message' => "Field '{$column}' cannot be updated'.",
                ], 406);
            }
        }
        $tender->update($params);
        return $tender->changeStatusFormat();
    }

    public function changeStatusFormat()
    {
        $statuses_names_by_ids = Statuses::getNamesByIds();
        $tender = $this->toArray();
        $tender['status'] = $statuses_names_by_ids[$tender['status_id']];
        unset($tender['status_id']);
        return $tender;
    }

    public static function convertParams(&$params)
    {
        if (isset($params['status'])) {
            if (!$status = Statuses::where(['name' => $params['status']])->get()->first()) {
                $status = Statuses::create(['name' => $params['status']]);
            }
            $params['status_id'] = $status->id;
            unset($params['status']);
        }
        self::clearParams($params);
        return $params;
    }

    public static function clearParams(&$params)
    {
        foreach ($params as $column => $v) {
            if (!Schema::hasColumn('tenders', $column) && $column !== 'status') {
                throw new NotTenderFieldException($column);
            }
        }
        if (isset($params['updated_at'])) {
            $params['updated_at'] = Carbon::createFromTimestamp(strtotime($params['updated_at']));
        }
    }

    protected static function booted()
    {
        static::creating(function (&$tender) {
            if (!$status = Statuses::where(['name' => $tender->status])->get()->first()) {
                $status = Statuses::create(['name' => $tender->status]);
            }
            $tender->status_id = $status->id;
            unset($tender->status);
        });
    }
}
