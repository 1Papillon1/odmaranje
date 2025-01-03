@extends('errors::minimal')


<x-guest-layout>
    <!-- Landing Page -->
    <div class="flex flex--home">
        <div class="card card--layout">
            <div class="card__header">
                <h2 class="card__title">RestApp</h2>
            </div>
          
            
            // exception get error message 
            @if($exception->getMessage())
                <p class="card__text">{{ $exception->getMessage() }}</p>
                // get more details 
                @if($exception->getPrevious())
                <p class="card__text">{{ $exception->getPrevious()->getMessage() }}</p>
                @endif
                
            @endif

            <a href="{{ route('guest.home') }}" class="button button--primary">Get back home</a>
           

    </div>
</x-guest-layout>