<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    title: '',
    description: '',
    total_tickets: 100,
    event_date: '',
})

const submit = () => {
    form.post('/admin/events')
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
                    Create Event
                </h1>

                <p class="mt-2 text-gray-600">
                    Add a new ticketed event to EpicPass.
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
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:outline-none"
                        />
                        <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Description
                        </label>
                        <textarea
                            v-model="form.description"
                            rows="5"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:outline-none"
                        />
                        <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Total Tickets
                        </label>
                        <input
                            v-model="form.total_tickets"
                            type="number"
                            min="1"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:outline-none"
                        />
                        <p v-if="form.errors.total_tickets" class="mt-2 text-sm text-red-600">
                            {{ form.errors.total_tickets }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Event Date
                        </label>
                        <input
                            v-model="form.event_date"
                            type="datetime-local"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:outline-none"
                        />
                        <p v-if="form.errors.event_date" class="mt-2 text-sm text-red-600">
                            {{ form.errors.event_date }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <Link
                        href="/admin/events"
                        class="rounded-xl border border-gray-300 px-5 py-3 font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white hover:bg-indigo-700 disabled:opacity-50"
                    >
                        <span v-if="form.processing">Creating...</span>
                        <span v-else>Create Event</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
