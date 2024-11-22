<div class="flex flex-col gap-6 p-6 text-white">
    @foreach ($birthdays as $month => $people)
        <div class="p-4 rounded-lg bg-zinc-800/50">
            <h2 class="text-xl font-semibold mb-2">
                Tháng {{ $month }}
            </h2>
            <div class="space-y-4">
                <div class="text-sm text-zinc-300">
                    @foreach ($people as $index => $person)
                        {{ $person->name }}
                        @if ($index < min(1, count($people) - 1))
                            ,
                        @endif
                    @endforeach
                    @if (count($people) > 2)
                        và {{ count($people) - 2 }} người khác
                    @endif
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($people as $person)
                        <div class="relative w-12 h-12 rounded-full overflow-hidden bg-zinc-700">
                            @if (isset($person->avatar))
                                <img src="{{ asset('/img/profile/avatar/' .$person->avatar) }}" alt="{{ $person->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-zinc-600">
                                    {{ substr($person->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>