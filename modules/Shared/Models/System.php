<?php

namespace VuongCMS\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use VuongCMS\Shared\Models\Scopes\ActiveScope;

class System extends Model
{
    use HasFactory;

    protected $table = 'systems';

    protected $fillable = [
        'name',
        'username',
        'slug',
        'email',
        'cccd',
        'phone',
        'address',
        'logo',
        'token',
        'expired_in',
        'status',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function accounts() {
        return $this->hasMany(Account::class);
    }
}
