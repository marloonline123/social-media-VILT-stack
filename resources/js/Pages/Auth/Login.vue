<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <AppLayout>
    <Head :title="$t('Login')" />

    <Card class="px-2 md:max-w-[500px] mx-auto mt-5" :title="$t('Login')">
      <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
        {{ status }}
      </div>

      <form @submit.prevent="submit">
        <div class="bg-transparent">
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

        <div class="mt-4">
          <InputLabel for="password" :value="$t('Password')" />

          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="current-password"
          />

          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4 block">
          <label class="flex items-center">
            <Checkbox name="remember" v-model:checked="form.remember" />
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{
              $t("Remember me")
            }}</span>
          </label>
        </div>

        <div class="mt-4 flex items-center justify-end">
          <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
          >
            {{ $t("Forgot your password?") }}
          </Link>

          <PrimaryButton
            class="ms-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            {{ $t("Login") }}
          </PrimaryButton>
        </div>
      </form>
    </Card>
  </AppLayout>
</template>
