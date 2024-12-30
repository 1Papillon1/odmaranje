<x-app-layout>
    <div class="card card--layout">
         <div>
                <h3 class="card__title">Current Streak: {{ $currentStreak }} / 7</h3>
            </div>
        <div class="flex flex--row" style="justify-content: center; align-items: center; width: 100%;">
             

           
                @foreach ($rewards as $day => $reward)
                    <div class="flex__box flex__box--reward  @if ($day + 1 <= $currentStreak) flex__box--achievement @endif">
                       
                        @if ($day + 1 <= $currentStreak) {{-- Ispravljen uslov --}}
                               <div class="wrapper" style="position: relative;">
                                <img src="/images/tick.svg" alt="Completed" class="icon">
                               </div>
                            @endif
                        
                        <h3 class="card__title">Day {{ $day + 1 }}</h3>
                        <h4 class="card__subtitle">{{ $reward }} $REST</h4>
                        
                           
                    </div>
                @endforeach
            
            

        </div>

        </div>
</x-app-layout> 