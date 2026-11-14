<?php
use Illuminate\Support\Facades\Artisan;
Artisan::command('smartlog:about', function () {
    $this->info('SmartLog PNPh attendance and monitoring application.');
});
