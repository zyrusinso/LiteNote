<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    notes: Object,
});
</script>

<template>
    <AppLayout title="Notes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                All Notes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div v-if="notes.length > 0">
                        <div
                            v-for="note in notes"
                            :key="note.id"
                            class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg"
                        >
                            <h2 class="font-bold text-2xl">
                                {{ note.title }}
                            </h2>
                            <p class="mt-2">
                                {{ note.text }}
                            </p>
                            <span class="block mt-4 text-sm opacity-70">
                                {{ note.updated_at }}
                            </span>
                        </div>
                    </div>
                    <div v-else class="text-center text-2xl font-bold">
                        <p>You have no Notes yet!</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
