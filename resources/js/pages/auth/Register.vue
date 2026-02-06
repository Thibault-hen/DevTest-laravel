<script setup lang="ts">
import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { SpecializationData } from '@/types/generated';
import { Form, Head } from '@inertiajs/vue3';
import { Eye, EyeOff, LoaderCircle } from 'lucide-vue-next';
import { computed, ref } from 'vue';

export type PasswordType = 'password' | 'text';

const props = defineProps<{
  specializations: SpecializationData[];
}>();

const selectedSpecialization = ref<string>('');

const isHidePasswordEnabled = ref<boolean>(true);
const isHidePasswordConfirmEnabled = ref<boolean>(true);
const passwordType = computed((): PasswordType => (isHidePasswordEnabled.value ? 'password' : 'text'));
const passwordConfirmType = computed((): PasswordType => (isHidePasswordConfirmEnabled.value ? 'password' : 'text'));

const toggleHidePassword = (): void => {
  isHidePasswordEnabled.value = !isHidePasswordEnabled.value;
};

const toggleHideConfirmPassword = (): void => {
  isHidePasswordConfirmEnabled.value = !isHidePasswordConfirmEnabled.value;
};
</script>

<template>
  <AuthBase
    title="Créer un compte"
    description="Entrez vos informations ci-dessous pour créer votre compte"
  >
    <Head title="Register" />

    <Form
      v-bind="RegisteredUserController.store.form()"
      :reset-on-success="['password', 'password_confirmation']"
      v-slot="{ errors, processing }"
      class="flex flex-col gap-6"
    >
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label for="name">Nom</Label>
          <Input
            id="name"
            type="text"
            required
            autofocus
            :tabindex="1"
            autocomplete="name"
            name="name"
            placeholder="Nom complet"
          />
          <InputError :message="errors.name" />
        </div>

        <div class="grid gap-2">
          <Label for="email">Adresse e-mail</Label>
          <Input
            id="email"
            type="email"
            required
            :tabindex="2"
            autocomplete="email"
            name="email"
            placeholder="email@example.com"
          />
          <InputError :message="errors.email" />
        </div>

        <div class="grid gap-2">
          <Label for="specialization">Spécialisation</Label>
          <Select
            name="specialization_id"
            id="specialization"
            v-model="selectedSpecialization"
            required
          >
            <SelectTrigger class="bg-input/30">
              <SelectValue placeholder="Sélectionnez une spé" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectLabel>Spécialisations</SelectLabel>
                <SelectItem
                  v-for="specialization in props.specializations"
                  :key="specialization.id"
                  :value="specialization.id"
                  @change="selectedSpecialization = specialization.id"
                  >{{ specialization.name }}</SelectItem
                >
              </SelectGroup>
            </SelectContent>
          </Select>
          <InputError :message="errors.specialization_id" />
        </div>
        <div class="grid gap-2">
          <Label for="password">Mot de passe</Label>
          <div class="relative">
            <Input
              id="password"
              :type="passwordType"
              required
              :tabindex="3"
              autocomplete="new-password"
              name="password"
              placeholder="Mot de passe"
            />
            <Eye
              v-if="isHidePasswordEnabled"
              @click="toggleHidePassword"
              class="absolute top-2.5 right-2.5 cursor-pointer"
              :size="18"
            />
            <EyeOff
              v-else
              @click="toggleHidePassword"
              class="absolute top-2.5 right-2.5 cursor-pointer"
              :size="18"
            />
          </div>
          <InputError :message="errors.password" />
        </div>

        <div class="grid gap-2">
          <Label for="password_confirmation">Confirmer le mot de passe</Label>
          <div class="relative">
            <Input
              id="password_confirmation"
              :type="passwordConfirmType"
              required
              :tabindex="4"
              autocomplete="new-password"
              name="password_confirmation"
              placeholder="Confirmer le mot de passe"
            />
            <Eye
              v-if="isHidePasswordConfirmEnabled"
              @click="toggleHideConfirmPassword"
              class="absolute top-2.5 right-2.5 cursor-pointer"
              :size="18"
            />
            <EyeOff
              v-else
              @click="toggleHideConfirmPassword"
              class="absolute top-2.5 right-2.5 cursor-pointer"
              :size="18"
            />
          </div>
          <InputError :message="errors.password_confirmation" />
        </div>

        <Button
          variant="primary"
          type="submit"
          class="mt-2 w-full"
          tabindex="5"
          :disabled="processing"
          data-test="register-user-button"
        >
          <LoaderCircle
            v-if="processing"
            class="h-4 w-4 animate-spin"
          />
          Créer un compte
        </Button>
      </div>

      <div class="text-center text-sm text-muted-foreground">
        Vous avez déjà un compte ?
        <TextLink
          :href="login()"
          class="underline underline-offset-4"
          :tabindex="6"
          >Se connecter</TextLink
        >
      </div>
    </Form>
  </AuthBase>
</template>
