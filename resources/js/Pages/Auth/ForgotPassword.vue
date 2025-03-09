<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Card from "@/Components/Card.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
});

const submit = () => {
  form.post(route("password.email"));
};
</script>

<template>
  <AppLayout>
    <Head title="Forgot Password" />

    <Card class="px-2 md:max-w-[500px] mx-auto mt-5">
      <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ $t("forgetPasswordMsg") }}
      </div>

      <div
        v-if="status"
        class="mb-4 text-sm font-medium text-green-600 dark:text-green-400"
      >
        {{ $t(status) }}
      </div>

      <form @submit.prevent="submit">
        <div>
          <InputLabel for="email" :value="$t('Email')" />

          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
          />

          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4 flex items-center justify-end">
          <PrimaryButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            {{ $t("Email Password Reset Link") }}
          </PrimaryButton>
        </div>
      </form>
    </Card>
  </AppLayout>
</template>
