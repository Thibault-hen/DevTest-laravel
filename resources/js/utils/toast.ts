import { Check, X } from 'lucide-vue-next';
import { h } from 'vue';
import { toast } from 'vue-sonner';

export const successToast = (message: string, options?: { title?: string }) => {
  const title = options?.title || 'Succès';

  toast.success(title, {
    description: message,
    duration: 8000,
    class: '!border-l-primary !border-l-6 !rounded-l-xs !bg-card',
    icon: () => h(Check, { class: '!text-primary', size: 18 }),
  });
};

export const errorToast = (message: string, options?: { title?: string }) => {
  const title = options?.title || 'Erreur';

  toast.error(title, {
    description: message,
    duration: 5000,
    class: '!border-l-red-600 !border-l-6 !rounded-l-xs !bg-card',
    icon: () => h(X, { class: '!text-red-600', size: 18 }),
  });
};
