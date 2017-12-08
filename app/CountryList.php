<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryList extends Model
{
    public function apiGetCurrency($countryName)
    {
    	$currency = $this->whereCountry($countryName)->first();
    	return $currency;
    }
}
