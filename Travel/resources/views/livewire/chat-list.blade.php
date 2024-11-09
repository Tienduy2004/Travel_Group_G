<div>
    <ul>
        @foreach($users as $user)
            <li wire:click="selectUser({{ $user['id'] }})">
                {{ $user['name'] }}
            </li>
        @endforeach
    </ul>
</div>
