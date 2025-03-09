<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import Title from "@/Components/Title.vue";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  gender: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <AppLayout>
    <Head :title="$t('Register')" />

    <Card class="px-2 md:max-w-[500px] mx-auto mt-2" :title="$t('Register')">
      <form @submit.prevent="submit">
        <div class="">
          <InputLabel for="name" :value="$t('Name')" />

          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
          />

          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
          <InputLabel for="email" :value="$t('Email')" />

          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
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
            autocomplete="new-password"
          />

          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
          <InputLabel for="password_confirmation" :value="$t('Confirm Password')" />

          <TextInput
            id="password_confirmation"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
          />

          <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <div class="mt-4">
          <Title>{{ $t("Gender") }}</Title>

          <div class="flex gap-2 mt-2">
            <!-- Male -->
            <div>
              <input
                v-model="form.gender"
                class="peer hidden"
                type="radio"
                id="gender-male"
                name="gender"
                value="male"
              />
              <label
                for="gender-male"
                class="flex items-center gap-2 cursor-pointer border-2 peer-checked:ring-2 peer-checked:ring-blue-500 rounded-md py-2 px-4 bg-slate-100 dark:bg-slate-700 transition"
              >
                <span>{{ $t("Male") }}</span>
              </label>
            </div>

            <!-- Female -->
            <div>
              <input
                v-model="form.gender"
                class="peer hidden"
                type="radio"
                id="gender-female"
                name="gender"
                value="female"
              />
              <label
                for="gender-female"
                class="flex items-center gap-2 cursor-pointer border-2 peer-checked:ring-2 peer-checked:ring-blue-500 rounded-md py-2 px-4 bg-slate-100 dark:bg-slate-700 transition"
              >
                <span>{{ $t("Female") }}</span>
              </label>
            </div>
          </div>

          <InputError class="mt-2" :message="form.errors.gender" />
        </div>

        <div class="mt-4 flex items-center justify-end">
          <Link
            :href="route('login')"
            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
          >
            {{ $t("Already registered?") }}
          </Link>

          <PrimaryButton
            class="ms-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            {{ $t("Register") }}
          </PrimaryButton>
        </div>
      </form>
    </Card>
  </AppLayout>
</template>
