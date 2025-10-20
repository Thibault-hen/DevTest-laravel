<?php

declare(strict_types=1);

namespace App\Enums;

enum CacheKeys: string
{
    case QUIZZES = 'quizzes';
    case HOME = 'homepage';
}
