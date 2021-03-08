<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BouquetTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'bank_account_id', 'user_id', 'bouquet_id', 'transformer_name', 'transformer_mobile_code', 'transformer_mobile',
        'date', 'reason', 'reference_number', 'image', 'status'
    ];

    protected $table = 'bouquet_transactions';

    public $timestamps = true;

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bouquet()
    {
        return $this->belongsTo(Bouquet::class);
    }
}
