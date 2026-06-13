<script setup  lang="ts">
import axios from 'axios'
import { ref } from 'vue'

const props = defineProps({
    event: {
        type: Object,
        required: true,
    },
})

const remainingTickets = ref(props.event.remaining_tickets)
const message = ref('')
const error = ref('')
const isBuying = ref(false)

const buyTicket = async () => {
    message.value = ''
    error.value = ''
    isBuying.value = true

    try {
        await axios.post(`/events/${props.event.id}/purchase`)

        remainingTickets.value = Math.max(remainingTickets.value - 1, 0)
        message.value = 'Ticket purchased successfully!'
    } catch (e) {
        error.value =
            e.response?.data?.message || 'Unable to purchase ticket. It may be sold out.'
    } finally {
        isBuying.value = false
    }
}
</script>

<template>
    <div class="min-h-screen bg-gray-100 px-6 py-10">
        <div class="mx-auto max-w-3xl">
            <div class="rounded-2xl bg-white p-8 shadow">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ event.title }}
                </h1>

                <p class="mt-3 text-gray-600">
                    {{ event.description }}
                </p>

                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl bg-gray-50 p-5 text-center">
                        <p class="text-sm text-gray-500">Total Tickets</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ event.total_tickets }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-green-50 p-5 text-center">
                        <p class="text-sm text-green-700">Remaining</p>
                        <p class="mt-2 text-3xl font-bold text-green-700">
                            {{ remainingTickets }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-red-50 p-5 text-center">
                        <p class="text-sm text-red-700">Sold</p>
                        <p class="mt-2 text-3xl font-bold text-red-700">
                            {{ event.total_tickets - remainingTickets }}
                        </p>
                    </div>
                </div>

                <div class="mt-8">
                    <button
                        type="button"
                        :disabled="isBuying || remainingTickets <= 0"
                        @click="buyTicket"
                        class="rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white shadow hover:bg-indigo-700 disabled:cursor-not-allowed disabled:bg-gray-400"
                    >
                        <span v-if="isBuying">Processing...</span>
                        <span v-else-if="remainingTickets <= 0">Sold Out</span>
                        <span v-else>Buy Ticket</span>
                    </button>
                </div>

                <p v-if="message" class="mt-5 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ message }}
                </p>

                <p v-if="error" class="mt-5 rounded-lg bg-red-100 p-4 text-red-700">
                    {{ error }}
                </p>
            </div>
        </div>
    </div>
</template>