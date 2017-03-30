<?php

return [
    'plugin'      => [
        'name'        => 'BlogChimp',
        'description' => 'Conecta MailChimp con RainLab Blog',
    ],
    'permissions' => [
        'setting' => 'Acceso a configuraciones',
        'import'  => 'Importar campañas de MailChimp',
    ],
    'setting'     => [
        'mc'                              => 'MailChimp',
        'mc_key'                          => 'API Key',
        'remove_selectors'                => 'Borrar elementos de la campaña',
        'remove_selectors_comment'        => 'Ingrese el selector CSS de los elementos a eliminar. Por más información vea http://api.jquery.com/category/selectors/',
        'selector'                        => 'Selector CSS',
        'remove_style_attributes'         => 'Borrar estilos CSS',
        'remove_style_attributes_comment' => 'Ingrese los nombres de los estilos que se eliminarán del atributo "style". Vea http://www.w3schools.com/cssref/default.asp',
        'css_style'                       => 'Nombre del estilo',
        'p2i'                             => 'Page 2 Images',
        'use_p2i'                         => 'Habilitar page2images',
        'use_p2i_comment'                 => 'Utilizar el servicio de page2images.com para generar capturas de los articulos importados',
        'p2i_key'                         => 'Rest Api key',
        'p2i_key_comment'                 => 'Obtenga su Api key desde su cuenta (http://www.page2images.com/my_account/apikey)',
        'p2i_section'                     => 'Servicio page2images.com',
        'p2i_section_comment'             => 'Habilite el servicio de page2images.com para generar capturas de los artículos importados de MailChimp y mostrarlas como miniaturas.',
        'p2i_device'                      => 'Dispositivo movil para generar la captura',
        'p2i_device_comment'              => 'El sistema puede generar capturas de pantalla para diferentes dispositivos.',
        'p2i_url'                         => 'Página de captura',
        'p2i_url_comment'                 => 'Nombre de la página del post generado a partir de MailChimp. Usualmente blog/post',
        'p2i_screen_width'                => 'Ancho de la pantalla',
        'p2i_screen_height'               => 'Alto de la pantalla',
        'p2i_screen_comment'              => 'Tamaño de la pantalla del dispositivo que quiere simular.',
        'p2i_size_width'                  => 'Ancho de la captura',
        'p2i_size_height'                 => 'Alto de la captura',
        'p2i_size_comment'                => 'El tamaño de la captura que desea conseguir. No es el tamaño de la pantalla del dispositivo.',
        'p2i_fullpage'                    => 'Página completa',
        'p2i_fullpage_comment'            => 'Página completa o sólo el área de la pantalla. Si el valor es 1 o verdadero, se tomará la captura a pantalla completa. Si el valor es 0 o falso, se tomará sólo el área de la pantalla.',
        'p2i_left_calls'                  => 'Llamadas restantes',
        'p2i_left_calls_comment'          => 'Llamadas al API de Page2Images restantes',
        'regenerate_images'               => 'Regenerar imagenes de todas las campañas importadas',
        'regenerate_images_btn_label'     => 'Regenerar',
        'regenerate_images_processing'    => 'Regenerar imágenes desde Page2Images está en proceso...'
    ],
    'import'      => [
        'campaign_imported'      => 'Se han importado las campañas de MailChimp',
        'no_campaigns_to_import' => 'No hay campañas nuevas que importar',
        'p2i_status_processing'  => 'La solicitud de Page2Images se encuentra en proceso',
        'p2i_status_finished'    => 'Page2Images ha finalizado el proceso de captura',
    ],
    'posts'       => [
        'mailchimp_column' => 'Importado de MailChimp',
        'p2i_column'       => 'Estado de Page2Images'
    ],
    'p2i'         => [
        'status' => [
            'processing' => 'En proceso...',
            'finished'   => 'Completado',
            'error'      => 'Error',
            'unknown'    => 'Desconocido'
        ]
    ]
];