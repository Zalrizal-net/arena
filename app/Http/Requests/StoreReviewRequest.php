<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize()
    {
        // Pengecekan apakah user berhak memberikan review akan dilakukan di Service Layer
        return true;
    }

    public function rules()
    {
        return [
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            // Minimal 10 karakter untuk mencegah review spam seperti "ok", "sip"
            'comment'    => ['required', 'string', 'min:10', 'max:1000'],
            'images'     => ['nullable', 'array', 'max:5'], // Maksimal 5 foto per ulasan
            'images.*'   => ['image', 'mimes:jpeg,png,jpg', 'max:2048'], // Maksimal 2MB per foto
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'Mohon berikan rating bintang 1 sampai 5.',
            'rating.min'      => 'Rating minimal adalah 1 bintang.',
            'rating.max'      => 'Rating maksimal adalah 5 bintang.',
            'comment.required'=> 'Komentar ulasan wajib diisi.',
            'comment.min'     => 'Komentar ulasan minimal 10 karakter.',
            'images.max'      => 'Anda hanya dapat mengunggah maksimal 5 foto.',
            'images.*.image'  => 'File yang diunggah harus berupa gambar.',
            'images.*.max'    => 'Ukuran masing-masing foto tidak boleh lebih dari 2MB.',
        ];
    }
}