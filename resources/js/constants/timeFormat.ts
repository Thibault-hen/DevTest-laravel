export const convertMillisecondsToTimeFormat = (milliseconds: number): string => {
  const totalSeconds = Math.floor(milliseconds / 1000);
  const minutes = Math.floor((totalSeconds % 3600) / 60);
  const seconds = totalSeconds % 60;

  return `${minutes.toString()}min ${seconds.toString().padStart(2, '0')}s`;
};
