<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BankAccount extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'iban', 'bank_name', 'account_name', 'account_no', 'logo'
    ];

    protected $table = 'bank_accounts';

    public $timestamps = true;

    public function getLogoAttribute()
    {
        return $this->getFirstMediaUrl('bankLogo') ?
            $this->getFirstMediaUrl('bankLogo'): null;
    }

    public function offerTransaction()
    {
        return $this->hasMany(OfferTransaction::class, 'bank_account_id');
    }

    public function bouquetTransaction()
    {
        return $this->hasMany(BouquetTransaction::class, 'bank_account_id');
    }
}
