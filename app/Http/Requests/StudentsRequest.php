<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StudentsRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required|mimes:png,jpg,jepeg',
        ];
    }
    // $imagePath=$image->storeAs('images',$imageName,'public');
    // dd(request()->file('image'),$this->image);
    public function sanitized()
    {

        // dd($imagePath);
        return [
            'slug' => Str::slug($this->name, "_"),
            'name' => $this->name,
            'email' => $this->email,
            //  
        ];
    }
}
// $hashedName=$this->image->hashName();
// $this->image->move(public_path("images/",$hashedName));
