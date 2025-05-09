<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = auth()->user()?->load('roles', 'permissions');

        return [
            ...parent::share($request),
            'app' => [
                'name' => config('app.name'),
                'url' => config('app.url'),
            ],
            'auth' => [
                'user' => $request->user(),
                'permissions' => $user?->permissions()->pluck('name')->toArray(),
                'roles' => $user?->getRoleNames(),
            ],
            'flash' => [
                'success' => session('success') ?? '',
                'error' => session('error') ?? '',
            ],
        ];
    }
}
