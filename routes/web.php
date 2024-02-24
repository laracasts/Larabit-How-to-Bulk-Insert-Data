<?php

use App\Helpers\ArrayHelpers;
use App\Models\GaugeReading;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
//    ini_set('max_execution_time', 600);
    // ini_set('memory_limit', '1024M');

    $smallPath = storage_path('app\small_set.csv');
    $largePath = storage_path('app\large_set.csv');

    
    // $generateRow = function($row) {
    //     return [
    //         'log_date' => date('Y-m-d', strtotime($row[0])),
    //         'log_time' => $row[1],
    //         'gauge_one_pressure' => $row[2],
    //         'gauge_one_temp' => $row[3],
    //         'gauge_two_pressure' => $row[4],
    //         'gauge_two_temp' => $row[5],
    //     ];
    // };

    // GaugeReading::withoutSyncingToSearch(function() use($smallPath, $generateRow) { // for laravel scount
    //     DB::statement('SET FOREIGN_KEY_CHECKS=0');
    //     DB::statement('ALTER TABLE gauge_readings DISABLE KEYS');

    //     foreach (ArrayHelpers::chunkFile($smallPath, $generateRow, 1000) as $chunk) {
    //         GaugeReading::Insert($chunk);
    //     }

    //     DB::statement('ALTER TABLE gauge_readings ENABLE KEYS');
    //     DB::statement('SET FOREIGN_KEY_CHECKS=1');
    // });

    $escapedPath = DB::getPdo()->quote($largePath);
    
    DB::statement("
        LOAD DATA LOCAL INFILE {$escapedPath}
        INTO TABLE gauge_readings
        FIELDS TERMINATED BY ','
        LINES TERMINATED BY '\\n'
        (@date_var, log_time, gauge_one_pressure, gauge_one_temp, gauge_two_pressure, gauge_two_temp)
        SET log_date = STR_TO_DATE(@date_var, '%m/%d/%Y')
    ");

    

    

    echo '<p>Finished database insert</p>';
});
