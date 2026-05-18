<?php

declare(strict_types=1);

namespace Modules\Core\Http\Middleware;

use Butschster\Head\Facades\Meta;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetMetaDefaults
{
    public function handle(Request $request, Closure $next): Response
    {
        Meta::setCanonical($request->url());

        return $next($request);
    }
}
