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
        text: 'You can\'t revert your action',
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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <p class="opacity-60">
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
                            Delete Note
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
