<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasUuids;
    protected $fillable =["auditor", "organization_id", "accounts"];
    public function organziation(){
        return $this->belongsTo(Organization::class);
    }
}
