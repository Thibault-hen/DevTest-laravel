<script lang="ts" setup>
import Card from '@/components/ui/card/Card.vue';
import { useAppearance } from '@/composables/useAppearance';
import { TechLogo } from '@/types';

const { getStoredAppearance } = useAppearance();

const isDarkMode: boolean = getStoredAppearance() === 'dark';

const logos: TechLogo[] = [
  {
    name: 'PHP',
    src: isDarkMode ? 'assets/img/logos/php_dark.svg' : 'assets/img/logos/php.svg',
    alt: 'PHP Logo',
    color: '#8892BF',
  },
  { name: 'JavaScript', src: 'assets/img/logos/javascript.svg', alt: 'JavaScript Logo', color: '#F7DF1E' },
  { name: 'Python', src: 'assets/img/logos/python.svg', alt: 'Python Logo', color: '#3776AB' },
  { name: 'Tailwind CSS', src: 'assets/img/logos/tailwindcss.svg', alt: 'Tailwind CSS Logo', color: '#06B6D4' },
  { name: 'HTML', src: 'assets/img/logos/html5.svg', alt: 'HTML Logo', color: '#E34F26' },
  { name: 'CSS', src: 'assets/img/logos/css_old.svg', alt: 'CSS Logo', color: '#1572B6' },
  { name: 'C', src: 'assets/img/logos/c.svg', alt: 'C Logo', color: '#2496ED' },
  { name: 'Java', src: 'assets/img/logos/java.svg', alt: 'Java Logo', color: '#007396' },
  { name: 'Docker', src: 'assets/img/logos/docker.svg', alt: 'Docker Logo', color: '#2496ED' },
  { name: 'NodeJS', src: 'assets/img/logos/nodejs.svg', alt: 'NodeJS Logo', color: '#8CC84B' },
  { name: 'Ruby', src: 'assets/img/logos/ruby.svg', alt: 'Ruby Logo', color: '#CC342D' },
  { name: 'React', src: 'assets/img/logos/react_light.svg', alt: 'React Logo', color: '#61DAFB' },
  { name: 'Vue', src: 'assets/img/logos/vue.svg', alt: 'Vue Logo', color: '#42B883' },
  { name: 'Angular', src: 'assets/img/logos/angular.svg', alt: 'Angular Logo', color: '#DD0031' },
  { name: 'PostgreSQL', src: '/assets/img/logos/postgresql.svg', alt: 'PostgreSQL Logo', color: '#336791' },
  { name: 'MySQL', src: '/assets/img/logos/mysql.svg', alt: 'MySQL Logo', color: '#4479A1' },
  { name: 'TypeScript', src: '/assets/img/logos/typescript.svg', alt: 'TypeScript Logo', color: '#007ACC' },
  { name: 'C#', src: '/assets/img/logos/csharp.svg', alt: 'C# Logo', color: '#68217A' },
];
</script>
<template>
  <Card
    class="relative mx-auto w-full overflow-hidden rounded-2xl border border-primary/10 bg-gradient-to-b from-card to-card/50 p-6 shadow-xl backdrop-blur-sm md:p-8"
  >
    <div class="relative z-0 py-6">
      <div class="animate-marquee-horizontal">
        <div
          v-for="(logo, index) in logos"
          :key="`first-${index}`"
          class="framework-card mr-16 inline-flex sm:mr-24"
        >
          <img
            :src="logo.src"
            :alt="logo.alt"
            class="h-8 w-8 object-contain transition-all duration-300 md:h-14 md:w-14"
            :style="{ '--glow-color': logo.color }"
          />
        </div>

        <div
          v-for="(logo, index) in logos"
          :key="`second-${index}`"
          class="framework-card mr-16 inline-flex sm:mr-24"
        >
          <img
            :src="logo.src"
            :alt="logo.alt"
            class="h-8 w-8 object-contain transition-all duration-300 md:h-14 md:w-14"
            :style="{ '--glow-color': logo.color }"
          />
        </div>
      </div>
    </div>

    <div
      class="pointer-events-none absolute top-0 left-0 z-10 h-full w-32 bg-gradient-to-r from-card via-card/80 to-transparent"
    ></div>
    <div
      class="pointer-events-none absolute top-0 right-0 z-10 h-full w-32 bg-gradient-to-l from-card via-card/80 to-transparent"
    ></div>
  </Card>
</template>

<style scoped>
.dark .framework-card img {
  user-select: none;
  filter: drop-shadow(0 0 0.6rem color-mix(in srgb, var(--glow-color) 40%, transparent));
  transition: transform 0.2s;
}

.dark.framework-card img:hover {
  transform: scale(1.1);
}
</style>
