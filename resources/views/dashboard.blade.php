@extends('layouts.app')

@section('title', config('app.name', 'Laravel') . ' - Dashboard')

@section('content')
<div class="border-4 border-dashed border-gray-200 dark:border-gray-700 rounded-lg p-8">
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Welcome to Your Task Manager</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-8">Organize your projects and tasks efficiently</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="text-blue-600 dark:text-blue-400 mb-4">
                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Projects</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Manage your projects and track progress</p>
                <a href="{{ route('projects.index') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors">
                    View Projects
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="text-green-600 dark:text-green-400 mb-4">
                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tasks</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Create and manage your tasks</p>
                <a href="{{ route('projects.create') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition-colors">
                    Create Project
                </a>
            </div>
        </div>

        <div class="mt-12 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Overview</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ auth()->user()->projects()->count() ?? 0 }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Total Projects</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                        {{ auth()->user()->projects()->withCount('tasks')->get()->sum('tasks_count') ?? 0 }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400">Total Tasks</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                        {{ auth()->user()->projects()->whereHas('tasks', function($q) { $q->where('status', 'completed'); })->count() ?? 0 }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400">Completed</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
