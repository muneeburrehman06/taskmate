<template>
    <h2 class="text-3xl font-bold mb-4">{{ selectedTask ? 'Edit Task' : 'Add New Task' }}</h2>
    
    <form @submit.prevent="submitForm" class="p-6 border rounded-lg bg-gray-50 max-w-lg">
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title*</label>
            <input id="title" type="text" v-model="form.title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
            </div>
        
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" v-model="form.description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
        </div>

        <div v-if="selectedTask" class="mb-4 flex items-center">
            <input id="is_completed" type="checkbox" v-model="form.is_completed" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <label for="is_completed" class="ml-2 block text-sm font-medium text-gray-700">Mark as Completed</label>
        </div>
        
        <div class="mt-4">
            <PrimaryButton :disabled="form.processing">
                {{ selectedTask ? 'Update Task' : 'Create Task' }}
            </PrimaryButton>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'; // Assuming this component exists

const props = defineProps({
    selectedTask: Object, 
});

const emit = defineEmits(['saveTask']); 

// Initialize the form data structure
const form = useForm({
    title: '',
    description: '',
    is_completed: false, 
});

// Watch for the selectedTask prop change (for Edit mode)
watch(() => props.selectedTask, (newTask) => {
    if (newTask) {
        form.title = newTask.title;
        form.description = newTask.description;
        form.is_completed = newTask.is_completed;
    } else {
        form.reset(); 
    }
}, { immediate: true });


const submitForm = () => {
    if (props.selectedTask) {
        // UPDATE (PUT) request
        form.put(route('tasks.update', props.selectedTask.id), {
            onSuccess: () => {
                emit('saveTask'); 
            },
        });
    } else {
        // ADD (POST) request
        form.post(route('tasks.store'), {
            onSuccess: () => {
                form.reset();
                emit('saveTask'); 
            },
        });
    }
};
</script>