<?php

namespace App\Http\Controllers;

use App\Services\Repository\RepositoryDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PkgController extends Controller
{
    public function __construct(protected RepositoryDatabase $repository) {}
    public function index(): JsonResponse {
        return response()->json($this->repository->getAllEntries());
    }

    
}
