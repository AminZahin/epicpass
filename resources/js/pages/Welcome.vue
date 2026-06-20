<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    BarChart3,
    Lock,
    Radio,
    Server,
    ShieldCheck,
} from '@lucide/vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { dashboard, login, register } from '@/routes';
</script>

<template>
    <Head title="EpicPass" />

    <div class="min-h-screen bg-gray-950 text-white">
        <header class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-3">
                    <AppLogoIcon class="h-12 w-12" />
                </div>

                <div>
                    <p class="text-lg font-bold leading-none">
                        EpicPass
                    </p>
                    <p class="text-xs text-gray-400">
                        Real-Time Ticketing Platform
                    </p>
                </div>
            </div>

            <nav class="flex items-center gap-3">
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-950 hover:bg-gray-200"
                >
                    Open App
                </Link>

                <template v-else>
                    <Link
                        :href="login()"
                        class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-300 hover:text-white"
                    >
                        Log in
                    </Link>

                    <Link
                        :href="register()"
                        class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-950 hover:bg-gray-200"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-20">
            <section class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <div
                        class="mb-6 inline-flex items-center gap-2 rounded-full border border-indigo-500/30 bg-indigo-500/10 px-4 py-2 text-sm text-indigo-200"
                    >
                        <Radio class="size-4" />
                        Live inventory updates powered by Laravel Reverb
                    </div>

                    <h1 class="max-w-3xl text-5xl font-black tracking-tight text-white lg:text-7xl">
                        High-concurrency ticketing without overselling.
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-8 text-gray-300">
                        EpicPass is a Laravel 13 event ticketing platform built to handle ticket rush scenarios using MySQL transactions, pessimistic locking, Pest tests, and real-time WebSocket updates.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <Link
                            v-if="$page.props.auth.user"
                            href="/events"
                            class="rounded-2xl bg-indigo-600 px-6 py-3 font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500"
                        >
                            View Events
                        </Link>

                        <template v-else>
                            <Link
                                :href="register()"
                                class="rounded-2xl bg-indigo-600 px-6 py-3 font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500"
                            >
                                Get Started
                            </Link>

                            <Link
                                :href="login()"
                                class="rounded-2xl border border-white/10 px-6 py-3 font-semibold text-white hover:bg-white/10"
                            >
                                Log in
                            </Link>
                        </template>

                        <a
                            href="https://github.com/AminZahin/epicpass"
                            target="_blank"
                            class="rounded-2xl border border-white/10 px-6 py-3 font-semibold text-white hover:bg-white/10"
                        >
                            View GitHub
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl">
                    <div class="rounded-2xl bg-gray-900 p-6">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">
                                    Live Event
                                </p>
                                <h2 class="text-xl font-bold">
                                    Epic Music Festival
                                </h2>
                            </div>

                            <span class="rounded-full bg-green-500/10 px-3 py-1 text-sm text-green-300">
                                Live
                            </span>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl bg-white/5 p-4">
                                <p class="text-sm text-gray-400">Total</p>
                                <p class="mt-2 text-3xl font-bold">100</p>
                            </div>

                            <div class="rounded-2xl bg-green-500/10 p-4">
                                <p class="text-sm text-green-300">Remaining</p>
                                <p class="mt-2 text-3xl font-bold text-green-300">87</p>
                            </div>

                            <div class="rounded-2xl bg-red-500/10 p-4">
                                <p class="text-sm text-red-300">Sold</p>
                                <p class="mt-2 text-3xl font-bold text-red-300">13</p>
                            </div>
                        </div>

                        <div class="mt-6 rounded-2xl bg-indigo-600 px-5 py-4 text-center font-semibold">
                            Buy Ticket
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-20 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <ShieldCheck class="mb-4 size-8 text-indigo-300" />
                    <h3 class="text-lg font-bold">Overselling Protection</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Prevents duplicate purchases when users compete for the final ticket.
                    </p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <Lock class="mb-4 size-8 text-indigo-300" />
                    <h3 class="text-lg font-bold">Pessimistic Locking</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Uses database row locks with Laravel transactions and lockForUpdate().
                    </p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <Radio class="mb-4 size-8 text-indigo-300" />
                    <h3 class="text-lg font-bold">Real-Time Updates</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Broadcasts inventory changes instantly with Laravel Reverb WebSockets.
                    </p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <BarChart3 class="mb-4 size-8 text-indigo-300" />
                    <h3 class="text-lg font-bold">Live Analytics</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Admin dashboard tracks sales, remaining inventory, and sell-through rate.
                    </p>
                </div>
            </section>

            <section class="mt-20 rounded-3xl border border-white/10 bg-white/5 p-8">
                <div class="flex items-center gap-3">
                    <Server class="size-8 text-indigo-300" />
                    <h2 class="text-2xl font-bold">
                        Built with production-minded engineering
                    </h2>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl bg-gray-900 p-5">
                        Laravel 13 + PHP 8.4
                    </div>
                    <div class="rounded-2xl bg-gray-900 p-5">
                        Inertia.js + Vue 3
                    </div>
                    <div class="rounded-2xl bg-gray-900 p-5">
                        MySQL Transactions
                    </div>
                    <div class="rounded-2xl bg-gray-900 p-5">
                        Laravel Reverb
                    </div>
                    <div class="rounded-2xl bg-gray-900 p-5">
                        Pest Feature Tests
                    </div>
                    <div class="rounded-2xl bg-gray-900 p-5">
                        Docker + Laravel Sail
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>