<?php

declare(strict_types=1);

namespace App\Enums;

enum CacheKey: string
{
    case QUIZZES = 'quizzes';
    case QUIZ_DETAILS = 'quiz_details';
    case QUIZ_PLAY = 'quiz_play';
    case QUIZZES_WITH_QUESTIONS = 'quizzes_with_questions';
    case HOME = 'homepage';
}
