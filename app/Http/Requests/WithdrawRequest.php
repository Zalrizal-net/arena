<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan hanya user yang sudah login yang bisa melakukan request ini
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:50000',
            'bank_name' => 'required|string|max:100',
            'account_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Minimal penarikan dana adalah Rp 50.000.',
            'amount.required' => 'Nominal penarikan wajib diisi.',
            'bank_name.required' => 'Nama bank wajib diisi.',
            'account_name.required' => 'Nama pemilik rekening wajib diisi.',
            'account_number.required' => 'Nomor rekening wajib diisi.',
        ];
    }
}