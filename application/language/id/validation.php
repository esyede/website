<?php

defined('DS') or exit('No direct script access.');

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used
    | by the validator class. Some of the rules contain multiple versions,
    | such as the size (max, min, between) rules. These versions are used
    | for different input types such as strings and files.
    |
    | These language lines may be easily changed to provide custom error
    | messages in your application. Error messages for custom validation
    | rules may also be added to this file.
    |
    */

    'accepted' => 'Bilah :attribute harus disetujui.',
    'active_url' => 'Bilah :attribute bukan URL yang valid.',
    'after' => 'Bilah :attribute harus tanggal setelah :date.',
    'alpha' => 'Bilah :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Bilah :attribute hanya boleh berisi huruf, angka, dan strip.',
    'alpha_num' => 'Bilah :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Bilah :attribute harus memiliki elemen yang dipilih.',
    'ascii' => 'Bilah :attribute mengandung karakter non-ASCII.',
    'before' => 'Bilah :attribute harus tanggal sebelum :date.',
    'before_or_equals' => 'Bilah :attribute harus diisi tanggal sebelum atau tepat :date.',
    'between' => [
        'numeric' => 'Bilah :attribute harus antara :min - :max.',
        'file' => 'Bilah :attribute harus antara :min - :max kilobytes.',
        'string' => 'Bilah :attribute harus antara  :min - :max karakter.',
    ],
    'boolean' => 'Bilah :attribute harus diisi dengan nilai boolean.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'count' => 'Bilah :attribute harus memiliki tepat :count elemen.',
    'countbetween' => 'Bilah :attribute harus diantara :min dan :max elemen.',
    'countmax' => 'Bilah :attribute harus lebih kurang dari :max elemen.',
    'countmin' => 'Bilah :attribute harus paling sedikit :min elemen.',
    'different' => 'Bilah :attribute dan :other harus berbeda.',
    'email' => 'Format isian :attribute tidak valid.',
    'exists' => 'Bilah :attribute yang dipilih tidak valid.',
    'image' => ':attribute harus berupa gambar.',
    'in' => 'Bilah :attribute yang dipilih tidak valid.',
    'integer' => 'Bilah :attribute harus merupakan bilangan.',
    'ip' => 'Bilah :attribute harus alamat IP yang valid.',
    'match' => 'Format isian :attribute tidak valid.',
    'max' => [
        'numeric' => 'Bilah :attribute harus kurang dari :max.',
        'file' => 'Bilah :attribute harus kurang dari :max kilobytes.',
        'string' => 'Bilah :attribute harus kurang dari :max karakter.',
    ],
    'mimes' => 'Bilah :attribute harus dokumen berjenis : :values.',
    'min' => [
        'numeric' => 'Bilah :attribute harus minimal :min.',
        'file' => 'Bilah :attribute harus minimal :min kilobytes.',
        'string' => 'Bilah :attribute harus minimal :min karakter.',
    ],
    'not_in' => 'Bilah :attribute yang dipilih tidak valid.',
    'numeric' => 'Bilah :attribute harus berupa angka.',
    'required' => 'Bilah :attribute wajib diisi.',
    'same' => 'Bilah :attribute dan :other harus sama.',
    'size' => [
        'numeric' => 'Bilah :attribute harus berukuran :size.',
        'file' => 'Bilah :attribute harus berukuran :size kilobyte.',
        'string' => 'Bilah :attribute harus berukuran :size karakter.',
    ],
    'unique' => 'Bilah :attribute sudah ada sebelumnya.',
    'url' => 'Format bilah :attribute tidak valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention 'attribute_rule' to name the lines. This helps keep your
    | custom validation clean and tidy.
    |
    | So, say you want to use a custom validation message when validating that
    | the 'email' attribute is unique. Just add 'email_unique' to this array
    | with your custom message. The Validator will handle the rest!
    |
    */

    'custom' => [],

    /*
    |--------------------------------------------------------------------------
    | Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as 'E-Mail Address' instead
    | of 'email'. Your users will thank you.
    |
    | The Validator class will automatically search this array of lines it
    | is attempting to replace the :attribute place-holder in messages.
    | It's pretty slick. We think you'll like it.
    |
    */

    'attributes' => [],

];
