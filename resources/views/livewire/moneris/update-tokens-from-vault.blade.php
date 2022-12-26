<div>

    <!-- TODO - Show Progress Bar -->
    
    @if($tokenCount !== 0)

    <div class="flex items-center">

        <p>There are <strong >{{ $tokenCount }}</strong> tokens in the database without details.</p>

        <x-jet-button 
            wire:click="updateTokens" 
            wire:loading.class="opacity-50"
            wire:target="updateTokens"
            type="submit" 
            class="ml-3">
            
            Update Tokens
        
        </x-jet-button>

    </div>

    @endif

</div>
