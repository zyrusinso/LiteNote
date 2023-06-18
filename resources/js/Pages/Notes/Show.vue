<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    note: Object,
});
</script>

<template>
    <AppLayout title="">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ note.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <p class="opacity-60">
                        <strong>Created:</strong> {{ note.created_at }}
                    </p>
                    <p class="opacity-60 ml-8">
                        <strong>Update at:</strong> {{ note.updated_at }}
                    </p>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div
                        class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg"
                    >
                        <h2 class="font-bold text-4xl">
                            {{ note.title }}
                        </h2>
                        <p class="mt-6 whitespace-pre-wrap">{{ note.text }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
