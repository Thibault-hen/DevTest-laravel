<script setup lang="ts">
import EmailVerificationNotificationController from '@/actions/App/Http/Controllers/Auth/EmailVerificationNotificationController';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { logout } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
  status?: string;
}>();
</script>

<template>
  <AuthLayout
    title="Vérification de l'email"
    description="Veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer."
  >
    <Head title="Vérification de l'email" />

    <div
      v-if="status === 'verification-link-sent'"
      class="mb-4 text-center text-sm font-medium text-green-600"
    >
      Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de l'inscription.
    </div>

    <Form
      v-bind="EmailVerificationNotificationController.store.form()"
      class="space-y-6 text-center"
      v-slot="{ processing }"
    >
      <Button
        :disabled="processing"
        variant="secondary"
      >
        <LoaderCircle
          v-if="processing"
          class="h-4 w-4 animate-spin"
        />
        Renvoyer l'e-mail de vérification
      </Button>

      <TextLink
        :href="logout()"
        as="button"
        class="mx-auto block text-sm"
      >
        Se déconnecter
      </TextLink>
    </Form>
  </AuthLayout>
</template>
