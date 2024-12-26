<div class="flex flex-centered">

    <div class="container">
  
        <img class="container__gif" src="/images/sleeping.gif" alt="sleeping">
    

    </div>

    <div class="progress-bar-container" wire:poll.500ms="updateProgress">
        <div class="progress-bar" style="width: {{$progress}}%;">
           
        </div>
    </div>

    
</div>

