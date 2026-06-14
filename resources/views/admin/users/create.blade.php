@extends('admin.layouts.admin')

@section('title', 'Add New User - TSEA Admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Add New User</h1>
            <p class="text-sm text-gray-500 mt-1">Create a new account with specific roles and permissions.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i> Back to Directory
            </a>
        </div>
    </div>

    <div class="max-w-3xl mx-auto">
        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                                   placeholder="e.g. John Doe">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror"
                                   placeholder="john@example.com">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-1">System Role</label>
                            <select name="role" id="role" required
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('role') border-red-500 @enderror">
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select a role</option>
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Regular User</option>
                                <option value="employer" {{ old('role') === 'employer' ? 'selected' : '' }}>Employer</option>
                                <option value="instructor" {{ old('role') === 'instructor' ? 'selected' : '' }}>Instructor</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Initial Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                       class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror"
                                       placeholder="••••••••">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 italic">User will be created with an "Active" and "Verified" status by default.</p>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            <i class="fas fa-user-plus mr-2"></i> Create User Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection