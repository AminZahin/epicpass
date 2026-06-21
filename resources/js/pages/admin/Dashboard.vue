<script setup lang="ts">
import { Head } from '@inertiajs/vue3' // Ditambah untuk pengurusan tajuk tab pelayar
import { onMounted, reactive } from 'vue'

const props = defineProps<{
    stats: {
        totalEvents: number
        ticketsSold: number
        remainingTickets: number
        sellThrough: number
    }
}>()

const stats = reactive({ ...props.stats })

onMounted(async () => {
    const Echo = (await import('laravel-echo')).default
    const Pusher = (await import('pusher-js')).default

    const echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
        wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
        wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
        enabledTransports: ['ws', 'wss'],
        Pusher,
    })

    echo.channel('analytics.dashboard').listen(
        '.ticket.inventory.updated',
        (payload: {
            analytics: {
                totalEvents: number
                ticketsSold: number
                remainingTickets: number
                sellThrough: number
            }
        }) => {
            stats.totalEvents = payload.analytics.totalEvents
            stats.ticketsSold = payload.analytics.ticketsSold
            stats.remainingTickets = payload.analytics.remainingTickets
            stats.sellThrough = payload.analytics.sellThrough
        },
    )
})
</script>

<template>
    <Head title="Admin Dashboard - Live Analytics" />

    <div class="min-h-screen bg-gray-950 px-6 py-12 text-white">
        <div class="mx-auto max-w-6xl">
            
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-4xl font-black tracking-tight text-white lg:text-5xl">
                        Admin Dashboard
                    </h1>
                    <p class="mt-2 text-gray-400">
                        Ticketing performance and infrastructure stream overview for EpicPass.
                    </p>
                </div>

                <div class="self-start sm:self-center">
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1.5 text-xs font-semibold text-emerald-400 border border-emerald-500/20 tracking-wider uppercase">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Reverb Engine Connected
                    </span>
                </div>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-md transition-all duration-300 hover:border-white/20">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Total Events
                    </p>
                    <p class="mt-4 text-5xl font-black tracking-tight text-white">
                        {{ stats.totalEvents }}
                    </p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-md transition-all duration-300 hover:border-indigo-500/30">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Tickets Sold
                    </p>
                    <p class="mt-4 text-5xl font-black tracking-tight text-indigo-400 drop-shadow-[0_0_15px_rgba(129,140,248,0.25)]">
                        {{ stats.ticketsSold }}
                    </p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-md transition-all duration-300 hover:border-emerald-500/30">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Remaining Tickets
                    </p>
                    <p class="mt-4 text-5xl font-black tracking-tight text-emerald-400 drop-shadow-[0_0_15px_rgba(52,211,153,0.25)]">
                        {{ stats.remainingTickets }}
                    </p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-md transition-all duration-300 hover:border-fuchsia-500/30">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Sell Through Rate
                    </p>
                    <p class="mt-4 text-5xl font-black tracking-tight text-fuchsia-400 drop-shadow-[0_0_15px_rgba(232,121,249,0.25)]">
                        {{ stats.sellThrough }}%
                    </p>
                </div>
                
            </div>
        </div>
    </div>
</template>