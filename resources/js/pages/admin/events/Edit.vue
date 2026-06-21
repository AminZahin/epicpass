<script setup lang="ts">
import { Link, useForm, Head } from '@inertiajs/vue3' // Ditambah Head untuk pengurusan tajuk dinamik

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
    <Head :title="`Edit Event - ${form.title}`" />

    <div class="min-h-screen bg-gray-950 px-6 py-12 text-white">
        <div class="mx-auto max-w-3xl">
            <!-- Header Section -->
            <div class="mb-8">
                <Link
                    href="/admin/events"
                    class="text-sm font-semibold text-indigo-400 hover:text-indigo-300 transition-colors duration-200 flex items-center gap-1"
                >
                    ← Back to Admin Events
                </Link>

                <h1 class="mt-4 text-4xl font-black tracking-tight text-white lg:text-5xl">
                    Edit Event
                </h1>

                <p class="mt-2 text-gray-400">
                    Modify the configurations or detail sets for this event. Changes will reflect instantly across the gateway.
                </p>
            </div>

            <!-- Glassmorphic Form Container -->
            <form
                class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur-md"
                @submit.prevent="submit"
            >
                <div class="space-y-6">
                    <!-- Event Title Input -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300">
                            Event Title
                        </label>
                        <input
                            v-model="form.title"
                            type="text"
                            class="mt-2 w-full rounded-xl border border-white/10 bg-gray-900 px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-all"
                        />
                        <p v-if="form.errors.title" class="mt-2 text-sm text-red-400">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <!-- Description Textarea -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300">
                            Description
                        </label>
                        <textarea
                            v-model="form.description"
                            rows="5"
                            class="mt-2 w-full rounded-xl border border-white/10 bg-gray-900 px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-all"
                        />
                        <p v-if="form.errors.description" class="mt-2 text-sm text-red-400">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <!-- Grid Layout for Tickets & Date (Symmetrical with Create Form) -->
                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Total Tickets Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-300">
                                Total Tickets Available
                            </label>
                            <input
                                v-model="form.total_tickets"
                                type="number"
                                min="1"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-gray-900 px-4 py-3 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-all"
                            />
                            <p v-if="form.errors.total_tickets" class="mt-2 text-sm text-red-400">
                                {{ form.errors.total_tickets }}
                            </p>
                        </div>

                        <!-- Event Date Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-300">
                                Event Date & Time
                            </label>
                            <input
                                v-model="form.event_date"
                                type="datetime-local"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-gray-900 px-4 py-3 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-all [color-scheme:dark]"
                            />
                            <p v-if="form.errors.event_date" class="mt-2 text-sm text-red-400">
                                {{ form.errors.event_date }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="mt-8 flex items-center justify-end gap-3 border-t border-white/10 pt-6">
                    <Link
                        href="/admin/events"
                        class="rounded-xl border border-white/10 px-5 py-3 font-semibold text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 flex items-center justify-center min-w-[140px]"
                    >
                        <span v-if="form.processing" class="flex items-center gap-2">
                            <!-- Spinner Animasi Menggunakan Kod SVG Dalaman -->
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Saving...
                        </span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>