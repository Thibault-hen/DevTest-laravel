<?php

declare(strict_types=1);

namespace App\Enums;

enum CacheKeys: string
{
    case QUIZZES = 'quizzes';
    case QUIZZES_WITH_QUESTIONS = 'quizzes_with_questions';
    case HOME = 'homepage';
}
