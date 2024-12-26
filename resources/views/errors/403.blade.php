@extends('errors::minimal')


<x-guest-layout>
    <!-- Landing Page -->
    <div class="flex flex--home">
        <div class="card card--layout">
            <div class="card__header">
                <h2 class="card__title">Forbidden</h2>
            </div>
          
            
            // exception get error message 
            @if($exception->getMessage())
                <p class="card__text">{{ $exception->getMessage() }}</p>
            @endif
           

    </div>
</x-guest-layout>