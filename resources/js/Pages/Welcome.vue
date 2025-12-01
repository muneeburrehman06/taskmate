<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Organize Your Tasks" />

    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <!-- Header -->
                <header class="flex flex-col md:flex-row items-center justify-between py-6 px-6 md:px-16 bg-white dark:bg-zinc-900 shadow-md">
                    <!-- Brand / Logo Text -->
                    <h1 class="text-3xl font-bold text-[#FF2D20] dark:text-white">
                        TaskMate
                    </h1>

                    <!-- Navigation -->
                    <nav class="mt-4 md:mt-0 flex gap-4">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="px-4 py-2 rounded-md bg-[#FF2D20]/10 text-[#FF2D20] font-medium hover:bg-[#FF2D20]/20 transition">
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link :href="route('login')" class="px-4 py-2 rounded-md bg-[#FF2D20]/10 text-[#FF2D20] font-medium hover:bg-[#FF2D20]/20 transition">
                                Log in
                            </Link>

                            <Link v-if="canRegister" :href="route('register')" class="px-4 py-2 rounded-md bg-[#FF2D20] text-white font-medium hover:bg-[#FF2D20]/90 transition">
                                Sign Up
                            </Link>
                        </template>
                    </nav>
                </header>


                <!-- Main content / Features -->
                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">

                        <!-- TaskMate Docs -->
                        <a id="docs-card" class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                            <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch">
                                <img src="images/taskmate_logo.png" alt="TaskMate Docs" class="aspect-video h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-md" />
                            </div>

                            <div class="relative flex items-center gap-6 lg:items-end">
                                <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                                    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
                                        <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path fill="#FF2D20" d="M3 4h18v16H3z"/></svg>
                                    </div>

                                    <div class="pt-3 sm:pt-5 lg:pt-0">
                                        <h2 class="text-xl font-semibold text-black dark:text-white">Getting Started</h2>
                                        <p class="mt-4 text-sm/relaxed">
                                            TaskMate lets you manage your daily tasks easily. Learn how to add, update, and delete tasks efficiently. Perfect for organizing work, studies, or personal projects.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- Feature Cards -->
                        <a class="flex items-start gap-4 rounded-lg bg-white p-6 shadow ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">📝</div>
                            <div class="pt-3 sm:pt-5">
                                <h2 class="text-xl font-semibold text-black dark:text-white">Add Tasks</h2>
                                <p class="mt-4 text-sm/relaxed">Create new tasks quickly and categorize them for better management.</p>
                            </div>
                        </a>

                        <a class="flex items-start gap-4 rounded-lg bg-white p-6 shadow ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">✏️</div>
                            <div class="pt-3 sm:pt-5">
                                <h2 class="text-xl font-semibold text-black dark:text-white">Update Tasks</h2>
                                <p class="mt-4 text-sm/relaxed">Edit your tasks anytime and keep your workflow up-to-date.</p>
                            </div>
                        </a>

                        <a class="flex items-start gap-4 rounded-lg bg-white p-6 shadow ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">🗑️</div>
                            <div class="pt-3 sm:pt-5">
                                <h2 class="text-xl font-semibold text-black dark:text-white">Delete Tasks</h2>
                                <p class="mt-4 text-sm/relaxed">Remove completed or unnecessary tasks with ease.</p>
                            </div>
                        </a>

                    </div>
                </main>

                <!-- Footer -->
                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    &copy; 2025 TaskMate v1.0. All rights reserved.
                </footer>

            </div>
        </div>
    </div>
</template>
