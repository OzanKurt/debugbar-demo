<?php

use App\DataTables\UsersDataTable;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $usersDataTable = app(UsersDataTable::class);

    return view('welcome')->with([
        'usersDataTable' => $usersDataTable->html(),
    ]);
});

Route::any('/datatable', function () {
    $dataTable = app(UsersDataTable::class);

    $action = $dataTable->request()->input('action');

    if (in_array($action, ['print', 'csv', 'excel', 'pdf'])) {
        if ($action === 'print') {
            return $dataTable->printPreview();
        }

        return call_user_func_array([$dataTable, $action], []);
    }

    return $dataTable->ajax();
});
