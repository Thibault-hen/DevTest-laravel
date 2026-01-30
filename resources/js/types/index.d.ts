import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';
import { CreateOrUpdateQuizData, SpecializationData } from './generated';
export interface Auth {
  user: User;
}

interface CreateOrUpdateQuizFormData extends Omit<CreateOrUpdateQuizData, 'id'> {
  themes_ids: string[];
}

type FlashMessage = {
  flash?: {
    success?: string;
    error?: string;
  };
};

export interface BreadcrumbItem {
  title: string;
  href: string;
}

export interface HomepageCounter {
  count: number;
  label: string;
  label2: string;
  icon: LucideIcon | null;
}

interface TechLogo {
  name: string;
  src: string;
  alt: string;
  color?: string;
}

export interface NavItem {
  title: string;
  href: NonNullable<InertiaLinkProps['href']>;
  icon?: LucideIcon;
  isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  name: string;
  quote: { message: string; author: string };
  auth: Auth;
  sidebarOpen: boolean;
};

export interface User {
  id: string;
  name: string;
  email: string;
  avatar: string | undefined;
  is_admin: boolean;
  email_verified_at: string | null;
  created_at: string;
  updated_at: string;
  specialization: SpecializationData;
}

export interface ResultPercentageDataChart {
  name: string;
  value: number;
}

export interface FeedbackMessage {
  emoji: string;
  message: string;
  description: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface RatingErrors {
  ratingAlreadyExists?: string;
  comment?: string;
  score?: string;
  quiz_id?: string;
}

declare module '@tanstack/vue-table' {
  interface ColumnMeta<TData, TValue> {
    title?: string;
  }
}
