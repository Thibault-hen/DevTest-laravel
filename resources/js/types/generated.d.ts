export type AnswerPlayData = {
id: string;
content: string;
};
export type AuthorData = {
id: string;
name: string;
};
export type CacheKeys = 'quizzes' | 'homepage';
export type CacheTags = 'quiz';
export type CategoryData = {
id: string;
name: string;
created_at: any | null;
updated_at: any | null;
quizzes_count: number | null;
};
export type DifficultyData = {
id: string;
level: string;
color: string | null;
created_at: any | null;
updated_at: any | null;
quizzes_count: number | null;
};
export type HomeData = {
quizzes: Array<QuizData> | null;
quiz_count: number;
quiz_completed_count: number;
theme_count: number;
};
export type QuestionAnswerData = {
question_id: string;
answers: Array<any> | string | null;
};
export type QuestionPlayData = {
id: string;
content: string;
timer: number;
is_multiple: boolean;
answers: Array<AnswerPlayData>;
};
export type QuizData = {
id: string;
title: string;
slug: string;
description: string;
duration: number;
image_url: string | null;
image_text: string | null;
is_published: boolean;
created_at: any | null;
author: AuthorData | null;
difficulty: DifficultyData | null;
category: CategoryData | null;
themes: Array<ThemeData> | null;
ratings: Array<RatingData> | null;
average_rating: number | null;
ratings_count: number | null;
};
export type QuizPlayData = {
id: string;
title: string;
slug: string;
description: string;
duration: number;
image_url: string | null;
image_text: string | null;
created_at: any | null;
author: AuthorData | null;
difficulty: DifficultyData | null;
category: CategoryData | null;
themes: Array<ThemeData> | null;
questions: Array<QuestionPlayData> | null;
};
export type QuizzesData = {
quizzes: Array<QuizData>;
themes: Array<ThemeData>;
categories: Array<CategoryData>;
difficulties: Array<DifficultyData>;
};
export type RatingData = {
id: string;
comment: string;
score: number;
created_at: any | null;
updated_at: any | null;
user: UserRatingData | null;
};
export type ResultPostData = {
total_time: number;
questions: Array<QuestionAnswerData>;
};
export type ThemeData = {
id: string;
title: string;
created_at: any | null;
updated_at: any | null;
quizzes_count: number | null;
};
export type UserRatingData = {
id: string;
name: string;
specialization: string;
avatar: string | null;
};
