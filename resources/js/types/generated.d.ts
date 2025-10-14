export type AuthorData = {
id: string;
name: string;
};
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
export type QuizData = {
id: string;
title: string;
slug: string;
description: string | null;
duration: number;
image_url: string | null;
image_text: string | null;
is_published: boolean;
created_at: any | null;
author: AuthorData | null;
difficulty: DifficultyData | null;
category: CategoryData | null;
themes: Array<ThemeData> | null;
average_rating: number | null;
ratings_count: number | null;
};
export type QuizzesData = {
quizzes: Array<QuizData>;
themes: Array<ThemeData>;
categories: Array<CategoryData>;
difficulties: Array<DifficultyData>;
};
export type ThemeData = {
id: string;
title: string;
created_at: any | null;
updated_at: any | null;
quizzes_count: number | null;
};
