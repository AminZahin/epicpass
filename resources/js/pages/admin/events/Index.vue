<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3'

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
    <div class="min-h-screen bg-gray-100 px-6 py-10">
        <div class="mx-auto max-w-6xl">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">
                        Admin Events
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Create, update, and manage ticketed events.
                    </p>
                </div>

                <Link
                    href="/admin/events/create"
                    class="rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white hover:bg-indigo-700"
                >
                    Create Event
                </Link>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-sm text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Event</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Remaining</th>
                            <th class="px-6 py-4">Sold</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        <tr
                            v-for="event in events"
                            :key="event.id"
                        >
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">
                                    {{ event.title }}
                                </p>
                                <p class="mt-1 max-w-md truncate text-sm text-gray-500">
                                    {{ event.description }}
                                </p>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ event.event_date }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ event.total_tickets }}
                            </td>

                            <td class="px-6 py-4 font-medium text-green-600">
                                {{ event.remaining_tickets }}
                            </td>

                            <td class="px-6 py-4 font-medium text-red-600">
                                {{ event.total_tickets - event.remaining_tickets }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-3">
                                    <Link
                                        :href="`/events/${event.id}`"
                                        class="text-sm font-semibold text-gray-600 hover:text-gray-900"
                                    >
                                        View
                                    </Link>

                                    <Link
                                        :href="`/admin/events/${event.id}/edit`"
                                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-800"
                                    >
                                        Edit
                                    </Link>

                                    <button
                                        type="button"
                                        class="text-sm font-semibold text-red-600 hover:text-red-800"
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
                                class="px-6 py-10 text-center text-gray-500"
                            >
                                No events created yet.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
