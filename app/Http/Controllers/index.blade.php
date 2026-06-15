@extends('layouts.app')

@section('title', 'My Notifications')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Notifications</h1>

    @if(session('success'))
        <div style="background-color: rgba(0, 179, 89, 0.1); color: var(--color-secondary); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--color-secondary);">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <ul class="list-group" style="list-style: none; padding: 0;">
            @forelse($notifications as $notification)
                <li class="list-group-item" style="padding: 15px 20px; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; justify-content: space-between; {{ $notification->read_at ? 'background-color: #f8f9fa;' : 'background-color: #ffffff;' }}">
                    <div style="flex-grow: 1;">
                        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 5px; color: {{ $notification->read_at ? 'var(--color-text-muted)' : 'var(--color-text)' }};">
                            {{ $notification->title }}
                        </h3>
                        <p style="font-size: 14px; color: var(--color-text-muted);">
                            {{ $notification->message }}
                        </p>
                        <small style="font-size: 12px; color: var(--color-text-muted);">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                    @unless($notification->read_at)
                        <form action="{{ route('user.notifications.markAsRead', $notification->id) }}" method="POST" style="margin-left: 20px;">
                            @csrf
                            <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                Mark as Read
                            </button>
                        </form>
                    @else
                        <span style="font-size: 12px; color: var(--color-secondary); margin-left: 20px;">Read</span>
                    @endunless
                </li>
            @empty
                <li class="list-group-item" style="text-align: center; padding: 40px; color: var(--color-text-muted);">
                    No new notifications.
                </li>
            @endforelse
        </ul>
        <div style="padding: 20px;">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection