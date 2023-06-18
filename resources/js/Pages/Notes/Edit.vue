<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {defineProps} from 'vue';
import { Link, useForm } from "@inertiajs/vue3";
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    note: Object
});

const form = useForm({
    title: null,
    text: null
})

function storeNote(){
    form.post(route('notes.store'))
}

</script>

<template>
    <AppLayout title="">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Note
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="my-6 p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="storeNote">
                        <TextInput type="text" name="title" v-model="form.title" placeholder="Title" class="w-full" autocomplete="off" :value="note.title"/>
                        <p v-if="form.errors.title" class="text-red-600 text-sm cursor-default">{{ form.errors.title }}</p>

                        <TextArea name="text" rows="10" v-model="form.text" class="w-full mt-5" placeholder="Start typing here..." :value="`${note.text}`"></TextArea>
                        <p v-if="form.errors.text" class="text-red-600 text-sm cursor-default">{{ form.errors.text }}</p>
                        <primary-button class="m-6">Save Note</primary-button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
    {{ note }}
</template>
