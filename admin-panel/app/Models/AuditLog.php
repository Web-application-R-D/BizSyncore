<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'target_type',
        'target_id',
        'target_name',
        'change_detail',
        'ip_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(
        string $action,
        string $targetType,
        int $targetId,
        string $targetName,
        string $changeDetail
    ): void {
        static::create([
            'user_id'       => auth()->id(),
            'action'        => $action,
            'target_type'   => $targetType,
            'target_id'     => $targetId,
            'target_name'   => $targetName,
            'change_detail' => $changeDetail,
            'ip_address'    => request()->ip(),
        ]);
    }
}
