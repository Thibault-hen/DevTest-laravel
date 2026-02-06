<script setup lang="ts">
import PasswordResetLinkController from '@/actions/App/Http/Controllers/Auth/PasswordResetLinkController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
  status?: string;
}>();
</script>

<template>
  <AuthLayout
    title="Mot de passe oublié"
    description="Entrez votre adresse e-mail pour recevoir un lien de réinitialisation du mot de passe"
  >
    <Head title="Mot de passe oublié" />

    <div
      v-if="status"
      class="mb-4 text-center text-sm font-medium text-green-600"
    >
      {{ status }}
    </div>

    <div class="space-y-6">
      <Form
        v-bind="PasswordResetLinkController.store.form()"
        v-slot="{ errors, processing }"
      >
        <div class="grid gap-2">
          <Label for="email">Adresse e-mail</Label>
          <Input
            id="email"
            type="email"
            name="email"
            autocomplete="off"
            autofocus
            placeholder="email@example.com"
          />
          <InputError :message="errors.email" />
        </div>

        <div class="my-6 flex items-center justify-start">
          <Button
            class="w-full"
            :disabled="processing"
            data-test="email-password-reset-link-button"
          >
            <LoaderCircle
              v-if="processing"
              class="h-4 w-4 animate-spin"
            />
            Envoyer le lien de réinitialisation du mot de passe
          </Button>
        </div>
      </Form>

      <div class="space-x-1 text-center text-sm text-muted-foreground">
        <span>Ou, retour à</span>
        <TextLink :href="login()">connexion</TextLink>
      </div>
    </div>
  </AuthLayout>
</template>
