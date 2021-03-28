<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'slug', 'name', 'description'
    ];

    public function getAll($search=null, $filter=null, $currentPage=null)
    {
        $users = self::when(isset($search) && $search != "", function ($query) use($search) {
                $query->where('name', 'LIKE',  $search . '%')
                    ->orWhere('slug', 'LIKE',  $search . '%');
            })
            ->paginate(25);

        return $users;
    }

    public function totalRoles()
    {
        return self::count();
    }
}
