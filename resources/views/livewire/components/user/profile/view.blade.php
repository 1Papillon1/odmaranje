<div class="card card--layout">
    <div class="card__header">
        <h4 class="card__title">Profile</h4>
    </div>
    <div class="flex flex--col--1">
    @if (session()->has('success'))
        <div x-data="{ isVisible: true }" x-show="isVisible" class="alert alert--success">
           {{ session('success') }} 
            <button @click="isVisible = false" class="alert__close">
                <img src="/images/close.svg" alt="close" class="alert__close__icon">
            </button>
        </div>
     @endif 

     

        <!-- Username Field -->
        <div class="flex__box flex__box--primary">
            @if($editField === 'name')
               
                    
                    <input type="text" class="form__input" id="name" wire:model.defer="name" placeholder="Enter your name" autofocus @if(!$editField === 'name') disabled @endif>
                    <button class="button button--small" wire:click="save('name')">Save</button>
                    @error('name') <span class="error">{{ $message }}</span> @enderror
            @else
                <span class="text text--b">{{ $user->name ?: 'Not set' }}</span>
                <button class="button button--small" wire:click.prevent="startEditing('name')">Edit</button>
            @endif
        </div>

        <!-- Email Field -->
        <div class="flex__box flex__box--primary">
            @if($editField === 'email')
                <input type="email" id="email" class="form__input" wire:model.defer="email" placeholder="Enter your email" autofocus @if(!$editField === 'email') disabled @endif>
                <button class="button button--small" wire:click="save('email')">Save</button>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            @else
                <span class="text text--b">{{ $user->email ?: 'Not set' }}</span>
                <button class="button button--small" wire:click.prevent="startEditing('email')">Edit</button>
            @endif
        </div>

        <!-- Password Field -->
        <div class="flex__box flex__box--primary">
            @if($editField === 'password')
                <input type="password" id="password" class="form__input" wire:model.defer="password" placeholder="Enter new password" autofocus @if(!$editField === 'password') disabled @endif>
                <button class="button button--small" wire:click="save('password')">Save</button>
                @error('password') <span class="error">{{ $message }}</span> @enderror
            @else
                <span class="text text--b">{{ $password_hidden ?: 'Not set' }}</span>
                <button class="button button--small" wire:click.prevent="startEditing('password')">Edit</button>
            @endif
        </div>

        <!-- User Level and Progress -->
        <div class="flex__box flex__box--event">
            <h3 class="card__subtitle">Level {{ $user_level }}</h3>
            <div class="progress progress--large">
                <span class="progress__number">{{ $user_xp }} / {{ $level_xp }}</span>
                <div class="progress__bar" style="width: {{ $current_xp }}%"></div>
            </div>
        </div>

    
       
    </div>
</div>