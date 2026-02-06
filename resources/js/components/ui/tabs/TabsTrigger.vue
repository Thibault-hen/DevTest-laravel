<script setup lang="ts">
import type { TabsTriggerProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { reactiveOmit } from "@vueuse/core"
import { TabsTrigger, useForwardProps } from "reka-ui"
import { cn } from "@/lib/utils"

const props = defineProps<TabsTriggerProps & { class?: HTMLAttributes["class"] }>()

const delegatedProps = reactiveOmit(props, "class")

const forwardedProps = useForwardProps(delegatedProps)
</script>

<template>
  <TabsTrigger
    v-bind="forwardedProps"
    :class="cn(
      'group relative inline-flex items-center justify-center whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-all duration-200',
      'ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2',
      'disabled:pointer-events-none disabled:opacity-50',
      'text-muted-foreground hover:text-foreground',
      'data-[state=active]:text-foreground data-[state=active]:font-semibold',
      'before:absolute before:bottom-0 before:left-0 before:right-0 before:h-0.5 before:bg-primary before:transition-all before:duration-200',
      'before:scale-x-0 data-[state=active]:before:scale-x-100',
      'hover:bg-muted/50',
      props.class,
    )"
  >
    <span class="relative z-10 truncate">
      <slot />
    </span>
  </TabsTrigger>
</template>
