export type AnswerData = {
  id: string;
  content: string;
  is_correct: boolean;
};
export type AnswerPlayData = {
  id: string;
  content: string;
};
export type AnswerResultData = {
  id: string;
  content: string;
  is_correct: boolean;
};
export type AuthorData = {
  id: string;
  name: string;
};
export type CacheKeys = 'quizzes' | 'quizzes_with_questions' | 'homepage';
export type CacheTags = 'quiz';
export type CategoryData = {
  id: string;
  title: string;
  created_at: any | null;
  updated_at: any | null;
  quizzes_count: number | null;
};
export type CreateOrUpdateCategoryData = {
  title: string;
};
export type CreateOrUpdateDifficultyData = {
  level: string;
  color: string | null;
};
export type CreateOrUpdateQuizAnswerData = {
  id: string | null;
  content: string;
  is_correct: boolean;
};
export type CreateOrUpdateQuizData = {
  id: string | null;
  title: string;
  description: string;
  difficulty_id: string;
  category_id: string;
  themes_ids: Array<any> | null;
  duration: number;
  is_published: boolean;
  icon: any | null;
  questions: Array<CreateOrUpdateQuizQuestionData>;
};
export type CreateOrUpdateQuizQuestionData = {
  id: string | null;
  content: string;
  is_multiple: boolean;
  timer: number;
  answers: Array<CreateOrUpdateQuizAnswerData>;
};
export type CreateOrUpdateSpecializationData = {
  name: string;
};
export type CreateOrUpdateThemeData = {
  title: string;
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
export type PublishQuizData = {
  is_published: boolean;
};
export type QuestionAnswerData = {
  question_id: string;
  answers: Array<any> | string | null;
};
export type QuestionData = {
  id: string;
  content: string;
  is_multiple: boolean;
  timer: number;
  answers: Array<AnswerData>;
};
export type QuestionPlayData = {
  id: string;
  content: string;
  timer: number;
  is_multiple: boolean;
  shuffled_answers: Array<AnswerPlayData>;
};
export type QuestionResultData = {
  id: string;
  content: string;
  timer: number;
  answers: Array<AnswerResultData>;
};
export type QuizData = {
  created_at_formatted: string | null;
  id: string;
  title: string;
  slug: string;
  description: string;
  duration: number;
  image_url: string | null;
  is_published: boolean;
  created_at: any | null;
  author: AuthorData | null;
  difficulty: DifficultyData | null;
  category: CategoryData | null;
  themes: Array<ThemeData> | null;
  ratings: Array<RatingData> | null;
  average_rating: number | null;
  ratings_count: number | null;
  questions: Array<QuestionData> | null;
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
  comment: string | null;
  score: number;
  created_at: any | null;
  updated_at: any | null;
  user: UserRatingData | null;
};
export type RatingPostData = {
  comment: string | null;
  score: number;
  quiz_id: string;
};
export type ResultData = {
  id: string;
  score: number;
  completed_in: number;
  correct_answers_count: number;
  completed_at: any | null;
  results: Array<ResultQuestionData>;
  user_answers: Array<AnswerResultData>;
  quiz: QuizData;
  user_rating: RatingData | null;
  user: UserData | null;
};
export type ResultPostData = {
  total_time: number;
  questions: Array<QuestionAnswerData>;
};
export type ResultQuestionData = {
  question: QuestionResultData;
  is_correct: boolean;
};
export type SpecializationData = {
  id: string;
  name: string;
  created_at: any | null;
  updated_at: any | null;
  users_count: number | null;
};
export type ThemeData = {
  id: string;
  title: string;
  created_at: any | null;
  updated_at: any | null;
  quizzes_count: number | null;
};
export type UserData = {
  id: string;
  name: string;
  email: string;
  specialization: SpecializationData | null;
  avatar: string | null;
  created_at: any | null;
  updated_at: any | null;
  email_verified_at: string | null;
  two_factor_confirmed_at: string | null;
  is_admin: boolean;
};
export type UserRatingData = {
  id: string;
  name: string;
  specialization: SpecializationData | null;
  avatar: string | null;
};
