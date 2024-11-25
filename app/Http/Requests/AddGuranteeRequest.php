<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddGuranteeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'guarantee_type' => 'required',
            'nominal_amount' => 'required',
            'nominal_amount_currency' => 'required',
            'expiry_date' => 'required',
            'applicant_name' => 'required',
            'applicant_address' => 'required',
            'beneficiary_name' => 'required',
            'beneficiary_address' => 'required',
        
        ];
    }
    
       public function messages() {
        return [
            'guarantee_type.required' => 'Guarantee Type field is required.',
            'nominal_amount.required' => 'Nominal Amount field is required.',
            'nominal_amount_currency.required' => 'Nominal Amount Currency field is required.',
            'expiry_date.required' => 'Expiry Date field is required.',
            'applicant_name.required' => 'Applicant Name field is required.',
            'applicant_address.required' => 'Applicant Address field is required.',
            'beneficiary_name.required' => 'Beneficiary Name field is required.',
            'beneficiary_address.required' => 'Beneficiary Address field is required.',
        ];
    }
}
