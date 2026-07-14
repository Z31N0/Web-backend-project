<?php

use App\Http\Controllers\SecurityAuditController;
use App\Http\Middleware\ValidateToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/organizations", [SecurityAuditController::class,"getAllOrganizations"]);
Route::get("/accounts", [SecurityAuditController::class,"getAllAccounts"])
    -> middleware(ValidateToken::class);
Route::post("/execute_audit", [SecurityAuditController::class, "executeAudit"]);
