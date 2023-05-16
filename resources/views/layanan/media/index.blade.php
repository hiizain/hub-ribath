@extends('../../layouts/app-front')

@section('container')
    <div class="container my-5 pt-5">
        <div class="row d-flex justify-content-center">
            <h1 class="text-center">Layanan Sewa Alat Media</h1>
        </div>
        <hr>
        <div class="row d-flex justify-content-end mb-2">
            <div class="col-4">
                <div class="row">
                    <label for="cek">Cek permintaan sewa Anda disini.</label>
                </div>
                <div class="d-flex flex-row">
                    <input type="text" class="form-control me-2" name="cek" id="cek"
                        placeholder="Masukkan nomor HP">
                    <button class="btn btn-primary me-1" id="cekButton">Cek</button>
                    <button class="btn btn-primary" id="hideButton">Hide</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="cekItem"></div>
        </div>
        <div class="row mt-4">
            @foreach ($paket as $item)
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama_paket }}</h5>
                            <p class="card-text">{{ $item->deskripsi }}</p>
                            <h5 class="card-title">{{ $item->harga }}</h5>
                            <div class="d-flex justify-content-end">
                                {{-- <form action="{{ route('program.daftar', ['programId'=>{{ $item->id }}, 'userId'=>{{ Auth::id() }}]) }}" method="get">
                                @csrf
                                <input type="hidden" name="program_id" value="{{ $item->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            </form> --}}
                                <button type="button" id="pesanButton" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" onclick="pesanButton({{ $item->id }})">
                                    Pesan Sekarang
                                </button>
                                {{-- <a href="" class="btn btn-primary">Pesan Sekarang</a> --}}
                                {{-- <a href="{{ route('user.layanan.sewa', ['idPaket'=>$item->id]) }}" class="btn btn-primary">Pesan Sekarang</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sewa Alat Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sewaMedia">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_paket" id="id_paket">
                        <div class="form-group mb-3">
                            <h5>No HP</h5>
                            <input class="form-control" type="number" name="no_hp">
                        </div>
                        <div class="form-group mb-3">
                            <h5>Tanggal</h5>
                            <input class="form-control" type="text" id="datePick" name="tanggal">
                        </div>
                        {{-- <div class="form-group mb-3">
                            <h5>Lokasi</h5>
                            <input class="form-control" type="text" name="lokasi">
                        </div>
                        <div class="form-group mb-3">
                            <h5>Detail Lokasi</h5>
                            <textarea class="form-control" name="detail_lokasi"></textarea>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const site_url = '{{ url('') }}';
        let tanggalInvalid = [];
        // const tanggal = '<?php echo json_encode($tanggalInvalid); ?>';
        // const tanggalInvalid = JSON.parse(tanggal);
        // console.log(tanggalInvalid);
        $('#sewaMedia').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                icon: "question",
                title: "Peringatan",
                text: "Apakah data yang Anda masukkan sudah benar?",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Ya",
                confirmButtonColor: "#008080",
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'ajax',
                        method: 'POST',
                        url: `${site_url}/layanan/sewa`,
                        // data: $('#detailProgram').serialize(),
                        // data: {

                        // },
                        data: new FormData($('#sewaMedia')[0]),
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
                                Swal.fire('Update Berhasil!', response.message, 'success').then(
                                    function() {
                                        location.href = site_url + '/layanan/sewa';
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

        $('#cekButton').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: `${site_url}/layanan/sewa/cek`,
                data: {
                    _token: "{{ csrf_token() }}",
                    val: $('#cek').val()
                },
                success: function(response) {
                    table = `
                    <div class="card p-3">
                        <div class="row card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No Hp</th>
                                        <th scope="col">Paket</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                    response.data.forEach((element) => {
                        table += `
                                    <tr>
                                        <td>${element.no_hp}</td>
                                        <td>${element.nama_paket}</td>
                                        <td>${element.deskripsi}</td>
                                        <td>${element.tanggal}</td>
                                        <td>`
                        if (element.is_accepted == '0') {
                            table +=
                                `<span class="badge bg-warning">Menunggu Konfirmasi</span>`;
                        } else if (element.is_accepted == '1') {
                            table += `<span class="badge bg-success">Diterima</span>`;
                        } else if (element.is_accepted == '2') {
                            table += `<span class="badge bg-danger">Ditolak</span>`;
                        }
                        table += `
                                        </td>
                                    </tr>
                        `;
                    });
                    table += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                    `;
                    $('#cekItem').html(table);
                }
            });
        });
        $('#hideButton').click(function(e) {
            e.preventDefault();
            $('#cekItem').html('');
        });

        function pesanButton(val) {
            $('#id_paket').val(val);
            tanggalInvalid = [];
            $.ajax({
                type: "post",
                url: `${site_url}/layanan/sewa/cek-tanggal`,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $('#id_paket').val(),
                },
                success: function(response) {
                    if (response.status == 'success') {
                        for (let i = 0; i < response.data.length; i++) {
                            tanggalInvalid.push(response.data[i]);
                        }
                    }
                }
            });
        }

        $('#datePick').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-D'
            },
            isInvalidDate: function(date) {
                if (tanggalInvalid.includes(date.format('YYYY-MM-D'))) {
                    return true;
                }
            }
        });
    </script>
@endsection
