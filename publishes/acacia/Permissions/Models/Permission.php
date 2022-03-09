<?php

namespace Acacia\Permissions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Acacia\Permissions\Database\Factories\PermissionFactory;
use Laravel\Scout\Searchable;

class Permission extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ["name", "guard_name"];
    protected $hidden = [];

    protected static function newFactory(): PermissionFactory
    {
        return PermissionFactory::new();
    }
    /********* BELONGS TO **********/

    /********* MORPH TO **********/

    public function toSearchableArray(): array
    {
        return $this->only($this->getFillable());
    }
}
