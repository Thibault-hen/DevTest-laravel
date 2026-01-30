<script setup lang="ts">
import UserAvatar from '@/components/settings/user/UserAvatar.vue';
import { AdminBadge, TwoFactorConfirmedBadge, UserRoleBadge, VerifiedEmailBadge } from '@/components/shared/badges';
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import Button from '@/components/ui/button/Button.vue';
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { UserData } from '@/types/generated';

const props = defineProps<{
  user: UserData | null;
}>();

const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};
</script>

<template>
  <Dialog v-model:open="model">
    <DialogContent class="sm:max-w-xl p-0 lg:min-w-3xl max-h-[90vh] overflow-y-auto">
      <DialogHeader class="pt-6 px-6">
        <DialogTitle>
          <HeadingSmall
            title="Détails utilisateur"
            description="Voici les informations en détail pour cet utilisateur"
          />
          <DialogDescription class="sr-only"> Voici les informations en détail pour cet utilisateur </DialogDescription>
        </DialogTitle>
      </DialogHeader>

      <div
        class="px-6 py-4 flex flex-col gap-6"
        v-if="props.user"
      >
        <!-- Avatar + Name + Admin Badge -->
        <div class="flex items-center gap-4">
          <UserAvatar
            :user="props.user"
            class="h-16 w-16"
          />
          <div class="flex flex-col">
            <div class="flex items-center gap-2">
              <span class="text-lg font-semibold">
                {{ props.user?.name ?? 'Utilisateur supprimé' }}
              </span>
              <AdminBadge
                v-if="props.user?.is_admin"
                :user="props.user"
              />
            </div>
            <span class="text-sm text-muted-foreground">{{ props.user?.email }}</span>
          </div>
        </div>

        <!-- User Info Grid -->
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
          <div>
            <span class="text-xs text-muted-foreground">Spécialisation</span>
            <UserRoleBadge
              v-if="props.user.specialization"
              :specialization="props.user.specialization"
            />
            <span
              v-else
              class="flex font-medium"
              >Aucune</span
            >
          </div>
          <div>
            <span class="text-xs text-muted-foreground">Créé le</span>
            <p class="font-medium">{{ props.user?.created_at }}</p>
          </div>
          <div>
            <span class="text-xs text-muted-foreground">Dernière mise à jour</span>
            <p class="font-medium">{{ props.user?.updated_at }}</p>
          </div>
          <div class="flex flex-col">
            <span class="text-xs text-muted-foreground mb-2">Email vérifié</span>
            <VerifiedEmailBadge :user="props.user" />
          </div>
          <div class="flex flex-col">
            <span class="text-xs text-muted-foreground mb-2">2FA activé</span>
            <TwoFactorConfirmedBadge :user="props.user" />
          </div>
        </div>
      </div>

      <DialogFooter class="border-t p-4">
        <div class="flex justify-end gap-2">
          <DialogClose as-child>
            <Button
              type="button"
              variant="outline"
              @click="closeDialog"
            >
              Retour
            </Button>
          </DialogClose>
        </div>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
