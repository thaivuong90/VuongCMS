<?php

namespace VuongCMS\Common\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    const DISABLE = 0;
    const ENABLE = 1;
    const NOT_CONFIRM = 2;

    protected $table = 'systems';

    protected $fillable = [
        'name',
        'username',
        'url',
        'email',
        'cccd',
        'phone',
        'expired_in',
        'status'
    ];

    public function accounts() {
        return $this->hasMany(Account::class);
    }
}
