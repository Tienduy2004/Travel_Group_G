<div
  class="flex flex-col transition-all h-full overflow-hidden"
  id="chat-container"
  data-query="@entangle('query')"
  data-user-id="{{ Auth::user()->id }}"
>
    <header class="px-3 z-10 bg-white sticky top-0 w-full py-2">
        <div class="border-b justify-between flex items-center pb-2">
            <div class="flex items-center gap-2">
                 <h5 class="font-extrabold text-2xl">Chats</h5>
            </div>
            <button>
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
        </div>

        {{-- Filters --}}
        {{-- <div id="filter-buttons" class="flex gap-3 items-center overflow-x-scroll p-2 bg-white">
            <button data-type="all" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">
                All
            </button>
            <button data-type="deleted" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">
                Deleted
            </button>
        </div> --}}
    </header>

    <main class="overflow-y-scroll overflow-hidden grow h-full relative" style="contain:content">
        {{-- chatlist --}}
        <ul class="p-2 grid w-full spacey-y-2">
            @if ($conversations)
                @foreach ($conversations as $key => $conversation)
                    <li
                      id="conversation-{{$conversation->id}}"
                      wire:key="{{$conversation->id}}"
                      class="py-3 hover:bg-gray-50 rounded-2xl dark:hover:bg-gray-700/70 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 {{$conversation->id == $selectedConversation?->id ? 'bg-gray-100/70' : ''}}">
                        <a href="{{ url('profile?id=' . $conversation->getReceiver()->id) }}" class="shrink-0">
                            <x-avatar src="{{ asset('/img/profile/avatar/' .$conversation->getReceiver()->profile->avatar)}}" />
                        </a>
                        <aside class="grid grid-cols-12 w-full">
                            <a href="{{route('chat', $conversation->id)}}" class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1">
                                <div class="flex justify-between w-full items-center">
                                    <h6 class="truncate font-medium tracking-wider text-gray-900">
                                        {{$conversation->getReceiver()->name}}
                                    </h6>
                                    <small class="text-gray-700">{{$conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans()}} </small>
                                </div>
                                <div class="flex gap-x-2 items-center">
                                    @if ($conversation->messages?->last()?->sender_id == auth()->id())
                                        @if ($conversation->isLastMessageReadByUser())
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                                    <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
                                                    <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/>
                                                </svg>
                                            </span>
                                        @else
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                </svg>
                                            </span>
                                        @endif
                                    @endif
                                    <p class="grow truncate text-sm font-[100]">
                                        {{$conversation->messages?->last()?->body ?? ' '}}
                                    </p>
                                    @if ($conversation->unreadMessagesCount() > 0)
                                        <span class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-blue-500 text-white">
                                            {{$conversation->unreadMessagesCount()}}
                                        </span>
                                    @endif
                                </div>
                            </a>
                            {{-- Dropdown --}}
                            <div class="col-span-1 flex flex-col text-center my-auto">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical w-7 h-7 text-gray-700" viewBox="0 0 16 16">
                                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <div class="w-full p-1">
                                            <a href="{{ url('profile?id=' . $conversation->getReceiver()->id) }}">
                                                <button class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-gray-100 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                                        </svg>
                                                    </span>
                                                    View Profile
                                                </button>
                                            </a>
                                            
                                            <button
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="deleteByUser('{{encrypt($conversation->id)}}')"
                                            class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-gray-100 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">
                                            <span>
                                                <svg viewBox="0 0 20 20" width="20" height="20" fill="currentColor" class="xfx01vb x1lliihq x1tzjh5l x1k90msu x2h7rmj x1qfuztq" style="--color: var(--primary-icon);"><g fill-rule="evenodd" transform="translate(-446 -398)"><g fill-rule="nonzero"><path d="m106.523 196.712-2.32-2.256a1.62 1.62 0 0 0-1.13-.456h-3.146a1.62 1.62 0 0 0-1.13.456l-2.32 2.256a.75.75 0 0 0 1.046 1.076l2.32-2.256a.12.12 0 0 1 .084-.032h3.146a.12.12 0 0 1 .084.032l2.32 2.256a.75.75 0 1 0 1.046-1.076zm-5.773 5.788v8a.75.75 0 1 0 1.5 0v-8a.75.75 0 1 0-1.5 0zm3.501-.047-.5 8a.75.75 0 1 0 1.498.094l.5-8a.75.75 0 1 0-1.498-.094zm-7 .094.5 8a.75.75 0 1 0 1.498-.094l-.5-8a.75.75 0 1 0-1.498.094z" transform="translate(354.5 204)"></path><path d="M109.327 196.5H93.673a1.17 1.17 0 0 0-1.173 1.167v1.666a1.17 1.17 0 0 0 1.173 1.167h15.654a1.17 1.17 0 0 0 1.173-1.167v-1.666a1.17 1.17 0 0 0-1.173-1.167zM109 199H94v-1h15v1z" transform="translate(354.5 204)"></path><path d="M108.25 199a.75.75 0 0 1 .747.818l-1.092 12.011a2.387 2.387 0 0 1-2.377 2.171h-8.056a2.386 2.386 0 0 1-2.377-2.17l-1.092-12.012a.75.75 0 0 1 .747-.818h13.5zm-12.679 1.5 1.018 11.194a.887.887 0 0 0 .883.806h8.056c.459 0 .842-.35.883-.806l1.018-11.194H95.57z" transform="translate(354.5 204)"></path></g></g></svg>
                                            </span>Delete chat</button>
                                        </div>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </aside>
                    </li>
                @endforeach
            @endif
        </ul>
    </main>
</div>
