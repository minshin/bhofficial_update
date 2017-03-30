<?php

return [
    'plugin'      => [
        'name'        => 'BlogChimp',
        'description' => 'Connect MailChimp with RainLab Blog',
    ],
    'permissions' => [
        'setting' => 'Settings access',
        'import'  => 'Import MailChimp campaigns',
    ],
    'setting'     => [
        'mc'                              => 'MailChimp',
        'mc_key'                          => 'API Key',
        'remove_selectors'                => 'Remove campaign html elements',
        'remove_selectors_comment'        => 'Write the CSS selector to remove html elements. See http://api.jquery.com/category/selectors/',
        'selector'                        => 'CSS selector',
        'remove_style_attributes'         => 'Remove CSS styles',
        'remove_style_attributes_comment' => 'Write the style name to be removed from "style" attribute. See http://www.w3schools.com/cssref/default.asp',
        'css_style'                       => 'Property name',
        'p2i'                             => 'Page 2 Images',
        'use_p2i'                         => 'Enable page2images',
        'use_p2i_comment'                 => 'Use page2images.com service to make screenshot of blog posts',
        'p2i_key'                         => 'Rest Api key',
        'p2i_key_comment'                 => 'Get your Api key from your account (http://www.page2images.com/my_account/apikey)',
        'p2i_section'                     => 'page2images.com service',
        'p2i_section_comment'             => 'Enable page2images.com service to make screenshot of your blog post, imported from MailChimp.',
        'p2i_device'                      => 'Device to generate screenchots',
        'p2i_device_comment'              => 'The system can generate the screenshot for those smart phones and desktops.',
        'p2i_url'                         => 'Page to make screenshot',
        'p2i_url_comment'                 => 'Name of MailChimp post page to generate screenshot. Usually blog/post',
        'p2i_screen_width'                => 'Screen width',
        'p2i_screen_height'               => 'Screen height',
        'p2i_screen_comment'              => 'The screen size of device you want to simulate',
        'p2i_size_width'                  => 'Size width',
        'p2i_size_height'                 => 'Size height',
        'p2i_size_comment'                => 'The screenshot file size you want to get. Not the screen size of device.',
        'p2i_fullpage'                    => 'Full page',
        'p2i_fullpage_comment'            => 'Full page or just the screen area. If the value is 1 or true, we will take the full page screenshot. If the value is 0 or false, we will take the screen area only.',
        'p2i_left_calls'                  => 'Left Calls',
        'p2i_left_calls_comment'          => 'Used API Calls',
        'regenerate_images'               => 'Regenerate images of all imported campaigns',
        'regenerate_images_btn_label'     => 'Regenerate',
        'regenerate_images_processing'    => 'Regenerate images from Page2Images in process...',
    ],
    'import'      => [
        'campaign_imported'      => 'The MailChimp campaigns has been imported',
        'no_campaigns_to_import' => 'There is no new campaign to import',
        'p2i_status_processing'  => 'The Page2Images request is in process',
        'p2i_status_finished'    => 'Page2Images has finished the screenshot process',
    ],
    'posts'       => [
        'mailchimp_column' => 'Imported from MailChimp',
        'p2i_column'       => 'Page2Images Status'
    ],
    'p2i'         => [
        'status' => [
            'processing' => 'Processing...',
            'finished'   => 'Finished',
            'error'      => 'Error',
            'unknown'    => 'Unknown'
        ]
    ]
];