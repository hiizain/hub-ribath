@extends('../../layouts/app-front')

@section('container')
<div class="container my-5 pt-5">
    <div class="row d-flex justify-content-center">
        <h1 class="text-center">Program Pendidikan</h1>
    </div>
    <hr class="mb-5">
    <div class="row">
        @foreach($program as $item)
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->nama_program.' '.$item->tahun }}</h5>
                        <p class="card-text">{{ $item->deskripsi }}</p>
                        <div class="d-flex justify-content-end">
                            {{-- <form action="{{ route('program.daftar', ['programId'=>{{ $item->id }}, 'userId'=>{{ Auth::id() }}]) }}" method="get">
                                @csrf
                                <input type="hidden" name="program_id" value="{{ $item->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            </form> --}}
                            <a href="{{ route('program.daftar', ['programId'=>$item->program_id, 'userId'=>Auth::id()]) }}" class="btn btn-primary">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script>

</script>
@endsection    
