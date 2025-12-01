<template>
  <AppLayout title="Task Manager">
    <div class="flex min-h-screen">
      <div class="w-64 bg-gray-100 p-4">
        <h2 class="text-xl font-bold mb-6">Tasks</h2>
        
        <button @click="showList()" 
                class="block w-full text-left px-4 py-2 mb-2 rounded hover:bg-gray-200"
                :class="{'bg-gray-300': currentView==='list'}">
          List Tasks
        </button>
        
        <button @click="showAdd()" 
                class="block w-full text-left px-4 py-2 mb-2 rounded hover:bg-gray-200"
                :class="{'bg-gray-300': currentView==='add'}">
          Add Task
        </button>
      </div>

      <div class="flex-1 p-6 bg-white">
        <component 
          :is="currentViewComponent" 
          :tasks="props.tasks" 
          :selected-task="selectedTask"
          @edit-task="handleEditTask"
          @save-task="handleSaveTask"
          @delete-task="handleDeleteTask"
        />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3'; 
import AppLayout from '@/Layouts/AppLayout.vue'; 
// Import sibling components using the local relative path:
import Index from './sample_index.vue';     
import AddTask from './AddTask.vue'; 

// --- 1. Dynamic Data Prop from Laravel Controller ---
const props = defineProps({
  tasks: {
    type: Array,
    required: true,
    default: () => []
  }
});

// --- 2. Local State for View Management ---
const currentView = ref('list');
const selectedTask = ref(null); 

const currentViewComponent = computed(() => 
    currentView.value === 'list' ? Index : AddTask
);

// --- 3. Sidebar/View Actions ---
const showList = () => {
  selectedTask.value = null; 
  currentView.value = 'list';
};

const showAdd = () => {
  selectedTask.value = null; 
  currentView.value = 'add';
};

// --- 4. Handlers for Child Component Events ---

// 4a. Handles 'edit-task' emitted from Index.vue
const handleEditTask = (task) => {
  selectedTask.value = task;
  currentView.value = 'add'; 
};

// 4b. Handles 'save-task' emitted from AddTask.vue after Inertia submission
const handleSaveTask = () => {
  selectedTask.value = null;
  currentView.value = 'list'; 
};

// 4c. Handles 'delete-task' emitted from Index.vue
const handleDeleteTask = (id) => {
  if (confirm('Are you sure you want to permanently delete this task?')) {
    router.delete(route('tasks.destroy', id), {
      preserveScroll: true,
    });
  }
};
</script>