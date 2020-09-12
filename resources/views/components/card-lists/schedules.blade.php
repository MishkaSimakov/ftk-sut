@foreach($schedules as $schedule)
    @component('components.cards.schedule', ['schedule' => $schedule])@endcomponent
@endforeach

@push('script')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
