<?php

return [
    'hde.src.address' => getEnvOrFail('HDE_SRC_ADDRESS'),
    'hde.src.email' => getEnvOrFail('HDE_SRC_EMAIL'),
    'hde.src.password' => getEnvOrFail('HDE_SRC_PASSWORD'),
    'hde.dest.address' => getEnvOrFail('HDE_DEST_ADDRESS'),
    'hde.dest.email' => getEnvOrFail('HDE_DEST_EMAIL'),
    'hde.dest.password' => getEnvOrFail('HDE_DEST_PASSWORD'),
    'hde.default.user.password' => getEnvOrFail('HDE_DEFAULT_USER_PASSWORD'),
];
