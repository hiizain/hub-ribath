@extends('../../../layouts/app')

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
                        <th scope="col">No. HP</th>
                        <th scope="col">Nama Paket</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sewa as $item)
                        <tr>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->paket->nama_paket }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>
                                @if ($item->is_accepted == '0')
                                    <div class="dropdown">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li>
                                                <form id="terimaAksi" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id_sewa" value="{{ $item->id }}">
                                                    <input type="hidden" name="value" value="1">
                                                    <button class="btn btn-success mx-2 my-1">Terima</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form id="tolakAksi" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id_sewa" value="{{ $item->id }}">
                                                    <input type="hidden" name="value" value="2">
                                                    <button class="btn btn-danger mx-2 my-1">Tolak</button>
                                                </form>
                                            </li>
                                            {{-- <li><a class="dropdown-item" href="#">Terima</a></li>
                                    <li><a class="dropdown-item" href="#">Tolak</a></li> --}}
                                        </ul>
                                    </div>
                                @else
                                    @if ($item->is_accepted == '1')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($item->is_accepted == '2')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const site_url = '{{ url('') }}';
        $('#terimaAksi').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                icon: "question",
                title: "Peringatan",
                text: "Apakah Anda yakin ingin menerima sewa paket?",
                showCancelButton: true,
                cancelButtonText: "Tidak",
                confirmButtonText: "Ya",
                confirmButtonColor: "#008080",
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'ajax',
                        method: 'POST',
                        url: `${site_url}/back/layanan/sewa/aksi`,
                        // data: $('#detailProgram').serialize(),
                        // data: {

                        // },
                        data: new FormData($('#terimaAksi')[0]),
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        // beforeSend: function () { },
                        success: function(response) {
                            // console.log(response);
                            if ((response.status === 'error')) {
                                Swal.fire('Gagal!',
                                    'Aplikasi gagal terhubung dengan server. Silahkan hubungi admin.',
                                    'error');
                            }
                            if (response.status == 'success') {
                                Swal.fire('Sewa paket diterima!', response.message, 'success')
                                    .then(function() {
                                        location.href = site_url + '/back/layanan/sewa';
                                    })
                            }
                        },
                        error: function(xmlhttprequest, textstatus, message) {
                            // text status value : abort, error, parseerror, timeout
                            // default xmlhttprequest = xmlhttprequest.responseJSON.message

                            Swal.fire('Gagal!', xmlhttprequest.responseJSON.message, 'error');
                            // console.log(xmlhttprequest.responseJSON);
                        },
                    });
                }
            });
        });
        $('#tolakAksi').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                icon: "question",
                title: "Peringatan",
                text: "Apakah Anda yakin ingin menolak sewa paket?",
                showCancelButton: true,
                cancelButtonText: "Tidak",
                confirmButtonText: "Ya",
                confirmButtonColor: "#008080",
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'ajax',
                        method: 'POST',
                        url: `${site_url}/back/layanan/sewa/aksi`,
                        // data: $('#detailProgram').serialize(),
                        // data: {

                        // },
                        data: new FormData($('#tolakAksi')[0]),
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        // beforeSend: function () { },
                        success: function(response) {
                            // console.log(response);
                            if ((response.status === 'error')) {
                                Swal.fire('Gagal!',
                                    'Aplikasi gagal terhubung dengan server. Silahkan hubungi admin.',
                                    'error');
                            }
                            if (response.status == 'success') {
                                Swal.fire('Sewa paket ditolak!', response.message, 'success')
                                    .then(function() {
                                        location.href = site_url + '/back/layanan/sewa';
                                    })
                            }
                        },
                        error: function(xmlhttprequest, textstatus, message) {
                            // text status value : abort, error, parseerror, timeout
                            // default xmlhttprequest = xmlhttprequest.responseJSON.message

                            Swal.fire('Gagal!', xmlhttprequest.responseJSON.message, 'error');
                            // console.log(xmlhttprequest.responseJSON);
                        },
                    });
                }
            });
        });
    </script>
@endsection
