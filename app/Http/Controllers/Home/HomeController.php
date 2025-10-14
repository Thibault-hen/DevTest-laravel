<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\HomeService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(HomeService $homeService): Response
    {
        $homeData = $homeService->getHomeData();

        return Inertia::render('index', $homeData);
    }
}
