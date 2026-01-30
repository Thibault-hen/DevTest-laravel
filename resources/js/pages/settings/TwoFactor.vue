<script setup lang="ts">
import TwoFactorRecoveryCodes from '@/components/settings/TwoFactorRecoveryCodes.vue';
import TwoFactorSetupModal from '@/components/settings/TwoFactorSetupModal.vue';
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { disable, enable } from '@/routes/two-factor';
import { Form, Head } from '@inertiajs/vue3';
import { ShieldBan, ShieldCheck } from 'lucide-vue-next';
import { onUnmounted, ref } from 'vue';

interface Props {
  requiresConfirmation?: boolean;
  twoFactorEnabled?: boolean;
}

withDefaults(defineProps<Props>(), {
  requiresConfirmation: false,
  twoFactorEnabled: false,
});

defineOptions({
  layout: AppLayout,
});

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

onUnmounted(() => {
  clearTwoFactorAuthData();
});
</script>

<template>
  <Head title="Authentification à deux facteurs" />
  <SettingsLayout>
    <div class="space-y-6">
      <HeadingSmall
        title="Authentification à deux facteurs"
        description="Gérez vos paramètres d'authentification à deux facteurs"
      />

      <div
        v-if="!twoFactorEnabled"
        class="flex flex-col items-start justify-start space-y-4"
      >
        <Badge variant="destructive">Désactivé</Badge>

        <p class="text-muted-foreground">
          quand vous activez l'authentification à deux facteurs, vous serez invité à saisir un code sécurisé lors de la
          connexion. Ce code peut être récupéré à partir d'une application compatible TOTP sur votre téléphone.
        </p>

        <div>
          <Button
            v-if="hasSetupData"
            @click="showSetupModal = true"
          >
            <ShieldCheck />Continuer la configuration
          </Button>
          <Form
            v-else
            v-bind="enable.form()"
            @success="showSetupModal = true"
            #default="{ processing }"
          >
            <Button
              type="submit"
              :disabled="processing"
            >
              <ShieldCheck />Activer 2FA</Button
            ></Form
          >
        </div>
      </div>

      <div
        v-else
        class="flex flex-col items-start justify-start space-y-4"
      >
        <Badge variant="default">Activé</Badge>

        <p class="text-muted-foreground">
          lorsque l'authentification à deux facteurs est activée, vous serez invité à saisir un code sécurisé et
          aléatoire lors de la connexion, que vous pouvez récupérer à partir d'une application compatible TOTP sur votre
          téléphone.
        </p>

        <TwoFactorRecoveryCodes />

        <div class="relative inline">
          <Form
            v-bind="disable.form()"
            #default="{ processing }"
          >
            <Button
              variant="destructive"
              type="submit"
              :disabled="processing"
            >
              <ShieldBan />
              Désactiver 2FA
            </Button>
          </Form>
        </div>
      </div>

      <TwoFactorSetupModal
        v-model:isOpen="showSetupModal"
        :requiresConfirmation="requiresConfirmation"
        :twoFactorEnabled="twoFactorEnabled"
      />
    </div>
  </SettingsLayout>
</template>
