<?php

namespace App\Http\Requests\EventApplication;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['string'],
            'email' => ['email'],
            'phone' => ['string'],
            'gender' => ['string'],
            'birth_date' => ['numeric'],
            'job' => ['string'],
            'transportation' => ['string'],
            'tent' => ['numeric', 'nullable'],
            'sleeping_bag' => ['numeric', 'nullable'],
            'mat' => ['numeric', 'nullable'],
            'chair' => ['numeric', 'nullable'],
            'dont_camping_equipment' => ['boolean'],
            'share_telescope' => ['boolean', 'nullable'],
            'bring_telescope' => ['boolean', 'nullable'],
            'telescope' => ['numeric'],
            'telescope_brand' => ['string', 'nullable'],
            'swaddling' => ['numeric'],
            'swaddling_brand' => ['string', 'nullable'],
            'binocular' => ['numeric'],
            'camera' => ['numeric'],
            'tripod' => ['numeric'],
            'walkie_talkie' => ['numeric'],
            'computer' => ['numeric'],
            'participants' => ['array'],
            'participants.*.full_name' => ['string'],
            'participants.*.birth_date' => ['numeric'],
            'participants.*.gender' => ['string'],
            'arrival_date' => ['date'],
            'departure_date' => ['date'],
            'city_id' => ['exists:cities,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Ad soyad alanı gereklidir',
            'email.required' => 'E-posta alanı gereklidir',
            'gender.required' => 'Cinsiyet alanı gereklidir',
            'phone.required' => 'Telefon alanı gereklidir',
            'phone.string' => 'Telefon alanı bir string olmalıdır',
            'birth_date.required' => 'Doğum tarihi alanı gereklidir',
            'birth_date.numeric' => 'Doğum tarihi alanı bir sayı olmalıdır',
            'job.required' => 'İş alanı gereklidir',
            'job.string' => 'İş alanı bir string olmalıdır',
            'transportation.string' => 'Ulaşım alanı olmalıdır',
            'tent.numeric' => 'Çadır alanı bir sayı olmalıdır',
            'sleeping_bag.numeric' => 'Uyku tulumu alanı bir sayı olmalıdır',
            'mat.numeric' => 'Mat alanı bir sayı olmalıdır',
            'chair.numeric' => 'Sandalye alanı bir sayı olmalıdır',
            'dont_camping_equipment.boolean' => 'Kamp ekipmanı olmayanlar alanı bir boolean olmalıdır',
            'share_telescope.boolean' => 'Teleskop paylaşımı alanı bir boolean olmalıdır',
            'bring_telescope.boolean' => 'Teleskop getirme alanı bir boolean olmalıdır',
            'telescope.numeric' => 'Teleskop alanı bir sayı olmalıdır',
            'telescope_brand.string' => 'Teleskop markası alanı bir string olmalıdır',
            'swaddling.numeric' => 'Kundak bir sayı olmalıdır',
            'swaddling_brand.string' => 'Kundak markası alanı bir string olmalıdır',
            'binocular.numeric' => 'Dürbün alanı bir sayı olmalıdır',
            'camera.numeric' => 'Kamera alanı bir sayı olmalıdır',
            'tripod.numeric' => 'Tripod alanı bir sayı olmalıdır',
            'walkie_talkie.numeric' => 'Telsiz alanı bir sayı olmalıdır',
            'computer.numeric' => 'Bilgisayar alanı bir sayı olmalıdır',
            'participants.array' => 'Katılımcılar alanı bir dizi olmalıdır',
            'participants.*.full_name.required' => 'Katılımcıların ad soyad alanı gereklidir',
            'participants.*.full_name.string' => 'Katılımcıların ad soyad alanı bir string olmalıdır',
            'participants.*.birth_date.required' => 'Katılımcıların doğum tarihi alanı gereklidir',
            'participants.*.birth_date.numeric' => 'Katılımcıların doğum tarihi alanı bir sayı olmalıdır',
            'participants.*.gender.string' => 'Katılımcıların cinsiyet alanını seçiniz',
            'arrival_date.required' => 'Varış tarihi alanı gereklidir',
            'departure_date.required' => 'Ayrılış tarihi alanı gereklidir',
            'city_id.required' => 'Şehir alanı gereklidir',
        ];
    }
}
