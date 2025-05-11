<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MigrationController extends Controller
{
    public function export()
    {
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST');

        $filename = "backup-" . now()->format('Y-m-d_H-i-s') . ".sql";

        $command = "C:\\xampp\\mysql\\bin\\mysqldump.exe --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > " . storage_path("app/{$filename}") . " 2>&1";
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);

        $filePath = storage_path("app/{$filename}");

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    // Show import form
    public function showImportForm()
    {
        return view('admin.migration.index');
    }

    public function importDatabase(Request $request)
    {

        $this->dropAllTables();
        // Store the uploaded file temporarily
        $file = $request->file('sql_file');
        $filePath = $file->storeAs('temp', 'import.sql');
        DB::unprepared(file_get_contents(storage_path("app/{$filePath}")));

        // Delete the file after processing
        Storage::delete($filePath);

        return back()->with('success', 'Database imported successfully!');
    }

    private function dropAllTables()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        // Get all table names
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');
        $tableNames = array_map(function($table) use ($dbName) {
            return $table->{'Tables_in_' . $dbName};
        }, $tables);

        // Drop all tables
        foreach ($tableNames as $tableName) {
            DB::statement("DROP TABLE IF EXISTS {$tableName}");
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
