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
//Log::info('Queue worker executed at: ' . now());
// Run the queue worker
Artisan::call('queue:work', [
    '--timeout' => 3600,    // Maximum time a single job can run
    '--tries' => 3,       // Maximum retry attempts
    '--stop-when-empty' => true, // Stop after processing all jobs
]);

$kernel->terminate($request, $response);
