<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact_no',
        'status',
        'login_attempts',
        'role_id',
        'avatar',
        'code',
        'created_by',
        'parent_id',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function hasRole($role)
    {
        $role = $this->roles->where('name', $role)->first();
        return $role ? true :false;
    }

    public function getAll($search=null, $filter=null, $currentPage=null)
    {
        $users = User::with('roles')
            ->when(isset($filter), function ($query) use($filter){
                $query->whereStatus($filter);
            })
            ->when(isset($search) && $search != "", function ($query) use($search) {
                $query->where('name', 'LIKE',  $search . '%')
                        ->orWhere('email', 'LIKE',  $search . '%')
                        ->orWhere('contact_no', 'LIKE',  $search . '%');
            })
            ->where('id', '!=', Auth::id())
            ->paginate(5);

        return $users;
    }

    public function totalUsers()
    {
        return $this->count();
    }
}
