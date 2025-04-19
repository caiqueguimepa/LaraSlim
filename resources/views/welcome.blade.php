<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LaraSlim Framework</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .bg-dots {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
        }

        @media (prefers-color-scheme: dark) {
            .dark\:bg-dots {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
            }
        }
    </style>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">
<div class="relative min-h-screen bg-dots dark:bg-dots">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
            <div class="flex items-center">
                <svg class="w-10 h-10 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
                <span class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">LaraSlim</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="https://github.com/caiquebispo/LaraSlim" class="text-gray-900 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">GitHub</a>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold tracking-tight text-gray-900 dark:text-white">
                The Lightweight PHP Framework
            </h1>

            <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                LaraSlim combines the elegance of Laravel's structure with the simplicity and speed of Slim. Perfect for building lightweight APIs and web applications.
            </p>

            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="https://packagist.org/packages/caiquebispo/laraslim" class="rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Get Started
                </a>
            </div>
        </div>

        <div class="mt-16 sm:mt-20">
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-indigo-600"></div>
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="ml-4 text-sm text-gray-500 dark:text-gray-400">routes/web.php</div>
                    </div>
                    <div class="mt-4">
                            <pre class="text-sm text-gray-800 dark:text-gray-200"><code class="language-php">$app->get('/', function () {
    return view('welcome');
});</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                © 2023 LaraSlim Framework. All rights reserved.
            </div>
            <div class="mt-4 md:mt-0 flex space-x-6">
                <a href="https://github.com/caiquebispo/LaraSlim" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                    <span class="sr-only">GitHub</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </footer>
</div>
</body>
</html>