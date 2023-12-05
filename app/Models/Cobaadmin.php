<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Cobaadmin extends Model
{
    use HasFactory;

    protected $table = 'cobaadmins';
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

            // Menghilangkan kolom timestamp dan id
            $columns = array_diff($columns, ['created_at', 'updated_at', 'id']);

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
