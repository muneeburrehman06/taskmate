<template>
    <h2 class="text-3xl font-bold mb-4">Your Task List</h2>
    
    <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 w-1/12">Done</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 w-4/12">Title</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 w-5/12">Description</th>
                    <th class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900 w-2/12">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="task in tasks" :key="task.id" :class="{ 'bg-green-50': task.is_completed }">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                        <input type="checkbox" :checked="task.is_completed" @change="toggleCompletion(task)" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm" :class="{ 'line-through text-gray-500': task.is_completed }">{{ task.title }}</td>
                    <td class="px-3 py-4 text-sm text-gray-500" :class="{ 'line-through': task.is_completed }">{{ task.description }}</td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium">
                        <button @click="$emit('editTask', task)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                        <button @click="$emit('deleteTask', task.id)" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
                <tr v-if="tasks.length === 0">
                    <td colspan="4" class="py-4 text-center text-gray-500 italic">No tasks found. Click "Add Task" in the sidebar to create one!</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'; 

const props = defineProps({
    tasks: Array, 
});

const emit = defineEmits(['editTask', 'deleteTask']);

// Handler for the is_completed toggle (PUT request)
const toggleCompletion = (task) => {
    router.put(route('tasks.update', task.id), {
        is_completed: !task.is_completed, 
        title: task.title, 
    }, {
        preserveScroll: true,
    });
};
</script>