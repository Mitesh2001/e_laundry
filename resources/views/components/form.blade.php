<div>
    <div class="basic-form">
        <form action="{{ route($route, $updateId) }}" method="POST" enctype="multipart/form-data"> @csrf
            @if($method)  @method('put') @endif
            {{ $slot }}

            <div class="form-group text-right mt-3">
                <button type="submit" class="btn btn-primary mb-2">{{ $type }}</button>
            </div>
        </form>
    </div>
</div>