<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Swal from 'sweetalert2';

const props = defineProps({
    note: Object,
});

const form = useForm({});

function deleteNote()
{
    Swal.fire({
        title: 'Are you sure?',
        text: 'This note will be moved into a trash!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes Delete it!',
        cancelButtonText: 'No, Keep it!',
        showCloseButton: true,
        showLoaderOnConfirm: true
    }).then((result) => {
        if(result.value) {
            Swal.fire('Deleted', 'You successfully deleted this file', 'success')
            .then((res) => {
                if(res.value){
                    form.delete(route('notes.destroy', props.note));
                }
            })
        }
    })
}
</script>

<template>
    <AppLayout title="">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ note.title }}
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash.message" class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">
                    {{ $page.props.flash.message }}
                </div>

                <div class="flex" v-if="route().current('notes.index')">
                    <a
                        :href="route('notes.index')"
                        class="btn btn-danger"
                        >Back</a
                    >
                    <p class="opacity-60 ml-auto">
                        <strong>Created:</strong> {{ note.created_at }}
                    </p>
                    <p class="opacity-60 ml-8">
                        <strong>Update at:</strong> {{ note.updated_at }}
                    </p>
                    <a
                        :href="route('notes.edit', note)"
                        class="btn-link ml-auto"
                        >Edit Note</a
                    >
                    <form @submit.prevent="deleteNote">
                        <button type="submit" class="btn btn-danger ml-4">
                            Move to trash
                        </button>
                    </form>
                </div>

                <div class="flex" v-if="route().current('trashed.index')">
                    <p class="opacity-60 ml-auto">
                        <strong>Deleted at:</strong> {{ note.deleted_at }}
                    </p>
                    <a
                        :href="route('notes.edit', note)"
                        class="btn-link ml-auto"
                        >Edit Note</a
                    >
                    <form @submit.prevent="deleteNote">
                        <button type="submit" class="btn-link ml-auto">
                            Restore Note
                        </button>
                    </form>

                    <form @submit.prevent="deleteNote">
                        <button type="submit" class="btn btn-danger ml-4">
                            Move to trash
                        </button>
                    </form>
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
