<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenders extends Model
{
    use HasFactory;

    public function get_data_json($filter)
    {
        return $this->data_preparation(self::where($filter)->get());
    }

    public function data_preparation($rows)
    {
        $name_matching = [
            'code' => 'Внешний код',
            'number' => 'Номер',
            'name' => 'Название',
            'status' => 'Статус',
            'updated_at' => 'Дата изм.',
        ];

        $data = [];
        foreach ($rows as $row) {
            $new_row = [];
            foreach ($row->attributes as $column => $value) {
                if (isset($name_matching[$column])) {
                    $new_row[$name_matching[$column]] = $value;
                }
            }
            $data[] = $new_row;
        }
        return json_encode(['tenders' => $data]);
    }
}
