<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'ال :attribute يجب أن يكون مصفوفة.',
    'before' => 'يجب أن يكون التاريخ المدخل تاريخًا يسبق :date.',
    'before_or_equal' => 'يجب أن يكون التاريخ الذي تم إدخاله تاريخًا يسبق أو يساوي :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'يجب أن يكون حقل القيمة صحيحًا أو خطأ.',
    'confirmed' => 'تأكيد كلمة المرور غير متطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'التاريخ الذي تم إدخاله ليس تاريخًا صالحًا.',
    'date_equals' => 'يجب أن يكون التاريخ تاريخًا مساويًا لـ :date.',
    'date_format' => 'التاريخ لا يتطابق مع التنسيق: :format.',
    'declined' => 'يجب أن يتم رفض القيمة.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'يجب أن تكون القيمة والقيمة الأخرى مختلفة.',
    'digits' => 'يجب أن تكون القيمة مكونة من 9 أرقام.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'الصورة المحددة، أبعاد الصورة غير صالحة. ',
    'distinct' => ':attribute الحقل له قيمة مكررة.',
    'email' => 'البريد الالكتروني المدخل، يجب أن يكون عنوان بريد إلكتروني صالح.',
    'ends_with' => ':attribute يجب أن ينتهي بواحد مما يلي: :values.',
    'enum' => 'القيمة المحددة :attribute غير صحيحة.',
    'exists' => 'القيمة المحددة :attribute غير صحيحة.',
    'file' => 'ال :attribute يجب أن يكون ملفًا.',
    'filled' => ':attribute يجب أن يكون للحقل قيمة.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'يجب أن يكون الملف المحدد صورة.',
    'in' => 'القيمة المحددة :attribute غير صحيحة.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute يجب ألا يكون أكبر من :max.',
        'file' => ':attribute يجب ألا يكون أكبر من :max كيلوبايت.',
        'string' => ':attribute يجب ألا يكون أكبر من :max أحرف.',
        'array' => ':attribute يجب ألا يحتوي على أكثر من :max عناصر.',
    ],
    'min' => [
        'numeric' => ':attribute يجب أن يكون على الأقل :min.',
        'file' => ':attribute يجب أن يكون على الأقل :min كيلوبايت.',
        'string' => ':attribute يجب أن يكون على الأقل :min أحرف.',
        'array' => ':attribute يجب أن يحتوي على الأقل :min عناصر.',
    ],
    'mimes' => ':attribute يجب أن يكون ملفًا من النوع: :values.',
    'mimetypes' => ':attribute يجب أن يكون ملفًا من النوع: :values.',
    'multiple_of' => 'ال :attribute يجب أن يكون من مضاعفات :value.',
    'not_in' => 'القيمة المحددة :attribute غير صالح.',
    'not_regex' => ':attribute التنسيق غير صالح.',
    'numeric' => ':attribute يجب أن يكون رقما.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => ':attribute يجب أن يكون الحقل موجودًا. ',
    'prohibited' => ':attribute الحقل محظور. ',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => ':attribute التنسيق غير صالح.',
    'required' => ':attribute الحقل مطلوب.',
    'required_if' => 'الحقل :attribute مطلوب إذا كنت متزوج.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => ':attribute يجب أن يكون :size.',
        'file' => ':attribute يجب أن يكون أقل من :size كيلوبايت.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => ':attribute يجب أن يكون نصاً.',
    'timezone' => 'يجب أن تكون القيمة منطقة زمنية صالحة.',
    'unique' => 'ال :attribute تم استخدامه بالفعل.',
    'uploaded' => 'فشل تحميل الملف.',
    'url' => 'يجب أن تكون القيمة عنوان URL صالحًا.',
    'uuid' => 'يجب أن تكون القيمة UUID صالحة.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'الاسم',
        'first_name' => 'الاسم',
        'father_name' => 'اسم الأب',
        'grand_father_name' => 'اسم الجد',
        'surname' => 'الكنية',
        'job' => 'الوظيفة',
        'address' => 'العنوان',
        'mobile' => 'الجوال',
        'email' => 'البريد الالكتروني',
        'password' => 'كلمة المرور',
        'title' => 'العنوان',
        'body' => 'المحتوى',
        'bio' => 'المحتوى',
        'gender' => 'النوع',
        'birth_date' => 'تاريخ الميلاد',
        'birth_place' => 'مكان الوفاة',
        'death_date' => 'تاريخ الوفاة',
        'death_place' => 'مكان الوفاة',
        'image' => 'الصورة',
        'image_id' => 'الصورة',
        'husband' => 'الزوج',
        'husband_id' => 'الزوج',
        'wife' => 'الزوجة',
        'wife_id' => 'الزوجة',
        'partner_email' => "بريد الزوج/ة",
        'partner_first_name' => "اسم الزوج/ة",
        'partner_father_name' => "اسم اب الزوج/ة",
        'partner_mobile' => "رقم جوال الزوج/ة",
        'type' => 'النوع',
        'has_family' => 'الحالة الاجتماعية',
        'mother' => 'الأم',
        'mother_id' => 'الأم',
        'father' => 'الأب',
        'father_id' => 'الأب',
        'is_live' => 'الحالة',
    ],

];
