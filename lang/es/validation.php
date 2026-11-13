<?php

// Mensajes de validación en español (solo las reglas que usamos).
// :attribute se cambia por el nombre del campo (ver "attributes").
return [
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser texto.',
    'email' => 'El campo :attribute debe ser un correo válido.',
    'unique' => 'El :attribute ya está registrado.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'alpha_num' => 'El campo :attribute solo debe tener letras y números (sin espacios ni guiones).',
    'date' => 'El campo :attribute no es una fecha válida.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha igual o posterior a :date.',
    'in' => 'El valor elegido en :attribute no es válido.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'max' => [
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'string' => 'El campo :attribute no debe tener más de :max caracteres.',
    ],

    // Mensajes propios de un campo (cuando el mensaje general no suena bien)
    'custom' => [
        'placa' => [
            'unique' => 'La placa ya está registrada.',
        ],
        'numero' => [
            'unique' => 'Ese número de espacio ya existe en ese piso y sector.',
        ],
        'monto_recibido' => [
            'min' => 'El monto recibido no alcanza: debe ser al menos Bs :min.',
        ],
        'hasta' => [
            'after_or_equal' => 'La fecha "hasta" no puede ser anterior a la fecha "desde".',
        ],
        // En vehículos cliente_id se llama "dueño"; en mensualidades es el cliente
        'cliente_id' => [
            'required' => 'El campo cliente es obligatorio.',
        ],
    ],

    // Nombres de los campos
    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'rol_id' => 'rol',
        'tipo_vehiculo_id' => 'tipo de vehículo',
        'precio_hora' => 'precio por hora',
        'minutos_fraccion' => 'minutos por fracción',
        'precio_mensualidad' => 'precio de mensualidad',
        'ci' => 'CI',
        'telefono' => 'teléfono',
        'correo_electronico' => 'correo electrónico',
        'placa' => 'placa',
        'cliente_id' => 'dueño',
        'marca' => 'marca',
        'modelo' => 'modelo',
        'color' => 'color',
        'piso' => 'piso',
        'sector' => 'sector',
        'numero' => 'número',
        'espacio_id' => 'espacio',
        'buscar' => 'código o placa',
        'metodo_pago_id' => 'método de pago',
        'numero_operacion' => 'número de operación',
        'monto_recibido' => 'monto recibido',
        'desde' => 'desde',
        'hasta' => 'hasta',
        'tarifa_id' => 'tarifa',
        'agrupar' => 'agrupar por',
    ],
];
