<?php

namespace Kartikey\PanelPulse\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public function orders_customers()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

        /**
     * Order Status
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PENDING_PAYMENT = 'pending_payment';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_FRAUD = 'fraud';
    public const STATUS_COD_CONFIRED = 'Cod Confirmed';
    public const STATUS_COD_PENDING_VERIFICATION = 'cod_pending_verification';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_RETURNED = 'returned';
    public const STATUS_RETURN_IN_PROCESS = 'return_in_process';
    public const STATUS_RETURN_REQUESTED = 'return_requested';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_PAYMENT_RECEIVED = 'payment_received';
    public const STATUS_ON_HOLD = 'on_hold';
    public const STATUS_PAYMENT_FAILED = 'payment_failed';

    protected $statusLabel = [
        self::STATUS_PENDING                    => 'Pending',
        self::STATUS_PENDING_PAYMENT            => 'Pending Payment',
        self::STATUS_PROCESSING                 => 'Processing',
        self::STATUS_COMPLETED                  => 'Completed',
        self::STATUS_CANCELED                   => 'Canceled',
        self::STATUS_CLOSED                     => 'Closed',
        self::STATUS_FRAUD                      => 'Fraud',
        self::STATUS_COD_CONFIRED               => 'Cod Confirmed',
        self::STATUS_COD_PENDING_VERIFICATION   => 'Cod Pending Verification',
        self::STATUS_REJECTED                   => 'Rejected',
        self::STATUS_FAILED                     => 'Failed',
        self::STATUS_CANCELLED                  => 'Cancelled',
        self::STATUS_REFUNDED                   => 'Refunded',
        self::STATUS_RETURNED                   => 'Returned',
        self::STATUS_RETURN_IN_PROCESS          => 'Return In Process',
        self::STATUS_RETURN_REQUESTED           => 'Return Requested',
        self::STATUS_DELIVERED                  => 'Delivered',
        self::STATUS_OUT_FOR_DELIVERY           => 'Out For Delivery',
        self::STATUS_SHIPPED                    => 'Shipped',
        self::STATUS_CONFIRMED                  => 'Confirmed',
        self::STATUS_PAYMENT_RECEIVED           => 'Payment Paid',
        self::STATUS_ON_HOLD                    => 'On Hold',
        self::STATUS_PAYMENT_FAILED             => 'Payment Failed',
    ];

    public function getStatusLabel()
    {
        return $this->statusLabel[$this->status] ?? null;
    }

    /**
     * Get the payment for the order.
     */
    public function payment()
    {
        return $this->hasOne(OrderPayment::class);
    }


    public function shippments()
    {
        return $this->hasMany(OrderShippment::class);
    }

    /**
     * Get the addresses for the order.
    */
    public function addresses()
    {
        return $this->hasOne(OrderAddress::class);
    }

    public function orderVendors()
    {
        return $this->hasMany(OrderVendor::class, 'order_id');
    }
}
