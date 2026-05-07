<?php

chdir(__DIR__);

exec('php artisan schedule:run');
