<div class="d-flex flex-row justify-content-end">
    <form action="{{ route('pricescore::instance.edit') }}" method="GET">
        @csrf
        <input type="hidden" name="instance" value="{{ $id }}">
        <button class="btn btn-primary mx-1"><i class="fas fa-pen"></i></button>
    </form>

    <form action="{{ route('pricescore::instance.delete.post') }}" method="POST">
        @csrf
        <input type="hidden" name="instance" value="{{ $id }}">
        <button class="btn btn-danger confirmdelete mx-1"><i class="fas fa-trash"></i></button>
    </form>
</div>