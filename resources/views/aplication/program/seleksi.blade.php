@extends('../../layouts/app')

@section('container')
<div class="row my-5 mx-4">
    <div class="col-12 p-0">
        <h4 class="p-0 m-0">
            Data Table
        </h4>
    </div>
    <div class="col-12 p-0 mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Program</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;?>
                @foreach ($program as $item)
                    <tr>
                        <th scope="row">{{ $no }}</th>
                        <td>{{ $item->nama_program.' '.$item->tahun }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>
                            <a href="{{ route('back.program.seleksi.show', $item->id) }}" class="btn btn-primary">Seleksi</a>
                        </td>
                    </tr>
                    <?php $no++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection    