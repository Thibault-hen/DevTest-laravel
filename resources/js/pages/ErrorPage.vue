<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { home } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { AlertTriangle, FileQuestion, Globe, Lock, ServerCrash, WifiOff } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
  status: number;
}>();

const config = computed(() => {
  switch (props.status) {
    case 503:
      return {
        title: 'Service Indisponible',
        description: 'Nous effectuons actuellement une maintenance. Veuillez réessayer plus tard.',
        icon: WifiOff,
      };
    case 500:
      return {
        title: 'Erreur Serveur',
        description: "Oups, quelque chose s'est mal passé sur nos serveurs.",
        icon: ServerCrash,
      };
    case 404:
      return {
        title: 'Page Non Trouvée',
        description: 'Désolé, la page que vous recherchez est introuvable.',
        icon: FileQuestion,
      };
    case 403:
      return {
        title: 'Accès Interdit',
        description: "Désolé, vous n'avez pas la permission d'accéder à cette page.",
        icon: Lock,
      };
    default:
      return {
        title: 'Une erreur est survenue',
        description: "Une erreur inattendue s'est produite. Veuillez réessayer.",
        icon: AlertTriangle,
      };
  }
});
</script>

<template>
  <Head :title="config.title" />

  <div class="relative flex min-h-screen flex-col items-center justify-center p-4 text-center">
    <div
      class="pointer-events-none absolute top-1/2 left-1/2 h-64 w-64 -translate-x-1/2 -translate-y-1/2 rounded-full bg-primary/10 blur-3xl"
    ></div>

    <div class="relative z-10 flex flex-col items-center gap-6">
      <div class="flex h-24 w-24 items-center justify-center rounded-full bg-muted/50 p-6 ring-1 ring-border shadow-sm">
        <component
          :is="config.icon"
          class="h-12 w-12 text-primary"
          stroke-width="1.5"
        />
      </div>

      <div class="space-y-2 max-w-md">
        <h1 class="text-3xl font-bold tracking-tight sm:text-4xl text-foreground">
          {{ props.status }} — {{ config.title }}
        </h1>
        <p class="text-muted-foreground text-lg">
          {{ config.description }}
        </p>
      </div>

      <div class="mt-4">
        <Button
          as-child
          size="lg"
          class="px-8"
          variant="default"
        >
          <Link :href="home().url">
            <Globe class="mr-2 h-4 w-4" />
            Retour à l'accueil
          </Link>
        </Button>
      </div>
    </div>
  </div>
</template>
