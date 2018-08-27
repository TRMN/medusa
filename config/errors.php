<?php

return [
    'custom_error_pages' => json_decode(env('ERROR_USERS', '[]'), true),
];
