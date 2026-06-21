<script setup lang="ts">
import { Link, router, Head } from '@inertiajs/vue3' // Ditambah Head untuk SEO & penamaan tab pelayar

defineProps<{
    events: {
        id: number
        title: string
        description: string
        total_tickets: number
        remaining_tickets: number
        event_date: string
    }[]
}>()

const deleteEvent = (eventId: number) => {
    if (!confirm('Delete this event? This action cannot be undone.')) {
        return
    }

    router.delete(`/admin/events/${eventId}`)
}
</script>

<template>
    <Head title="Admin Events Management" />

    <div class="min-h-screen bg-gray-950 px-6 py-12 text-white">
        <div class="mx-auto max-w-6xl">
            
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-4xl font-black tracking-tight text-white lg:text-5xl">
                        Admin Events
                    </h1>
                    <p class="mt-2 text-gray-400">
                        Monitor live availability pools, scale tickets, and command system-wide listings.
                    </p>
                </div>

                <div>
                    <Link
                        href="/admin/events/create"
                        class="inline-block rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 transition-all duration-200"
                    >
                        Create Event
                    </Link>
                </div>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-white/10 bg-white/5 shadow-2xl backdrop-blur-md">
                <table class="w-full text-left border-collapse">
                    <thead class="border-b border-white/10 bg-white/5 text-xs font-bold uppercase tracking-wider text-gray-400">
                        <tr>
                            <th class="px-6 py-4">Event Information</th>
                            <th class="px-6 py-4">Schedule Date</th>
                            <th class="px-6 py-4">Total Pool</th>
                            <th class="px-6 py-4">Remaining</th>
                            <th class="px-6 py-4">Sold</th>
                            <th class="px-6 py-4 text-right">Management Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5 text-sm">
                        <tr
                            v-for="event in events"
                            :key="event.id"
                            class="hover:bg-white/5 transition-colors duration-150"
                        >
                            <td class="px-6 py-5">
                                <p class="font-bold text-white text-base">
                                    {{ event.title }}
                                </p>
                                <p class="mt-1 max-w-md truncate text-sm text-gray-400">
                                    {{ event.description }}
                                </p>
                            </td>

                            <td class="px-6 py-5 text-gray-300 font-medium whitespace-nowrap">
                                {{ event.event_date }}
                            </td>

                            <td class="px-6 py-5 font-semibold text-gray-200">
                                {{ event.total_tickets }}
                            </td>

                            <td class="px-6 py-5 font-bold text-emerald-400">
                                {{ event.remaining_tickets }}
                            </td>

                            <td class="px-6 py-5 font-bold text-rose-400">
                                {{ event.total_tickets - event.remaining_tickets }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center justify-end gap-4">
                                    <Link
                                        :href="`/events/${event.id}`"
                                        class="text-xs font-bold uppercase tracking-wider text-gray-400 hover:text-white transition-colors duration-200"
                                    >
                                        View
                                    </Link>

                                    <Link
                                        :href="`/admin/events/${event.id}/edit`"
                                        class="text-xs font-bold uppercase tracking-wider text-indigo-400 hover:text-indigo-300 transition-colors duration-200"
                                    >
                                        Edit
                                    </Link>

                                    <button
                                        type="button"
                                        class="text-xs font-bold uppercase tracking-wider text-rose-400 hover:text-rose-300 transition-colors duration-200"
                                        @click="deleteEvent(event.id)"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="events.length === 0">
                            <td
                                colspan="6"
                                class="px-6 py-16 text-center text-gray-500 bg-gray-900/10"
                            >
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="text-4xl opacity-40">🎫</span>
                                    <p class="text-sm font-medium text-gray-400 mt-2">
                                        No high-traffic events registered in system yet.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>