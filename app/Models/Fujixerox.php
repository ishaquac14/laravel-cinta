<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Fujixerox extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Otomatis tambahkan kolom-kolom dari tabel ke fillable
        $this->fillable = $this->getTableColumns();
    }

    /**
     * Mendapatkan nama-nama kolom dari tabel.
     *
     * @return array
     */
    protected function getTableColumns()
    {
        $table = $this->getTable();

        try {
            $columns = DB::getSchemaBuilder()->getColumnListing($table);
            return $columns;
        } catch (\Throwable $th) {
            // Tampilkan pesan kesalahan jika diperlukan
            dd($th->getMessage());
        }

    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
