<script setup lang="ts">
defineProps<{
    stats: {
        totalEvents: number
        ticketsSold: number
        remainingTickets: number
        sellThrough: number
    }
}>()
</script>

<template>
    <div class="min-h-screen bg-gray-100 px-6 py-10">
        <div class="mx-auto max-w-6xl">
            <h1 class="text-4xl font-bold text-gray-900">
                Admin Dashboard
            </h1>

            <p class="mt-2 text-gray-600">
                Ticketing performance overview for EpicPass.
            </p>

            <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl bg-white p-6 shadow">
                    <p class="text-sm text-gray-500">Total Events</p>
                    <p class="mt-3 text-4xl font-bold text-gray-900">
                        {{ stats.totalEvents }}
                    </p>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow">
                    <p class="text-sm text-gray-500">Tickets Sold</p>
                    <p class="mt-3 text-4xl font-bold text-indigo-600">
                        {{ stats.ticketsSold }}
                    </p>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow">
                    <p class="text-sm text-gray-500">Remaining Tickets</p>
                    <p class="mt-3 text-4xl font-bold text-green-600">
                        {{ stats.remainingTickets }}
                    </p>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow">
                    <p class="text-sm text-gray-500">Sell Through</p>
                    <p class="mt-3 text-4xl font-bold text-red-600">
                        {{ stats.sellThrough }}%
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>