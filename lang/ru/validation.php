<?php

return [

    'accept' => 'Поле \':attribute\' должен быть принят.',
    'active_url' => 'Поле \':attribute\' не является допустимым URL.',
    'after' => 'Поле \':attribute\' должен быть датой после :date.',
    'after_' => 'Поле \':attribute\' должно быть датой после \':date\'.',
    'after_or_equal' => 'Поле \':attribute\' должен быть датой после или равной дате.',
    'alpha' => 'Поле \':attribute\' может содержать только буквы.',
    'alpha_dash' => 'Поле \':attribute\' может содержать только буквы, цифры, дефисы и подчеркивания.',
    'alpha_num' => 'Поле \':attribute\' может содержать только буквы и цифры.',
    'array' => 'Поле \':attribute\' должен быть массивом.',
    'before' => 'Поле \':attribute\' должен быть датой до :date.',
    'before_' => 'Поле \':attribute\' должно быть датой до \':date\'.',
    'before_or_equal' => 'Поле \':attribute\' должен быть датой до или равной дате.',
    'between' => [
        'numeric' => 'Поле \':attribute\' должен находиться между :min и :max.',
        'file' => 'Поле \':attribute\' должен находиться в диапазоне от :min до :max килобайт.',
        'string' => 'Поле \':attribute\' должен быть между: min и :max символами.',
        'array' => 'Поле \':attribute\' должен иметь от :min до :max элементов.',
    ],
    'boolean' => 'Поле \':attribute\' должно быть истинным или ложным.',
    'confirmed' => 'Введенные значения не совпадают',
    'verified' => 'подтверждение \':attribute\' не совпадает.',
    'date' => 'Поле \':attribute\' не является допустимой датой.',
    'date_equals' => 'Поле \':attribute\' должен быть датой, равной :date.',
    'date_format' => 'Поле \':attribute\' не соответствует формату :format.',
    'different' => 'Значения поля \':attribute\' и поля \':other\' должны быть разными.',
    'digits' => 'Поле \':attribute\' должен быть :digits .',
    'digits_between' => 'Поле \':attribute\' должен быть между :min и :max цифрами.',
    'sizes' => 'Поле \':attribute\' имеет недопустимые размеры изображения.',
    'independent' => 'Поле \':attribute\' имеет повторяющееся значение.',
    'email' => 'Некорректная электронная почта',
    'ends_with' => 'Поле \':attribute\' должен заканчиваться одним из following: :values.',
    'exists' => 'Выбранный \':attribute\' не существует.',
    'file' => 'Поле \':attribute\' должен быть файлом.',
    'fill' => 'Поле \':attribute\' должно иметь значение.',
    'gt' => [
        'numeric' => 'Поле \':attribute\' должен быть больше, чем :value.',
        'file' => 'Поле \':attribute\' должен быть больше, чем :value kilobytes.',
        'string' => 'Поле \':attribute\' должен быть больше символов :value characters.',
        'array' => 'Поле \':attribute\' должен иметь более :value items.',
    ],
    'gte' => [
        'numeric' => 'Поле \':attribute\' должен быть больше или равен :value.',
        'file' => 'Поле \':attribute\' должен быть больше или равен :value kilobytes.',
        'string' => 'Поле \':attribute\' должен содержать больше или равно :value characters.',
        'array' => 'Поле \':attribute\' должен иметь :value элементов или более.',
    ],
    'image' => 'Поле \':attribute\' должен быть изображением.',
    'in' => 'Поле \':attribute\' может содержать только: :values.',
    'in_array' => 'Поле \':attribute\' не существует в :other.',
    'integer' => 'Поле должно быть целым числом.',
    'ip' => 'Поле \':attribute\' должен быть действительным IP-адресом.',
    'ipv4' => 'Поле \':attribute\' должен быть действительным адресом IPv4.',
    'ipv6' => 'Поле \':attribute\' должен быть действительным IPv6-адресом.',
    'json' => 'Поле \':attribute\' должен быть допустимой строкой JSON.',
    'lt' => [
        'numeric' => 'Поле \':attribute\' должен быть меньше :value.',
        'file' => 'Поле \':attribute\' должен быть меньше :value килобайт.',
        'string' => 'Поле \':attribute\' должен содержать меньше символов: value.',
        'array' => 'Поле \':attribute\' должен содержать меньше: значений элементов.',
    ],
    'lte' => [
        'numeric' => 'Поле \':attribute\' должен быть меньше или равен :value.',
        'file' => 'Поле \':attribute\' должен быть меньше или равен :value kilobytes.',
        'string' => 'Поле \':attribute\' должен быть меньше или равен :value characters.',
        'array' => 'Поле \':attribute\' не может содержать более :value items.',
    ],
    'max' => [
        'numeric' => 'Поле \':attribute\' не может быть больше, чем :max.',
        'file' => 'Поле \':attribute\' не может быть больше :max килобайтов.',
        'string' => 'Поле не может быть больше, чем :max символов.',
        'array' => 'Поле \':attribute\' не может содержать более :max элементов.',
    ],
    'mimes' => 'Поле \':attribute\' должен быть файлом типа :values.',
    'mimetypes' => 'Поле \':attribute\' должен быть файлом типа :values.',
    'min' => [
        'numeric' => 'Поле \':attribute\' должен быть не меньше :min.',
        'file' => 'Поле \':attribute\' должен быть не меньше :min kilobytes.',
        'string' => 'Поле \':attribute\' должен содержать не менее :min characters.',
        'array' => 'Поле \':attribute\' должен содержать как минимум: :min items.',
    ],
    'not_in' => 'Поле \':attribute\' не может содержать: :values.',
    'not_regex' => 'Поле \':attribute\' содержит недопустимый формат.',
    'numeric' => 'Поле \':attribute\' должно быть числом.',
    'password' => 'Неверный пароль.',
    'present' => 'Поле \':attribute\' должно присутствовать.',
    'regex' => 'Поле \':attribute\' имеет недействительный формат.',
    'required' => 'Поле обязательно для заполнения',
    'required_if' => 'Поле \':attribute\' необходимо, когда поле \':other\' равно :value.',
    'required_unless' => 'Поле \':attribute\' является обязательным, если \':other\' не содержит значения: :values.',
    'required_with' => 'Поле \':attribute\' обязательно, если присутствует :values.',
    'required_with_all' => 'Поле \':attribute\' необходимо, если :values указано.',
    'required_without' => 'Поле \':attribute\' необходимо, если поле \':values\' не указано.',
    'required_without_all' => 'Поле \':attribute\' является обязательным, если ни одно из :values не присутствует.',
    'same' => 'Поле \':attribute\' и \':other\' должны совпадать.',
    'size' => [
        'numeric' => 'Поле \':attribute\' должен быть :size.',
        'file' => 'Поле \':attribute\' должен быть :size в килобайтах.',
        'string' => 'Поле \':attribute\' должен содержать количество символов: :size',
        'array' => 'Поле \':attribute\' должен содержать элементы :size.',
    ],
    'start_with' => 'Поле \':attribute\' должен начинаться с одного из следующих :values.',
    'string' => 'Поле \':attribute\' должен быть строкой.',
    'timezone' => 'Поле \':attribute\' должен быть допустимой зоной.',
    'unique' => 'Значение поля \':attribute\' уже занято.',
    'unique_with_deleted' => 'Значение поля \':attribute\' уже занято.',
    'uploaded' => 'Поле \':attribute\' не удалось загрузить.',
    'url' => 'Поле \':attribute\' содержит недопустимый формат.',
    'uuid' => 'Поле \':attribute\' должен быть действительным UUID.',
    'the_name_can_only_contain_latin_characters_and_numbers' => 'Поле \':attribute\' может содержать только латинские символы и цифры',
    'the_name_cant_contain_cyrillic_symbols' => 'Поле \':attribute\' не может содержать кириллицу',


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

    'attributes' => [],

];
