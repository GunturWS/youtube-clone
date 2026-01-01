@extends('layout.app')

@section('content')
<div class="px-6 py-6 bg-nova-dark min-h-screen text-nova-milk">
    <div class="grid grid-cols-12 gap-6">

        <!-- MAIN VIDEO -->
        <div class="col-span-12 lg:col-span-8">
            
            <!-- Video Player -->
            @include('partials.watch.components.video-player')
            
            <!-- Video Actions -->
            @include('partials.watch.components.video-actions')
            
            <!-- Video Description -->
            @include('partials.watch.components.video-description')
            
            <!-- Comment Header -->
            @include('partials.watch.components.comment-header')
            
            <!-- Comment Form -->
            @include('partials.watch.components.comment-form')
            
            <!-- Comments Container -->
            @include('partials.watch.components.comments-container')
            
            <!-- Closing div for comment section -->
            </div>

        </div>

        <!-- Related Videos -->
        @include('partials.watch.components.related-videos')

    </div>
</div>

@push('scripts')
<!-- Include JavaScript Components -->
@include('partials.watch.scripts.video-interactions')
@include('partials.watch.scripts.comment-system')
@endpush
@endsection