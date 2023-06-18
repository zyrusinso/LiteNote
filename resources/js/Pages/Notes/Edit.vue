<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {defineProps, ref, onMounted} from 'vue';
import { Link, useForm } from "@inertiajs/vue3";
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    note: Object
});

const form = useForm({
    title: props.note.title,
    text: props.note.text
})

const noteRef = ref(props.note);

function storeNote(){
    form.put(route('notes.update', props.note))
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
                    <form @submit.prevent="storeNote(note)">
                        <TextInput type="text" name="title" v-model="form.title" placeholder="Title" class="w-full" autocomplete="off"/>
                        <p v-if="form.errors.title" class="text-red-600 text-sm cursor-default">{{ form.errors.title }}</p>

                        <TextArea name="text" rows="10" v-model="form.text" class="w-full mt-5" placeholder="Start typing here..."></TextArea>
                        <p v-if="form.errors.text" class="text-red-600 text-sm cursor-default">{{ form.errors.text }}</p>
                        <primary-button class="m-6">Save Note</primary-button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
