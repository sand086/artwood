<?php
// config/files.php

return [
    'documents' => [
        /**
         * Tamaño máximo de archivos en kilobytes (KB).
         */
        'max_size_kb' => env('DOCUMENT_MAX_SIZE_KB', 5120), // 5MB
        /**
         * Tipos de archivos permitidos.
         */
        'allowed_mimes' => [
            'pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip', 'dwg', 'dxf'
        ],
    ],
    // Puedes añadir otras configuraciones de archivos aquí
    'images' => [
        /**
         * Tamaño máximo de imágenes en kilobytes (KB).
         */
        'max_size_kb' => env('IMAGE_MAX_SIZE_KB', 5120), // 5MB
        /**
         * Tipos de imágenes permitidas.
         */
        'allowed_mimes' => ['jpg', 'jpeg', 'png', 'gif'],
    ],
];