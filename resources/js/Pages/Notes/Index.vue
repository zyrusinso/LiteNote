<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

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
                    <div v-if="notes.data.length > 0">
                        <div
                            v-for="note in notes.data"
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

        <!-- Paginator -->

        <ol class="flex justify-center gap-1 text-xs font-medium">
            <li v-if="notes.prev_page_url">
                <Link
                    :href="notes.prev_page_url"
                    class="inline-flex h-8 w-12 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180"
                >
                    <span class="sr-only">Prev Page</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </Link>
            </li>

            <!-- Iterate over the available pages -->
            <li v-for="page in notes.links" :key="page.url">
                <Link
                    :href="page.url"
                    class="block h-8 rounded border bg-white text-center leading-8 text-gray-900"
                    :class="[
                            page.active ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-100 bg-white text-gray-900',
                            page.label.length > 4 ? 'hidden' : 'w-8'
                            ]
                    "
                >
                    {{ page.label }}
                </Link>
            </li>

            <li v-if="notes.next_page_url != null || notes.next_page_url">
                <Link
                    :href="notes.next_page_url"
                    class="inline-flex h-8 w-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180"
                >
                    <span class="sr-only">Next Page</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </Link>
            </li>
        </ol>
    </AppLayout>
</template>
