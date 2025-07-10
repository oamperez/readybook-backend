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

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'active_url'           => 'El campo :attribute no es una URL válida.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El campo :attribute solo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => 'El campo :attribute solo puede contener letras y números.',
    'array'                => 'El campo :attribute debe ser un array.',
    'before'               => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El campo :attribute debe ser un valor entre :min y :max.',
        'file'    => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute debe contener entre :min y :max caracteres.',
        'array'   => 'El campo :attribute debe contener entre :min y :max elementos.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El campo confirmación de :attribute no coincide.',
    'date'                 => 'El campo :attribute no corresponde con una fecha válida.',
    'date_equals'          => 'El campo :attribute debe ser una fecha igual a :date.',
    'date_format'          => 'El campo :attribute no corresponde con el formato de fecha :format.',
    'different'            => 'Los campos :attribute y :other deben ser diferentes.',
    'digits'               => 'El campo :attribute debe ser un número de :digits dígitos.',
    'digits_between'       => 'El campo :attribute debe contener entre :min y :max dígitos.',
    'dimensions'           => 'El campo :attribute tiene dimensiones de imagen inválidas.',
    'distinct'             => 'El campo :attribute tiene un valor duplicado.',
    'email'                => 'El campo :attribute debe ser una dirección de correo válida.',
    'ends_with'            => 'El campo :attribute debe finalizar con alguno de los siguientes valores: :values',
    'exists'               => 'El campo :attribute seleccionado no existe.',
    'file'                 => 'El campo :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute debe tener un valor.',
    'gt'                   => [
        'numeric' => 'El campo :attribute debe ser mayor a :value.',
        'file'    => 'El archivo :attribute debe pesar más de :value kilobytes.',
        'string'  => 'El campo :attribute debe contener más de :value caracteres.',
        'array'   => 'El campo :attribute debe contener más de :value elementos.',
    ],
    'gte'                  => [
        'numeric' => 'El campo :attribute debe ser mayor o igual a :value.',
        'file'    => 'El archivo :attribute debe pesar :value o más kilobytes.',
        'string'  => 'El campo :attribute debe contener :value o más caracteres.',
        'array'   => 'El campo :attribute debe contener :value o más elementos.',
    ],
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'El campo :attribute es inválido.',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El campo :attribute debe ser un número entero.',
    'ip'                   => 'El campo :attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'El campo :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El campo :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El campo :attribute debe ser una cadena de texto JSON válida.',
    'lt'                   => [
        'numeric' => 'El campo :attribute debe ser menor a :value.',
        'file'    => 'El archivo :attribute debe pesar menos de :value kilobytes.',
        'string'  => 'El campo :attribute debe contener menos de :value caracteres.',
        'array'   => 'El campo :attribute debe contener menos de :value elementos.',
    ],
    'lte'                  => [
        'numeric' => 'El campo :attribute debe ser menor o igual a :value.',
        'file'    => 'El archivo :attribute debe pesar :value o menos kilobytes.',
        'string'  => 'El campo :attribute debe contener :value o menos caracteres.',
        'array'   => 'El campo :attribute debe contener :value o menos elementos.',
    ],
    'max'                  => [
        'numeric' => 'El campo :attribute no debe ser mayor a :max.',
        'file'    => 'El archivo :attribute no debe pesar más de :max kilobytes.',
        'string'  => 'El campo :attribute no debe contener más de :max caracteres.',
        'array'   => 'El campo :attribute no debe contener más de :max elementos.',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'file'    => 'El archivo :attribute debe pesar al menos :min kilobytes.',
        'string'  => 'El campo :attribute debe contener al menos :min caracteres.',
        'array'   => 'El campo :attribute debe contener al menos :min elementos.',
    ],
    'not_in'               => 'El campo :attribute seleccionado es inválido.',
    'not_regex'            => 'El formato del campo :attribute es inválido.',
    'numeric'              => 'El campo :attribute debe ser un número.',
    'password'             => 'La contraseña es incorrecta.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El formato del campo :attribute es inválido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute es obligatorio cuando el campo :other es :value.',
    'required_unless'      => 'El campo :attribute es requerido a menos que :other se encuentre en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values están presentes.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de los campos :values están presentes.',
    'same'                 => 'Los campos :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'file'    => 'El archivo :attribute debe pesar :size kilobytes.',
        'string'  => 'El campo :attribute debe contener :size caracteres.',
        'array'   => 'El campo :attribute debe contener :size elementos.',
    ],
    'starts_with'          => 'El campo :attribute debe comenzar con uno de los siguientes valores: :values',
    'string'               => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone'             => 'El campo :attribute debe ser una zona horaria válida.',
    'unique'               => 'El valor del campo :attribute ya está en uso.',
    'uploaded'             => 'El campo :attribute no se pudo subir.',
    'url'                  => 'El formato del campo :attribute es inválido.',
    'uuid'                 => 'El campo :attribute debe ser un UUID válido.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        // Datos personales
        'first_name' => 'nombre',
        'last_name' => 'apellido',
        'email' => 'correo electrónico',
        'phone' => 'teléfono',
        'password' => 'contraseña',
        'name' => 'nombre',
        
        // Configuración de correo
        'MAIL_MAILER' => 'servicio de correo',
        'MAIL_HOST' => 'servidor de correo',
        'MAIL_USERNAME' => 'usuario de correo',
        'MAIL_PASSWORD' => 'contraseña de correo',
        'MAIL_ENCRYPTION' => 'encriptación de correo',
        'MAIL_FROM_ADDRESS' => 'correo remitente',
        'MAIL_FROM_NAME' => 'nombre del remitente',
        
        // Configuración de aplicación
        'app_name' => 'nombre de la aplicación',
        'file' => 'archivo',
        
        // Horarios
        'start_time' => 'hora de inicio',
        'end_time' => 'hora de fin',
        'date' => 'fecha',
        
        // Estados y razones
        'state' => 'estado',
        'reason' => 'razón',
        
        // Proceso por pasos
        'step' => 'paso',
        'category_id' => 'categoría',
        'schedule_id' => 'horario',
        'detail' => 'detalle',
        
        // Otros campos comunes que podrías necesitar
        'title' => 'título',
        'description' => 'descripción',
        'content' => 'contenido',
        'address' => 'dirección',
        'city' => 'ciudad',
        'country' => 'país',
        'zip_code' => 'código postal',
        'birth_date' => 'fecha de nacimiento',
        'age' => 'edad',
        'gender' => 'género',
        'company' => 'empresa',
        'position' => 'cargo',
        'website' => 'sitio web',
        'image' => 'imagen',
        'avatar' => 'avatar',
        'status' => 'estado',
        'active' => 'activo',
        'created_at' => 'fecha de creación',
        'updated_at' => 'fecha de actualización',
        'username' => 'nombre de usuario',
        'terms' => 'términos y condiciones',
        'privacy' => 'política de privacidad',
        'message' => 'mensaje',
        'subject' => 'asunto',
        'comment' => 'comentario',
        'rating' => 'calificación',
        'time' => 'hora',
        'start_date' => 'fecha de inicio',
        'end_date' => 'fecha de fin',
        'type' => 'tipo',
        'size' => 'tamaño',
        'color' => 'color',
        'price' => 'precio',
        'quantity' => 'cantidad',
        'total' => 'total',
        'discount' => 'descuento',
        'tax' => 'impuesto',
        'notes' => 'notas',
        'priority' => 'prioridad',
        'department' => 'departamento',
        'role' => 'rol',
        'permissions' => 'permisos',
        'tags' => 'etiquetas',
        'category' => 'categoría',
        'subcategory' => 'subcategoría',
        'brand' => 'marca',
        'model' => 'modelo',
        'serial_number' => 'número de serie',
        'location' => 'ubicación',
        'floor' => 'piso',
        'room' => 'habitación',
        'building' => 'edificio',
        'office' => 'oficina',
        'extension' => 'extensión',
        'mobile' => 'móvil',
        'landline' => 'teléfono fijo',
        'emergency_contact' => 'contacto de emergencia',
        'relationship' => 'parentesco',
        'marital_status' => 'estado civil',
        'occupation' => 'ocupación',
        'income' => 'ingresos',
        'education' => 'educación',
        'experience' => 'experiencia',
        'skills' => 'habilidades',
        'languages' => 'idiomas',
        'references' => 'referencias',
        'availability' => 'disponibilidad',
        'schedule' => 'horario',
        'shift' => 'turno',
        'overtime' => 'horas extras',
        'vacation_days' => 'días de vacaciones',
        'sick_days' => 'días de enfermedad',
        'goals' => 'objetivos',
        'achievements' => 'logros',
        'certifications' => 'certificaciones',
        'training' => 'capacitación',
        'courses' => 'cursos',
        'degree' => 'título',
        'institution' => 'institución',
        'graduation_date' => 'fecha de graduación',
        'gpa' => 'promedio',
        'bio' => 'biografía',
        'about' => 'acerca de',
        'profile_picture' => 'foto de perfil',
        'cover_photo' => 'foto de portada',
        'social_media' => 'redes sociales',
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
        'youtube' => 'YouTube',
        'timezone' => 'zona horaria',
        'locale' => 'idioma',
        'currency' => 'moneda',
        'notifications' => 'notificaciones',
        'newsletter' => 'boletín',
        'terms_accepted' => 'términos aceptados',
        'privacy_accepted' => 'política de privacidad aceptada',
        'marketing_emails' => 'correos de marketing',
        'sms_notifications' => 'notificaciones SMS',
        'push_notifications' => 'notificaciones push',
        'two_factor' => 'autenticación de dos factores',
        'backup_codes' => 'códigos de respaldo',
        'recovery_email' => 'correo de recuperación',
        'security_question' => 'pregunta de seguridad',
        'security_answer' => 'respuesta de seguridad',
        'last_login' => 'último inicio de sesión',
        'login_attempts' => 'intentos de inicio de sesión',
        'blocked_until' => 'bloqueado hasta',
        'verified_at' => 'verificado en',
        'remember_token' => 'token de recordar',
        'api_token' => 'token de API',
        'refresh_token' => 'token de actualización',
        'expires_at' => 'expira en',
        'issued_at' => 'emitido en',
        'scope' => 'alcance',
        'client_id' => 'ID de cliente',
        'client_secret' => 'secreto de cliente',
        'redirect_uri' => 'URI de redirección',
        'grant_type' => 'tipo de concesión',
        'code' => 'código',
    ],

];
