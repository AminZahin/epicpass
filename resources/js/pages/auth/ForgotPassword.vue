<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue'; // Ditambah untuk keseragaman jenama
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { email } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Forgot password',
        description: 'Enter your email to receive a password reset link',
    },
});

defineProps<{
    status?: string;
}>();
</script>

<template>
    <Head title="Forgot password" />

    <div class="mx-auto w-full max-w-md rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur-md">
        
        <div class="mb-8 flex flex-col items-center gap-2 text-center">
            <AppLogoIcon class="h-12 w-12" />
            <h2 class="mt-3 text-2xl font-black tracking-tight text-white">
                Reset Password
            </h2>
            <p class="text-sm text-gray-400">
                Enter your email to receive a password reset link
            </p>
        </div>

        <div
            v-if="status"
            class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-2 text-center text-sm font-medium text-green-400"
        >
            {{ status }}
        </div>

        <Form v-bind="email.form()" v-slot="{ errors, processing }" class="flex flex-col gap-6">
            <div class="grid gap-5">
                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-semibold text-gray-300">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="off"
                        autofocus
                        placeholder="email@example.com"
                        class="rounded-xl border-white/10 bg-gray-900 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="errors.email" />
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full rounded-2xl bg-indigo-600 py-3 font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 transition-all duration-200"
                    :disabled="processing"
                    data-test="email-password-reset-link-button"
                >
                    <Spinner v-if="processing" class="mr-2" />
                    Email password reset link
                </Button>
            </div>
        </Form>

        <div class="mt-6 text-center text-sm text-gray-400">
            <span>Or, return to </span>
            <TextLink 
                :href="login()"
                class="font-semibold text-indigo-400 hover:text-indigo-300 underline underline-offset-4"
            >
                log in
            </TextLink>
        </div>
    </div>
</template>