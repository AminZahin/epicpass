<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3' // Ditambah Head untuk SEO & nama tab pelayar yang mesra pengguna

defineProps<{
    events: {
        id: number
        title: string
        description: string
        total_tickets: number
        remaining_tickets: number
    }[]
}>()
</script>

<template>
    <Head title="Explore Premium Events" />

    <div class="min-h-screen bg-gray-950 px-6 py-12 text-white">
        <div class="mx-auto max-w-6xl">
            
            <div class="mb-10">
                <h1 class="text-4xl font-black tracking-tight text-white lg:text-5xl">
                    Discover Events
                </h1>
                <p class="mt-2 text-gray-400">
                    Browse premium active listings, track live seat availability, and secure your access instantly.
                </p>
            </div>

            <div
                v-if="events.length"
                class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
            >
                <div
                    v-for="event in events"
                    :key="event.id"
                    class="flex flex-col justify-between rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:border-white/20 hover:bg-white/10"
                >
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight text-white">
                            {{ event.title }}
                        </h2>

                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-gray-400">
                            {{ event.description }}
                        </p>
                    </div>

                    <div>
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="rounded-xl border border-white/5 bg-gray-900/50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Pool</p>
                                <p class="mt-1 text-2xl font-black text-gray-200">
                                    {{ event.total_tickets }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-400">Remaining</p>
                                <p class="mt-1 text-2xl font-black text-emerald-400">
                                    {{ event.remaining_tickets }}
                                </p>
                            </div>
                        </div>

                        <Link
                            :href="`/events/${event.id}`"
                            class="mt-6 block w-full text-center rounded-xl bg-indigo-600 px-4 py-3 font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 transition-all duration-200"
                        >
                            Get Passes &rarr;
                        </Link>
                    </div>
                </div>
            </div>

            <div
                v-else
                class="rounded-3xl border border-white/10 bg-white/5 p-16 text-center shadow-2xl backdrop-blur-md"
            >
                <div class="flex flex-col items-center justify-center gap-3">
                    <span class="text-5xl opacity-50">✨</span>
                    <h3 class="text-xl font-bold text-white mt-2">No Live Events Available</h3>
                    <p class="max-w-md text-sm text-gray-400 leading-relaxed">
                        We are currently curating brand new premium experiences. Check back shortly for upcoming exclusive ticket drops.
                    </p>
                </div>
            </div>

        </div>
    </div>
</template>