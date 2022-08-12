<div>
    <div class="card mt-3 p-3">
        <p>Код приглашения в Discord</p>

        <div class="row">
            <div class="input-group col-md-9 col-12">
                <label for="invite_code" class="d-none">Код приглашения</label>
                <input wire:key="invite_code" id="invite_code" type="text" class="form-control disabled"
                       wire:model="code" readonly>
            </div>

            <div class="col-md-3 col-12 mt-2 mt-md-0">
                @if(!$code)
                    <button wire:click="generate" class="btn btn-primary w-100">
                        <div wire:loading wire:target="generate">
                            <div class="spinner-border-sm spinner-border" role="status"></div>
                        </div>
                        <div wire:loading.remove wire:target="generate">
                            Сгенерировать
                        </div>
                    </button>
                @else
                    <button wire:click="$emit('copy')" class="btn btn-primary w-100">
                        Скопировать
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('copy', function () {
                console.log("hello world!!!")

                document.getElementById("invite_code").select();
                document.execCommand('copy');
            })
        })
    </script>
@endpush
