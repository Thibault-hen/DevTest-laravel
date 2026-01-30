import { QUIZ_RESULT_COLORS, QuizResultColorValue } from '@/constants/colors';
import { QUIZ_RESULT_TRESHHOLDS } from '@/constants/quizConfig';

export const getQuizResultColorCount = (score: number): QuizResultColorValue => {
  if (score >= QUIZ_RESULT_TRESHHOLDS.EXCELLENT) {
    return QUIZ_RESULT_COLORS.EXCELLENT;
  } else if (score >= QUIZ_RESULT_TRESHHOLDS.GOOD) {
    return QUIZ_RESULT_COLORS.GOOD;
  } else if (score >= QUIZ_RESULT_TRESHHOLDS.AVERAGE) {
    return QUIZ_RESULT_COLORS.AVERAGE;
  } else {
    return QUIZ_RESULT_COLORS.POOR;
  }
};
