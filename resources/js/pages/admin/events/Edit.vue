<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps<{
    event: {
        id: number
        title: string
        description: string
        total_tickets: number
        event_date: string
    }
}>()

const form = useForm({
    title: props.event.title,
    description: props.event.description,
    total_tickets: props.event.total_tickets,
    event_date: props.event.event_date.replace(' ', 'T').slice(0, 16),
})

const submit = () => {
    form.put(`/admin/events/${props.event.id}`)
}
</script>

<template>
    <div class="min-h-screen bg-gray-100 px-6 py-10">
        <div class="mx-auto max-w-3xl">
            <div class="mb-8">
                <Link
                    href="/admin/events"
                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-800"
                >
                    ← Back to Admin Events
                </Link>

                <h1 class="mt-4 text-4xl font-bold text-gray-900">
                    Edit Event
                </h1>

                <p class="mt-2 text-gray-600">
                    Update event details.
                </p>
            </div>

            <form
                class="rounded-2xl bg-white p-8 shadow"
                @submit.prevent="submit"
            >
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Title
                        </label>
                        <input
                            v-model="form.title"
                            type="text"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Description
                        </label>
                        <textarea
                            v-model="form.description"
                            rows="5"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Total Tickets
                        </label>
                        <input
                            v-model="form.total_tickets"
                            type="number"
                            min="1"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Event Date
                        </label>
                        <input
                            v-model="form.event_date"
                            type="datetime-local"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        />
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <Link
                        href="/admin/events"
                        class="rounded-xl border border-gray-300 px-5 py-3 font-semibold"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
