<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guarantees extends Model
{
    use HasFactory;

    protected $fillable = [
        'corporate_reference_number',
        'guarantee_type',
        'nominal_amount',
        'nominal_amount_currency',
        'expiry_date',
        'applicant_name',
        'applicant_address',
        'beneficiary_name',
        'beneficiary_address',
        'status',
        'created_at',
        'updated_at'
    ];

    public static $rules = [
        'corporate_reference_number' => 'required|unique:guarantees',
        'guarantee_type' => 'required',
        'nominal_amount' => 'required|numeric',
        'nominal_amount_currency' => 'required',
        'expiry_date' => 'required|date|after_or_equal:today',
        'applicant_name' => 'required',
        'applicant_address' => 'required',
        'beneficiary_name' => 'required',
        'beneficiary_address' => 'required',
    ];

    protected $primaryKey = 'corporate_reference_number';
}

