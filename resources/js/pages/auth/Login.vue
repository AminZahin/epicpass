<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue'; // Ditambah untuk konsistensi jenama
import InputError from '@/components/InputError.vue';
import PasskeyVerify from '@/components/PasskeyVerify.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Log in to your account',
        description: 'Enter your email and password below to log in',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <Head title="Log in" />

    <div class="mx-auto w-full max-w-md rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur-md">
        
        <div class="mb-8 flex flex-col items-center gap-2 text-center">
            <AppLogoIcon class="h-12 w-12" />
            <h2 class="mt-3 text-2xl font-black tracking-tight text-white">
                Welcome Back
            </h2>
            <p class="text-sm text-gray-400">
                Log in to your EpicPass account
            </p>
        </div>

        <div
            v-if="status"
            class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-2 text-center text-sm font-medium text-green-400"
        >
            {{ status }}
        </div>

        <PasskeyVerify class="mb-4" />

        <Form
            v-bind="store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-5">
                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-semibold text-gray-300">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                        class="rounded-xl border-white/10 bg-gray-900 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="text-sm font-semibold text-gray-300">Password</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 underline underline-offset-4"
                            :tabindex="5"
                        >
                            Forgot your password?
                        </TextLink>
                    </div>
                    <PasswordInput
                        id="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Password"
                        class="rounded-xl border-white/10 bg-gray-900 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3 text-sm font-medium text-gray-300 cursor-pointer">
                        <Checkbox 
                            id="remember" 
                            name="remember" 
                            :tabindex="3" 
                            class="rounded border-white/20 bg-gray-900 data-[state=checked]:bg-indigo-600 data-[state=checked]:border-indigo-600"
                        />
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full rounded-2xl bg-indigo-600 py-3 font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 transition-all duration-200"
                    :tabindex="4"
                    :disabled="processing"
                    data-test="login-button"
                >
                    <Spinner v-if="processing" class="mr-2" />
                    Log in
                </Button>
            </div>

            <div class="text-center text-sm text-gray-400">
                Don't have an account?
                <TextLink 
                    :href="register()" 
                    class="ml-1 font-semibold text-indigo-400 hover:text-indigo-300 underline underline-offset-4"
                    :tabindex="5"
                >
                    Sign up
                </TextLink>
            </div>
        </Form>
    </div>
</template>