<?php

declare(strict_types=1);

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Contact\Http\Requests\StoreLeadRequest;
use Modules\Contact\Services\LeadService;

class LeadController extends Controller
{
    public function __construct(private readonly LeadService $service) {}

    public function store(StoreLeadRequest $request): JsonResponse
    {
        $this->service->store(
            $request->validated(),
            $request->ip() ?? '',
        );

        return response()->json(['success' => true]);
    }
}
