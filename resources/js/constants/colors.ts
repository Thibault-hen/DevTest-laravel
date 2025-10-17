export const COLORS = {
  DEFAULT: '#4B5563',
} as const;

export type ColorKey = keyof typeof COLORS;
export type ColorValue = (typeof COLORS)[ColorKey];
