<?php
namespace App\Admin\Transactions;
use Illuminate\Database\Eloquent\Model;
class OfferTransaction extends Model
{
    protected $fillable = [
        'bank_account_id', 'user_id', 'offer_id', 'transformer_name', 'transformer_mobile_code', 'transformer_mobile',
        'date', 'reason', 'reference_number', 'image'
    ];

    protected $table = 'offer_transactions';

    public $timestamps = true;

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}