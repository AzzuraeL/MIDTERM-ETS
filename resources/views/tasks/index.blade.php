@extends('layouts.app')

@section('title', $project->title . ' Tasks - ' . config('app.name', 'Laravel'))

@section('content')
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $project->title }} - Tasks</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $project->description }}</p>
                </div>
                <a href="{{ route('tasks.create', $project) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                    + New Task
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-100 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif            <!-- Tasks Grid -->
            @if($tasks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tasks as $task)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 
                                    @if($task->priority === 'high') border-red-500
                                    @elseif($task->priority === 'medium') border-yellow-500
                                    @else border-green-500 @endif" id="task-{{ $task->id }}">
                            
                            <div class="flex justify-between items-start mb-3">
                                <!-- Checkbox for task completion -->
                                <button 
                                    onclick="toggleTaskCompletion({{ $task->id }})"
                                    class="focus:outline-none p-0.5 hover:scale-110 transition-transform flex-shrink-0 mt-1"
                                    title="{{ $task->status === 'completed' ? 'Mark as incomplete' : 'Mark as complete' }}"
                                >
                                    @if($task->status === 'completed')
                                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-gray-300 hover:text-gray-400 dark:text-gray-600 dark:hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </button>

                                <div class="flex-1 ml-3">
                                    <h3 class="text-lg font-semibold @if($task->status === 'completed') line-through text-gray-400 dark:text-gray-500 @else text-gray-900 dark:text-white @endif" id="title-{{ $task->id }}">
                                        {{ $task->title }}
                                    </h3>
                                </div>

                                <div class="flex space-x-2 flex-shrink-0">
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-5M19.071 4.929a3 3 0 00-4.242 0l-7.5 7.5a3 3 0 00-.879 2.121v2.829h2.829a3 3 0 002.121-.879l7.5-7.5z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 @if($task->status === 'completed') line-through @endif" id="desc-{{ $task->id }}">
                                {{ Str::limit($task->description, 100) }}
                            </p>

                            <div class="flex justify-between items-center mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($task->status === 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100
                                    @elseif($task->status === 'in_progress') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100
                                    @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 @endif" id="status-{{ $task->id }}">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($task->priority === 'high') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100
                                    @elseif($task->priority === 'medium') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100
                                    @else bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100 @endif">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>

                            @if($task->due_date)
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Due: {{ $task->due_date->format('M j, Y') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No tasks yet</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new task for this project.</p>
                    <div class="mt-6">
                        <a href="{{ route('tasks.create', $project) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                            + New Task
                        </a>
                    </div>
                </div>
            @endif

            <!-- Back to Projects -->
            <div class="mt-8">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Projects
                </a>
            </div>
@endsection

@section('scripts')
                </a>            </div>
        </div>
    </div>    <script>
        function toggleTaskCompletion(taskId) {
            const url = `/tasks/${taskId}/toggle-status`;
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="_token"]')?.value;
            
            const formData = new FormData();
            formData.append('_method', 'PATCH');
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Failed to update task');
            })
            .then(data => {
                // Update the checkbox icon
                const taskCard = document.getElementById(`task-${taskId}`);
                const button = taskCard.querySelector('button');
                const svg = button.querySelector('svg');
                const titleSpan = document.getElementById(`title-${taskId}`);
                const descSpan = document.getElementById(`desc-${taskId}`);
                const statusSpan = document.getElementById(`status-${taskId}`);
                const isDarkMode = document.documentElement.classList.contains('dark');
                
                if (data.completed) {
                    // Mark as completed
                    svg.classList.remove('text-gray-300', 'hover:text-gray-400', 'dark:text-gray-600', 'dark:hover:text-gray-500');
                    svg.classList.add('text-green-500');
                    svg.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />';
                    
                    titleSpan.classList.add('line-through', 'text-gray-400');
                    titleSpan.classList.remove('text-gray-900', 'dark:text-white');
                    titleSpan.classList.add('dark:text-gray-500');
                    
                    descSpan.classList.add('line-through');
                    
                    statusSpan.className = isDarkMode ? 
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-100' :
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                    statusSpan.textContent = 'Completed';
                } else {
                    // Mark as incomplete
                    svg.classList.remove('text-green-500');
                    svg.classList.add('text-gray-300', 'hover:text-gray-400');
                    if (isDarkMode) {
                        svg.classList.add('dark:text-gray-600', 'dark:hover:text-gray-500');
                    }
                    svg.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />';
                    
                    titleSpan.classList.remove('line-through', 'text-gray-400', 'dark:text-gray-500');
                    titleSpan.classList.add('text-gray-900', 'dark:text-white');
                    
                    descSpan.classList.remove('line-through');
                    
                    statusSpan.className = isDarkMode ?
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-700 text-gray-100' :
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                    statusSpan.textContent = 'Pending';
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
