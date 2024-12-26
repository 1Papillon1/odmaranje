<div class="card card--layout">
    <div class="card__header">
        <h4 class="card__title">Edit Profile</h4>

   
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    </div>
    <div class="card__form">
         <div class="form__group">
        <label for="name" class="form__label">Username</label>
        @if($editField === 'name')
         <div class="input-group">
            <input id="name" type="text" class="form__input form__input--60" wire:model.defer="name" autocomplete="username" autofocus @if(!$editField === 'name') disabled @endif>
            <button type="button" class="button button--small" wire:click="save('name')">Save</button>
        </div>      

        @else
         <div class="input-group">
            <p class="form__input form__input--disabled">{{ $name ?: 'Not set' }}</p>
            <button type="button" class="button button--small" wire:click.prevent="startEditing('name')">Edit</button>
        </div>        
        @endif
    </div>

    <!-- E-mail -->
    <div class="form__group">
        <label for="email" class="form__label">E-mail</label>
        @if($editField === 'email')
         <div class="input-group">
            <input id="email" type="email" class="form__input form__input--60" wire:model.defer="email" autocomplete="email" @if(!$editField === 'email') disabled @endif>
            <button type="button" class="button button--small" wire:click.prevent="save('email')">Save</button>
        </div>       
        @else
         <div class="input-group">
            <p class="form__input form__input--disabled">{{ $email ?: 'Not set' }}</p>
            <button type="button" class="button button--small" wire:click="startEditing('email')">Edit</button>
        </div>        
        @endif
    </div>

    <!-- Password -->
    <div class="form__group">
        <label for="password" class="form__label">Password</label>
        @if($editField === 'password')
         <div class="input-group">
            <input id="password" type="password" class="form__input form__input--60" wire:model.defer="password" autocomplete="new-password" @if(!$editField === 'password') disabled @endif>
            <button type="button" class="button button--small" wire:click="save('password')">Save</button>
        </div>       
        @else
         <div class="input-group">
            <p class="form__input form__input--disabled">********</p>
            <button type="button" class="button button--small" wire:click="startEditing('password')">Edit</button>
        </div>        
        @endif
    </div>
    </div>


</div>