<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue'; // Ditambah untuk konsistensi jenama
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';

defineProps<{
    passwordRules: string;
}>();

defineOptions({
    layout: {
        title: 'Create an account',
        description: 'Enter your details below to create your account',
    },
});
</script>

<template>
    <Head title="Register" />

    <div class="mx-auto w-full max-w-md rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur-md">
        
        <div class="mb-8 flex flex-col items-center gap-2 text-center">
            <AppLogoIcon class="h-12 w-12" />
            <h2 class="mt-3 text-2xl font-black tracking-tight text-white">
                Join EpicPass
            </h2>
            <p class="text-sm text-gray-400">
                Create your account to access real-time ticket inventory
            </p>
        </div>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-5">
                <div class="grid gap-2">
                    <Label for="name" class="text-sm font-semibold text-gray-300">Name</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder="Full name"
                        class="rounded-xl border-white/10 bg-gray-900 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-semibold text-gray-300">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        placeholder="email@example.com"
                        class="rounded-xl border-white/10 bg-gray-900 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password" class="text-sm font-semibold text-gray-300">Password</Label>
                    <PasswordInput
                        id="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Password"
                        :passwordrules="passwordRules"
                        class="rounded-xl border-white/10 bg-gray-900 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation" class="text-sm font-semibold text-gray-300">Confirm password</Label>
                    <PasswordInput
                        id="password_confirmation"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                        :passwordrules="passwordRules"
                        class="rounded-xl border-white/10 bg-gray-900 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full rounded-2xl bg-indigo-600 py-3 font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 transition-all duration-200"
                    tabindex="5"
                    :disabled="processing"
                    data-test="register-user-button"
                >
                    <Spinner v-if="processing" class="mr-2" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-gray-400">
                Already have an account?
                <TextLink
                    :href="login()"
                    class="ml-1 font-semibold text-indigo-400 hover:text-indigo-300 underline underline-offset-4"
                    :tabindex="6"
                >
                    Log in
                </TextLink>
            </div>
        </Form>
    </div>
</template>