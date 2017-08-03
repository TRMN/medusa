<?php
return [
  'restricted' => json_decode(env('RESTRICTED_PERMS', '["CONFIG", "USER_MASQ"]'), true),
];