<script setup>
import { computed } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";

const props = defineProps({
  status: {
    type: String,
  },
});

const form = useForm({});

const submit = () => {
  form.post(route("verification.send"));
};

const verificationLinkSent = computed(() => props.status === "verification-link-sent");
</script>

<template>
  <AppLayout>
    <Head title="Email Verification" />

    <Card class="px-2 md:max-w-[500px] mx-auto mt-5">
      <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ $t("resendVerficationMsg") }}
      </div>

      <div
        class="mb-4 text-sm font-medium text-green-600 dark:text-green-400"
        v-if="verificationLinkSent"
      >
        {{ $t("verificationLinkSent") }}
      </div>

      <form @submit.prevent="submit">
        <div class="mt-4 flex items-center justify-between">
          <PrimaryButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            {{ $t("Resend Verification Email") }}
          </PrimaryButton>

          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
          >
            {{ $t("Logout") }}</Link
          >
        </div>
      </form>
    </Card>
  </AppLayout>
</template>
