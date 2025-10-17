<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function index()
    {
        $checks = [];

        // 1) Check pdo_mysql
        $pdoMysql = extension_loaded('pdo_mysql');
        $checks['pdo_mysql'] = $pdoMysql ? 'OK' : 'MISSING';

        // 2) Try DB connection
        try {
            $version = DB::select('SELECT VERSION() as v')[0]->v ?? null;
            $checks['db_connection'] = $version ? 'OK (MySQL ' . $version . ')' : 'UNKNOWN';
        } catch (\Throwable $e) {
            $checks['db_connection'] = 'ERROR: ' . $e->getMessage();
        }

        // 3) Env summary (safe)
        $checks['env'] = [
            'APP_ENV' => env('APP_ENV'),
            'DB_CONNECTION' => env('DB_CONNECTION'),
            'DB_HOST' => env('DB_HOST'),
            'DB_DATABASE' => env('DB_DATABASE'),
            'DB_USERNAME' => env('DB_USERNAME'),
        ];

        return response()->json($checks);
    }
}
