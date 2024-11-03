<?php
// Change the path to your Laravel installation
require __DIR__ . '/vendor/autoload.php';
// Import the Artisan facade
use Illuminate\Support\Facades\Artisan;
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Run the queue worker
Artisan::call('queue:work', [
    '--timeout' => 60,
    '--tries' => 3,
]);

$kernel->terminate($request, $response);
