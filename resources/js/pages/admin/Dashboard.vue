<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { onMounted, reactive } from 'vue'

type FeaturedEvent = {
    title: string
    sold?: number
    remaining?: number
} | null

const props = defineProps<{
    stats: {
        totalEvents: number
        ticketsSold: number
        remainingTickets: number
        totalCapacity: number
        sellThrough: number
        soldOutEvents: number
        highestSellingEvent: FeaturedEvent
        lowestInventoryEvent: FeaturedEvent
    }
}>()

// Menyalin prop asal ke dalam objek reaktif
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
            analytics: typeof props.stats
        }) => {
            if (!payload || !payload.analytics) return

            const data = payload.analytics

            // Pengesahan & Pemutihan Jenis Data (Type Casting)
            stats.totalEvents = Number(data.totalEvents)
            stats.ticketsSold = Number(data.ticketsSold)
            stats.remainingTickets = Number(data.remainingTickets)
            stats.totalCapacity = Number(data.totalCapacity)
            stats.sellThrough = Number(data.sellThrough)
            stats.soldOutEvents = Number(data.soldOutEvents)

            // Menguruskan pertukaran objek nullable dengan selamat
            stats.highestSellingEvent = data.highestSellingEvent 
                ? { ...data.highestSellingEvent, sold: Number(data.highestSellingEvent.sold ?? 0) }
                : null

            stats.lowestInventoryEvent = data.lowestInventoryEvent
                ? { ...data.lowestInventoryEvent, remaining: Number(data.lowestInventoryEvent.remaining ?? 0) }
                : null
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
                        Ticketing performance and live inventory overview for EpicPass.
                    </p>
                </div>

                <div class="self-start sm:self-center">
                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1.5 text-xs font-semibold tracking-wider text-emerald-400 uppercase">
                        <span class="h-2 w-2 animate-ping rounded-full bg-emerald-400"></span>
                        Reverb Engine Connected
                    </span>
                </div>
            </div>

            <div class="mt-8">
                <Link
                    href="/admin/events"
                    class="inline-flex rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 transition-all duration-200"
                >
                    Manage Events &rarr;
                </Link>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-md">
                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">Total Events</p>
                    <p class="mt-4 text-5xl font-black tracking-tight text-white">{{ stats.totalEvents }}</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-md">
                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">Tickets Sold</p>
                    <p class="mt-4 text-5xl font-black tracking-tight text-indigo-400">{{ stats.ticketsSold }}</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-md">
                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">Remaining Tickets</p>
                    <p class="mt-4 text-5xl font-black tracking-tight text-emerald-400">{{ stats.remainingTickets }}</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-md">
                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">Sell Through Rate</p>
                    <p class="mt-4 text-5xl font-black tracking-tight text-fuchsia-400">{{ stats.sellThrough }}%</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 md:grid-cols-3">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">Total Capacity</p>
                    <p class="mt-4 text-4xl font-black text-white">{{ stats.totalCapacity }}</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">Sold Out Events</p>
                    <p class="mt-4 text-4xl font-black text-rose-400">{{ stats.soldOutEvents }}</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">Inventory Health</p>
                    <p class="mt-4 text-4xl font-black" :class="stats.remainingTickets > 0 ? 'text-emerald-400' : 'text-rose-400'">
                        {{ stats.remainingTickets > 0 ? 'Active' : 'Sold Out' }}
                    </p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 transition-all hover:border-indigo-500/20">
                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">Highest Selling Event</p>
                    <template v-if="stats.highestSellingEvent">
                        <p class="mt-4 text-2xl font-black tracking-tight text-white">{{ stats.highestSellingEvent.title }}</p>
                        <p class="mt-2 text-sm text-indigo-400 font-medium">
                            🔥 {{ stats.highestSellingEvent.sold }} tickets secured
                        </p>
                    </template>
                    <p v-else class="mt-4 text-sm text-gray-500 italic">No transactions recorded yet.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 transition-all hover:border-rose-500/20">
                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">Lowest Inventory Event</p>
                    <template v-if="stats.lowestInventoryEvent">
                        <p class="mt-4 text-2xl font-black tracking-tight text-white">{{ stats.lowestInventoryEvent.title }}</p>
                        <p class="mt-2 text-sm text-rose-400 font-medium">
                            🔥 Only {{ stats.lowestInventoryEvent.remaining }} passes left
                        </p>
                    </template>
                    <p v-else class="mt-4 text-sm text-gray-500 italic">No critical depletion detected.</p>
                </div>
            </div>

        </div>
    </div>
</template>