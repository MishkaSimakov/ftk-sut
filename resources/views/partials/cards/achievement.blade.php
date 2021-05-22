<li class="list-group-item d-md-flex align-items-center">
    <div class="col-md-6">
        <div class="text-nowrap">{{ $achievement->name }}</div>
        <div class="text-muted">{{ $achievement->description }}</div>
    </div>

    @auth
        <div class="col-md-6 ml-auto mt-2 mt-md-0">
            <div class="progress">
                @if($progress = auth()->user()->achievementStatus($achievement->getClass()))
                    <div
                        class="progress-bar {{ $progress->isUnlocked() ? 'bg-success' : 'bg-secondary' }}"
                        role="progressbar"
                        style="width: {{ $progress->points / $achievement->points * 100 }}%;"
                    ></div>

                    <div class="position-absolute" style="top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%);">
                        {{ $progress->points }}/{{ $achievement->points }}
                    </div>
                @endif
            </div>
        </div>
    @endauth
</li>
