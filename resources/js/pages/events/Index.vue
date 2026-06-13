<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

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
    <div class="min-h-screen bg-gray-100 px-6 py-10">
        <div class="mx-auto max-w-6xl">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900">
                    Events
                </h1>
                <p class="mt-2 text-gray-600">
                    Browse available events and purchase tickets safely.
                </p>
            </div>

            <div
                v-if="events.length"
                class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
            >
                <div
                    v-for="event in events"
                    :key="event.id"
                    class="rounded-2xl bg-white p-6 shadow"
                >
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ event.title }}
                    </h2>

                    <p class="mt-3 text-sm text-gray-600">
                        {{ event.description }}
                    </p>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-xs text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ event.total_tickets }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-green-50 p-4">
                            <p class="text-xs text-green-700">Remaining</p>
                            <p class="text-2xl font-bold text-green-700">
                                {{ event.remaining_tickets }}
                            </p>
                        </div>
                    </div>

                    <Link
                        :href="`/events/${event.id}`"
                        class="mt-6 inline-block rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-700"
                    >
                        View Event
                    </Link>
                </div>
            </div>

            <div
                v-else
                class="rounded-2xl bg-white p-8 text-center shadow"
            >
                <p class="text-gray-600">
                    No events available yet.
                </p>
            </div>
        </div>
    </div>
</template>
