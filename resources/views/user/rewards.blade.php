<x-app-layout>
    <div class="card card--layout">
         <div>
                <h3 class="card__title">Current Streak: {{ $currentStreak }} / 7</h3>
            </div>
        <div class="flex flex--row">
             

           
                @foreach ($rewards as $day => $reward)
                    <div class="flex__box flex__box--20  @if ($day + 1 <= $currentStreak) flex__box--achievement @endif">
                       
                        @if ($day + 1 <= $currentStreak) 
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