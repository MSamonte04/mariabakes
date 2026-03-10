<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'first_name','last_name','phone','email','facebook','instagram',
        'order_type','address','delivery_app',
        'notes','items','total','status',
    ];
    protected $casts = ['items' => 'array', 'total' => 'decimal:2'];

    public function getFullNameAttribute(): string { return "{$this->first_name} {$this->last_name}"; }

    public function getStatusColorAttribute(): string {
        return match($this->status) {
            'pending'   => '#f59e0b',
            'confirmed' => '#3b82f6',
            'ready'     => '#8b5cf6',
            'completed' => '#22c55e',
            'cancelled' => '#ef4444',
            default     => '#6b7280',
        };
    }

    public function getItemsSummaryAttribute(): string {
        if (!$this->items) return '—';
        return collect($this->items)->map(fn($i) => "{$i['name']} ×{$i['qty']}")->join(', ');
    }
}
