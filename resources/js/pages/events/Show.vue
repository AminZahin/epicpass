<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3'
import axios from 'axios'
import { computed, onMounted, ref } from 'vue'

const props = defineProps<{
    event: {
        id: number
        title: string
        description: string
        total_tickets: number
        remaining_tickets: number
    }
}>()

// Pastikan nilai awal adalah berjenis Number
const remainingTickets = ref(Number(props.event.remaining_tickets))
const message = ref('')
const error = ref('')
const isBuying = ref(false)

const soldTickets = computed(() => {
    // Memastikan operasi matematik hanya melibatkan Number tulen
    const total = Number(props.event.total_tickets)
    const remaining = Number(remainingTickets.value)
    
    if (isNaN(total) || isNaN(remaining)) {
return 0
}

    return total - remaining
})

const buyTicket = async () => {
    message.value = ''
    error.value = ''
    isBuying.value = true

    try {
        const response = await axios.post(`/events/${props.event.id}/purchase`)
        message.value = 'Pass secured successfully! Check your gateway wallet.'
        
        // OPTIMIS: Jika backend memulangkan baki tiket baru dalam response.data, kemas kini terus di sini
        if (response.data && response.data.remaining_tickets !== undefined) {
            remainingTickets.value = Number(response.data.remaining_tickets)
        } else {
            // Jika backend tidak memulangkan data, kita tolak 1 secara manual untuk tindak balas segera
            if (remainingTickets.value > 0) {
                remainingTickets.value -= 1
            }
        }
    } catch (e: unknown) {
        if (axios.isAxiosError(e)) {
            error.value =
                e.response?.data?.message || 'Transaction declined. Pool might be exhausted.'
        } else {
            error.value = 'Unable to process purchase at this moment.'
        }
    } finally {
        isBuying.value = false
    }
}

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

    echo.channel(`events.${props.event.id}`).listen(
        '.ticket.inventory.updated',
        (payload: {
            event_id: number
            total_tickets: number
            remaining_tickets: number
            sold_tickets: number
        }) => {
            // PENCEGAHAN UTAMA: Paksa payload menjadi Number untuk mengelakkan ralat NaN
            if (payload && payload.remaining_tickets !== undefined) {
                remainingTickets.value = Number(payload.remaining_tickets)
            }
        },
    )
})
</script>

<template>
    <Head :title="`${event.title} - Secure Passes`" />

    <div class="min-h-screen bg-gray-950 px-6 py-12 text-white">
        <div class="mx-auto max-w-3xl">
            
            <div class="mb-6">
                <Link
                    href="/events"
                    class="text-sm font-semibold text-indigo-400 hover:text-indigo-300 transition-colors duration-200"
                >
                    &larr; Return to Catalog
                </Link>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur-md">
                
                <div class="mb-4 inline-flex items-center gap-1.5 rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-medium text-indigo-400 border border-indigo-500/20">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                    Live Inventory Connection Active
                </div>

                <h1 class="text-3xl font-black tracking-tight text-white sm:text-4xl">
                    {{ event.title }}
                </h1>

                <p class="mt-4 text-base leading-relaxed text-gray-300">
                    {{ event.description }}
                </p>

                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/5 bg-gray-900/50 p-5 text-center">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Capacity</p>
                        <p class="mt-2 text-3xl font-black text-white">
                            {{ event.total_tickets }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-5 text-center">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-400">Remaining Available</p>
                        <p class="mt-2 text-3xl font-black text-emerald-400 drop-shadow-[0_0_10px_rgba(52,211,153,0.15)]">
                            {{ remainingTickets }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 p-5 text-center">
                        <p class="text-xs font-bold uppercase tracking-wider text-rose-400">Claimed Passes</p>
                        <p class="mt-2 text-3xl font-black text-rose-400">
                            {{ soldTickets }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-white/10">
                    <button
                        type="button"
                        :disabled="isBuying || remainingTickets <= 0"
                        class="w-full sm:w-auto min-w-[200px] rounded-xl bg-indigo-600 px-6 py-4 font-bold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 disabled:opacity-40 disabled:cursor-not-allowed disabled:bg-gray-800 disabled:shadow-none transition-all duration-200 flex items-center justify-center gap-2"
                        @click="buyTicket"
                    >
                        <svg v-if="isBuying" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        
                        <span v-if="isBuying">Securing Pass...</span>
                        <span v-else-if="remainingTickets <= 0">Sold Out</span>
                        <span v-else>Instant Purchase &rarr;</span>
                    </button>
                </div>

                <div v-if="message" class="mt-6 rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm font-medium text-emerald-400 flex items-center gap-2">
                    <span>🎉</span> {{ message }}
                </div>

                <div v-if="error" class="mt-6 rounded-xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm font-medium text-rose-400 flex items-center gap-2">
                    <span>⚠️</span> {{ error }}
                </div>
                
            </div>
        </div>
    </div>
</template>