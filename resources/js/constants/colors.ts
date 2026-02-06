export const COLORS = {
  DEFAULT: '#4B5563',
} as const;

export const QUIZ_RESULT_COLORS = {
  EXCELLENT: 'bg-green-500/20 text-green-700 border-green-700',
  GOOD: 'bg-yellow-500/20 text-yellow-700 border-yellow-700',
  AVERAGE: 'bg-orange-500/20 text-orange-700 border-orange-700',
  POOR: 'bg-red-500/20 text-red-700 border-red-700',
} as const;

export type ColorKey = keyof typeof COLORS;
export type ColorValue = (typeof COLORS)[ColorKey];

export type QuizResultColorKey = keyof typeof QUIZ_RESULT_COLORS;
export type QuizResultColorValue = (typeof QUIZ_RESULT_COLORS)[QuizResultColorKey];
