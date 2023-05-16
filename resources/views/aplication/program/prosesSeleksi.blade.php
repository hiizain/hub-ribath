@extends('../../layouts/app')

@section('container')
<div class="row my-5 mx-4">
    <div class="col-12 p-0">
        <div class="row">
            <div class="col-6">
                <h4 class="p-0 m-0">
                    Data Table
                </h4>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="" class="btn btn-primary">Seleksi</a>
            </div>
        </div>
    </div>
    <div class="col-12 p-0 mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">NIK</th>
                    <th scope="col">Nama Santri</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No. HP Wali</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peserta as $item)
                    <tr>
                        <td>{{ $item->santri->nik }}</td>
                        <td>{{ $item->santri->nama }}</td>
                        <td>{{ $item->santri->alamat }}</td>
                        <td>{{ $item->santri->no_hp_wali }}</td>
                    </tr>
                    <?php $no++; ?>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $peserta->links() !!}
        </div>
    </div>
</div>

@endsection    